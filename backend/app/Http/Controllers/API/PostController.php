<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function getAllActivePost()
    {
        $posts = Post::where('status', 1)->get();

        foreach ($posts as $post) {
            $post->category_name = $post->category->name;
            $post->blogger_name = $post->blogger->name;
            unset($post->category_id, $post->category, $post->blogger_id, $post->blogger);
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

    public function getDetailPostBySlug($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $post->category_name = $post->category->name;
        $post->blogger_name = $post->blogger->name;
        // $post->tags = $post->tags;
        
        $post->comments = $this->getCommentInfors($post->comments);

        unset($post->category_id, $post->category, $post->blogger_id, $post->blogger);

        return response([
            "message" => "success",
            "data" => $post
        ]);
    }
}
