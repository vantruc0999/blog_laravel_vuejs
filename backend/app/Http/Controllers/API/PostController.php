<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Blogger;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    //
    public function getAllActivePost()
    {
        $posts = Post::where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $posts = $this->getAllOverviewPosts($posts);

        return response([
            "message" => "success",
            "data" => $posts
        ]);
    }

    private function getAllOverviewPosts($posts)
    {
        foreach ($posts as $post) {
            $post->category_name = $post->category->name;
            $post->blogger_infor = $this->getBloggerInfor($post->blogger);
            $post->comment_count = $post->comments->count();
            $post->likes_count = $post->likes->makeHidden(['created_at', 'updated_at'])->count();
            $post->saves = $post->saves->makeHidden(['created_at', 'updated_at']);
            // $post->tags = $post->tags->makeHidden(['created_at', 'updated_at']);
            unset($post->blogger, $post->category, $post->description, $post->comments);
        }

        return $posts;
    }

    private function getCommentInfors($comments)
    {
        foreach ($comments as $item) {
            $item->blogger_name = $item->blogger->name;
            $item->blogger_image = $item->blogger->profile_image;
            unset($item->blogger, $item->post_id, $item->updated_at);
        }
        return $comments;
    }

    private function getBloggerInfor($blogger)
    {
        $blogger = $blogger->makeHidden(
            'address',
            'phone',
            'gender',
            'birthday',
            'created_at',
            'updated_at',
            'banner',
            'password'
        );

        $totalView = Post::where(
            [
                'blogger_id' => $blogger->id,
                'status' => 1
            ]
        )->sum('view_count');

        $blogger->total_view = (int)$totalView;

        return $blogger;
    }

    private function getTagsInfor($tags)
    {
        foreach ($tags as $item) {
            $item->category_name = $item->category->name;
            unset($item->created_at, $item->updated_at, $item->pivot, $item->category);
        }
        return $tags;
    }

    public function getAllCategories()
    {
        $categories = Category::all();

        return response([
            "message" => "success",
            "data" => $categories
        ]);
    }

    public function getAllTags()
    {
        $tags = Tag::all();

        foreach ($tags as $item) {
            $item->category_name = $item->category->name;
            unset($item->category);
        }

        return response([
            "message" => "success",
            "data" => $tags
        ]);
    }

    private function checkActivePost($id)
    {
        $post = Post::where(
            [
                'id' => $id,
                'status' => 1,
            ]
        )->first();

        if (!$post) {
            return false;
        }

        return $post;
    }

    private function handleCommentByPost($id)
    {
        $comments = Comment::with(['replies.blogger' => function ($query) {
            $query->select(['id', 'name', 'email', 'profile_image']);
        }])
            ->where('post_id', $id)
            ->whereNull('parent_id')
            ->get()
            ->each(function ($comment) {
                $comment->replies->makeHidden(['updated_at', 'blogger']);
                $comment->replies->each(function ($item) {
                    $item->blogger_name = $item->blogger->name;
                    $item->blogger_email = $item->blogger->email;
                    $item->blogger_image = $item->blogger->profile_image;
                });
            });

        return $this->getCommentInfors($comments);
    }

    public function getDetailPostById($id)
    {
        $post = $this->checkActivePost($id);
        // return $post->blogger;
        if (!$post) {
            return response()->json([
                'message' => 'No post available',
            ], 500);
        }

        try {
            $post->update([
                'view_count' => ++$post->view_count
            ]);

            $post->category_name = $post->category->name;
            $post->blogger_name = $post->blogger->name;
            $post->likes_count = $post->likes->count();
            $post->comments = $this->handleCommentByPost($id);
            $post->tags = $this->getTagsInfor($post->tags);
            $post->blogger_infor = $this->getBloggerInfor($post->blogger);

            unset($post->blogger_infor->password);

            $tmp_created_date = new Carbon($post->created_at);
            $tmp_updated_date = new Carbon($post->created_at);
            $dt['created'] = $tmp_created_date->format('Y-m-d H:i:s');
            $dt['updated'] = $tmp_updated_date->format('Y-m-d H:i:s');

            $post = json_decode($post);
            $post->created_at = $dt['created'];
            $post->updated_at = $dt['updated'];

            unset($post->blogger_name, $post->category, $post->blogger_id, $post->blogger);

            $category_id = $post->category_id;

            $relavantPosts = $this->getRelevantPosts($category_id, $post->id);

            $post->relavant_posts = $relavantPosts;

            return response([
                "message" => "success",
                "data" => $post
            ]);
        } catch (\Exception $err) {

            return response()->json([
                'message' => 'An error occurred while getting post',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    private function getRelevantPosts($category_id, $post_id)
    {
        return $this->getAllOverviewPosts(
            Category::find($category_id)
                ->posts()
                ->where('id', '!=', $post_id)
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get()
        );
    }

    public function handleStore($request, $status)
    {
        try {
            $slug = Str::slug($request->title);

            if ($request->has('banner')) {
                $image = $request->banner;
                $name = time() . '-' . $image->getClientOriginalName();
                $path = public_path('storage');
                $image->move($path, $name);
                $newPath = $name;
            }

            $data = [
                'title' => $request->input('title'),
                'intro' => $request->input('intro'),
                'description' => $request->input('description'),
                'banner' => $newPath ?? 'default.jpg',
                'blogger_id' => Auth::user()['id'],
                'category_id' => $request->input('category_id'),
                'new_post' => 0,
                'highlight' => 0,
                'view_count' => 0,
                'status' => $status,
            ];

            $tags = json_decode(str_replace("'", '"', $request->input('tags')));

            $data['slug'] = Str::slug($slug) . "-" . time();

            $post = Post::create($data);

            $post->tags()->sync($tags);

            return response()->json([
                'message' => 'Post created successfully',
                'post' => $post
            ], 201);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while creating post',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function store(AddPostRequest $request)
    {
        return $this->handleStore($request, 0);
    }

    public function storeDraft(AddPostRequest $request)
    {
        return $this->handleStore($request, 3);
    }

    public function publishDraft($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->blogger_id != Auth::user()['id']) {
                return response([
                    'message' => 'You do not have permission to publish this post',
                ]);
            }

            if ($post->status == 3) {
                $post->update(['status' => 0]);
                return response([
                    'message' => 'Publish successfully',
                ]);
            } else {
                return response([
                    'message' => 'This post is already published',
                ]);
            }
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while publishing post',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            if (!$post) {
                return response()->json([
                    'message' => 'No post available',
                ], 500);
            }

            if (Auth::user()['id'] !== $post->blogger_id) {
                return response()->json([
                    'message' => 'You do not have permission to edit this post',
                ], 400);
            }

            $data = [
                'title' => $request->input('title'),
                'intro' => $request->input('intro'),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
            ];

            if ($request->has('banner')) {
                $image = $request->banner;
                $name = time() . '-' . $image->getClientOriginalName();
                $path = public_path('storage');
                $image->move($path, $name);
                $newPath = $name;
                $data['banner'] = $newPath;
            }

            // if ($request->input('title') && $request->input('title') != $post->title) {
            //     $slug = Str::slug($request->title);
            //     $data['slug'] = Str::slug($slug) . "-" . time() . $post->id;
            // }

            if ($request->input('title')) {
                $slug = Str::slug($request->title);
                $data['slug'] = Str::slug($slug) . "-" . time() . $post->id;
            }

            if ($request->input('tags')) {
                $tags = json_decode(str_replace("'", '"', $request->input('tags')));
                $post->tags()->sync($tags);
            }

            $post->update($data);

            return response()->json([
                'message' => 'Post updated successfully',
                'post' => $post
            ], 201);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while updating post',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $post = Post::findOrFail($id);

            if (!$post) {
                return response()->json([
                    'message' => 'No post available',
                ], 500);
            }

            if (Auth::user()['id'] !== $post->blogger_id) {
                return response()->json([
                    'message' => 'You do not have permission to delete this post',
                ], 400);
            }

            $post->delete();

            return response()->json([
                'message' => 'Post deleted successfully',
                'post' => $post
            ], 201);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while deleting post',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function getTagsCategories()
    {
        $categories = Category::all();

        foreach ($categories as $item) {
            $item->tags = Category::find($item->id)->tags;
        }

        return $categories;
    }

    public function getPostsByTagId($id)
    {
        try {
            $tags = Tag::find($id);
            if (!$tags) {
                return response([
                    'message' => 'No tags available'
                ]);
            }
            $posts = $tags->posts;

            $posts = $this->getAllOverviewPosts($posts);

            return response([
                'posts' => $posts
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while getting post tags',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function getMostLikePosts()
    {
        $postsWithLikeCount = Post::where('status', 1)
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->get();

        $postsWithLikeCount = $this->getAllOverviewPosts($postsWithLikeCount);

        return response([
            'message' => 'Success',
            'posts' => $postsWithLikeCount
        ]);
    }

    public function getMostViewPosts()
    {
        $posts = Post::where('status', 1)
            ->orderBy('view_count', 'desc')
            ->get();

        $posts = $this->getAllOverviewPosts($posts);

        return response([
            "message" => "success",
            "data" => $posts
        ]);
    }

    public function filterPost2()
    {
        $query = Post::select('posts.*')
            ->where('status', 1);

        if (request('search') != "") {
            // $query->when(request('search') != "", function ($query) {
            //     return $query
            //         // ->join('bloggers', 'posts.blogger_id', '=', 'bloggers.id')
            //         // ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            //         // ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
            //         ->where(function ($query) {
            //             $query->where('title', 'like', '%' . request('search') . '%')
            //                 ->orWhere('bloggers.name', 'like', '%' . request('search') . '%')
            //                 ->orWhere('tags.name', 'like', '%' . request('search') . '%');
            //         });
            // });

            $query->when(request('search') != "", function ($query) {
                return $query
                    ->with(['blogger', 'tags'])
                    ->where(function ($query) {
                        $searchTerm = '%' . request('search') . '%';
                        $query->where('title', 'like', $searchTerm)
                            ->orWhereHas('blogger', function ($query) use ($searchTerm) {
                                $query->where('name', 'like', $searchTerm);
                            })
                            ->orWhereHas('tags', function ($query) use ($searchTerm) {
                                $query->where('name', 'like', $searchTerm);
                            });
                    });
            });
        } else {
            return response([
                "message" => "success",
                "data" =>  [],
            ]);
        }

        if (request('category_id') != "") {
            $query->when(request('category_id') != "", function ($query) {
                return $query
                    ->where('posts.category_id', '=', request('category_id'));
            });
            // $query->where('posts.category_id', '=', request('category_id'));
        }
        // dd($query->toSql());


        // if ($request->filled('tag_id')) {
        //     //     $query->when($tagId, function ($query) use ($tagId) {
        //     //         $query->whereHas('tags', function ($subQuery) use ($tagId) {
        //     //             $subQuery->where('tags.id', $tagId);
        //     //         });
        //     //     });
        //     // }

        $posts = $query->distinct()->orderBy('id', 'desc')->get();
        $posts = $this->getAllOverviewPosts($posts);

        return response([
            "message" => "success",
            "data" =>  $posts,
        ]);
    }

    public function filterPost()
    {
        $query = Post::select('posts.*')
            ->where('status', 1);

        if (request('search') != "") {
            $query->when(request('search') != "", function ($query) {
                return $query
                    ->where('title', 'like', '%' . request('search') . '%');
            });
        } else {
            return response([
                "message" => "success",
                "data" =>  [],
            ]);
        }

        if (request('category_id') != "") {
            $query->when(request('category_id') != "", function ($query) {
                return $query
                    ->where('category_id', '=', request('category_id'));
            });
        }

        $posts = $query->distinct()->orderBy('id', 'desc')->get();
        $posts = $this->getAllOverviewPosts($posts);

        $bloggers = Blogger::where('name', 'like', '%' . request('search') . '%')->get();

        foreach ($bloggers as $item) {
            $item = $this->getBloggerInfor($item);
            $item->number_of_following = Follow::where('blogger_id', $item->id)->count('following_id');
            $item->number_of_followers = Follow::where('blogger_id', $item->id)->count('follower_id');
            $item->follows = $item->follows;
        }

        return response([
            "message" => "success",
            "posts" =>  $posts,
            "bloggers" => $bloggers,
        ]);
    }

    public function getPostsByMyFollowing()
    {
        try {
            $follows = Follow::all();

            $posts = array();

            foreach ($follows as $item) {
                if ($item->blogger_id === Auth::user()['id'] && $item->following_id) {
                    $post = Post::where([
                        'blogger_id' => $item->following_id,
                        'status' => 1
                    ])
                        ->orderBy('id', 'desc')
                        ->get()
                        ->makeHidden(['description']);

                    $posts[] = $post;
                }
            }

            $postCollection = collect($posts);

            $flattendPosts = $postCollection->flatMap(function ($values) {
                return $values;
            });

            $flattendPosts = $this->getAllOverviewPosts($flattendPosts);

            return response([
                "message" => "success",
                "data" =>  $flattendPosts,
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while getting posts',
                'error' => $err->getMessage(),
            ], 500);
        }
    }

    public function getMyDraftPosts()
    {
        $posts = Post::where(
            [
                'status' => 3,
                'blogger_id' => Auth::user()['id']
            ]
        )->get();

        $posts = $this->getAllOverviewPosts($posts);

        return response([
            "message" => "success",
            "posts" =>  $posts,
        ]);
    }

    public function getPendingPost()
    {
        $posts = Post::where(
            [
                'status' => 0,
                'blogger_id' => Auth::user()['id']
            ]
        )->get();

        $posts = $this->getAllOverviewPosts($posts);

        return response([
            "message" => "success",
            "posts" =>  $posts,
        ]);
    }

    public function getPublishedPost()
    {
        $posts = Post::where(
            [
                'status' => 1,
                'blogger_id' => Auth::user()['id']
            ]
        )->get();

        $posts = $this->getAllOverviewPosts($posts);

        return response([
            "message" => "success",
            "posts" =>  $posts,
        ]);
    }

    public function getPostByCategoryId($id)
    {
        $posts = Category::find($id)->posts;

        $posts = $this->getAllOverviewPosts($posts);

        return response([
            "message" => "success",
            "posts" =>  $posts,
        ]);
    }

    public function recommendPost($query)
    {
        $query->select([
            'posts.id',
            'title',
            'intro',
            'description',
            'category_id',
            'categories.name',
            'bloggers.name'
        ])
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('bloggers', 'posts.blogger_id', '=', 'bloggers.id')
            ->where('posts.id', '!=', request('post_id'))
            ->where(function ($query) {
                $query->where('posts.category_id', '=', request('category_id'))
                    ->orWhere('posts.blogger_id', '=', request('blogger_id'));
            });

        return $query;
    }

    // public function recommendPost($query)
    // {
    //     $categoryId = request('category_id');

    //     return $query
    //         ->select(['id', 'title', 'intro', 'description', 'category_id'])
    //         ->where('id', '!=', request('post_id'))
    //         ->whereHas('category', function ($query) use ($categoryId) {
    //             $query->where('id', $categoryId);
    //         })
    //         ->with('category:name'); // Assuming your Category model has a 'name' field
    // }

    public function getRecommendPost()
    {
        $query = Post::select('posts.*')
            ->where('status', 1);
        $query = $this->recommendPost($query);

        return $query->get();
    }
}
