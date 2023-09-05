<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //
    public function likePost($post_id)
    {
        try {
            $isLike = Like::where(
                [
                    'blogger_id' => Auth::user()['id'],
                    'post_id' => $post_id,
                ]
            )->first();

            if ($isLike) {
                $isLike->delete();
                return response([
                    'message' => 'Unlike successfully',
                ]);
            }

            Like::create(
                [
                    'blogger_id' => Auth::user()['id'],
                    'post_id' => $post_id,
                ]
            );

            return response([
                'message' => 'Like successfully',
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while like a post',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function checkLike($post_id)
    {
        $isLike = Like::where(
            [
                'blogger_id' => Auth::user()['id'],
                'post_id' => $post_id,
            ]
        )->first();

        if ($isLike) {
            return response([
                'message' => 'you have already liked this post',
                'is_like' => 1,
            ]);
        } else {
            return response([
                'message' => 'you have not liked this post before',
                'is_like' => 0,
            ]);
        }
    }

    public function getAllLikedPosts()
    {
        $blogger_id = Auth::user()['id'];
        $likes = Like::where(
            [
                'blogger_id' => $blogger_id
            ]
        )->get();

        $posts = array();

        foreach ($likes as $item) {
            $likes_count = $item->post->likes->count();
            $category_name = $item->post->category->name;
            $post = $item->post;
            $item->blogger_infor = $post->blogger;
            $item->likes_count =  $likes_count;
            $item->category_name=  $category_name;

            unset($post->category->created_at, $post->category->updated_at, $post->blogger->created_at, $post->blogger->updated_at, $post->blogger->password);

            $post->makeHidden(['description', 'blogger_id', 'category_id', 'likes', 'category']);
            $posts[] = $post;
        }

        return $posts;
    }
}
