<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Like;
use App\Models\Post;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function getAllActivePost()
    {
        $posts = Post::where('status', 1)->get();
        // $posts = Post::where('status', 1)->get();

        foreach ($posts as $post) {
            $post->category_name = $post->category->name;
            $post->blogger_name = $post->blogger->name;
            unset($post->category_id, $post->category, $post->blogger_id, $post->blogger, $post->description);
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
            unset($item->created_at, $item->updated_at, $item->id, $item->pivot);
        }
        return $tags;
        // asd
    }

    // private function getTagsInfor($tags)
    // {
    //     foreach ($tags as $item) {
    //         unset($item->created_at, $item->updated_at, $item->id, $item->pivot);
    //     }
    //     return $tags;
    // }


    public function getDetailPostBySlug($slug)
    {
        
        $post = Post::where('slug', $slug)->firstOrFail();
        
        Post::where('id', $post->id)
            ->update([
                'view_count' => ++$post->view_count
            ]);

        $post->category_name = $post->category->name;
        $post->blogger_name = $post->blogger->name;
        $post->likes_count = $post->likes->count();
        $post->comments = $this->getCommentInfors($post->comments);
        $post->tags = $this->getTagsInfor($post->tags);

        $tmp_created_date = new Carbon($post->created_at);
        $tmp_updated_date = new Carbon($post->created_at);
        $dt['created'] = $tmp_created_date->format('Y-m-d H:i:s');
        $dt['updated'] = $tmp_updated_date->format('Y-m-d H:i:s');
        // $post->created_at = $dt['datetime'];

        $post = json_decode($post);
        $post->created_at = $dt['created'];
        $post->updated_at = $dt['updated'];
        
        // return $post;

        unset($post->category_id, $post->category, $post->blogger_id, $post->blogger, $post->likes);

        return response([
            "message" => "success",
            "data" => $post
        ]);
    }

    public function store(AddPostRequest $request){
        return $request;
        $data = [
            'title'=> $request->input('title'),
            'description' => $request->input('description'),
        ];

        $post = Post::create($data);
        //h
        return $post;
    }

    public function update(UpdatePostRequest $request, $slug){

    }

    public function delete($slug){

    }
}
