<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    //
    public function getAllActivePost()
    {
        $posts = Post::where('status', 1)->orderBy('id', 'desc')->get();

        foreach ($posts as $post) {
            $post->category_name = $post->category->name;
            $post->blogger_infor = $post->blogger->makeHidden(
                'address',
                'phone',
                'gender',
                'birthday',
                'created_at',
                'updated_at',
                'banner'
            );
            $post->comment_count = $post->comments->count();
            $post->likes_count = $post->likes->count();
            unset($post->blogger, $post->category, $post->blogger_infor->password, $post->description, $post->comments);
        }

        return response([
            "message" => "success",
            "data" => $posts
        ]);
    }

    private function getCommentInfors($comments)
    {
        foreach ($comments as $item) {
            $item->blogger_name = $item->blogger->name;
            $item->blogger_image = $item->blogger->profile_image;
            unset($item->blogger, $item->post_id, $item->updated_at, $item->blogger_id);
        }
        return $comments;
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
            $post->comments = $this->getCommentInfors($post->comments);
            $post->tags = $this->getTagsInfor($post->tags);
            $post->blogger_infor = $post->blogger->makeHidden(
                'password',
                'phone',
                'created_at',
                'updated_at',
                'address',
                'phone',
                'birthday',
                'gender',
                'banner'
            );

            unset($post->blogger_infor->password);

            $tmp_created_date = new Carbon($post->created_at);
            $tmp_updated_date = new Carbon($post->created_at);
            $dt['created'] = $tmp_created_date->format('Y-m-d H:i:s');
            $dt['updated'] = $tmp_updated_date->format('Y-m-d H:i:s');

            $post = json_decode($post);
            $post->created_at = $dt['created'];
            $post->updated_at = $dt['updated'];

            unset($post->blogger_name, $post->category, $post->blogger_id, $post->blogger);

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

    public function store(AddPostRequest $request)
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
                'status' => 0,
            ];

            // $post = Post::create($data);

            // if($request->input('tags')){

            //     $post->tags()->sync($request->input('tags'));
            // }

            $tags = json_decode(str_replace("'", '"', $request->input('tags')));

            $post = Post::create($data);

            $post->tags()->sync($tags);

            $post->update(
                [
                    'slug' => Str::slug($slug) . "-" . time() . $post->id
                ]
            );

            $post->slug = $post->slug;

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

    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $post = $this->checkActivePost($id);

            if (!$post) {
                return response()->json([
                    'message' => 'No post available',
                ], 500);
            }

            if (Auth::user()['id'] !== $post->blogger_id) {
                return response()->json([
                    'message' => 'You do not have permission to edit this post',
                ], 500);
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

            // $tags = json_decode(str_replace("'", '"', $request->input('tags')));
            // if($request->input('tags')){
            //     $post->tags()->sync($request->input('tags'));
            // }

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
            $post = $this->checkActivePost($id);

            if (!$post) {
                return response()->json([
                    'message' => 'No post available',
                ], 500);
            }

            if (Auth::user()['id'] !== $post->blogger_id) {
                return response()->json([
                    'message' => 'You do not have permission to delete this post',
                ], 500);
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

            foreach ($posts as $item) {
                $item->category_name = $item->category->name;
                $item->likes_count = $item->likes->count();
                $item->comments_count = $item->comments->count();
                $item->blogger_infor = $item->blogger->makeHidden(
                    'password',
                    'phone',
                    'address',
                    'birthday',
                    'gender',
                    'created_at',
                    'updated_at'
                );

                unset(
                    $item->description,
                    $item->new_post,
                    $item->highlight,
                    $item->blogger_id,
                    $item->comments,
                    $item->category,
                    $item->category_id,
                    $item->pivot,
                    $item->blogger,
                );
            }

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

        foreach ($postsWithLikeCount as $post) {
            $post->category_name = $post->category->name;
            $post->blogger_infor = $post->blogger->makeHidden(
                'address',
                'phone',
                'gender',
                'birthday',
                'created_at',
                'updated_at',
                'banner'
            );
            $post->comment_count = $post->comments->count();
            unset(
                $post->blogger,
                $post->category,
                $post->blogger_infor->password,
                $post->description,
                $post->comments,
                $post->blogger_id,
                $post->category_id,
            );
        }

        return  $postsWithLikeCount;
    }

    public function getMostViewPosts()
    {
        $posts = Post::where('status', 1)
            ->orderBy('view_count', 'desc')
            ->get();
        foreach ($posts as $post) {
            $post->category_name = $post->category->name;
            $post->blogger_infor = $post->blogger->makeHidden(
                'address',
                'phone',
                'gender',
                'birthday',
                'created_at',
                'updated_at',
                'banner'
            );
            $post->comment_count = $post->comments->count();
            unset(
                $post->blogger,
                $post->category,
                $post->blogger_infor->password,
                $post->description,
                $post->comments,
                $post->blogger_id,
                $post->category_id,
            );
        }

        return response([
            "message" => "success",
            "data" => $posts
        ]);
    }

    public function searchPost($keyword)
    {
        $posts = Post::query()
            ->where('title', 'like', "%$keyword%")
            ->orWhereHas('tags', function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->orWhereHas('blogger', function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->get();
            
        return response([
            "message" => "success",
            "data" => $posts
        ]);
    }
}
