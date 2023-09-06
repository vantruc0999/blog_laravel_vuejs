<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blogger;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //
    public function likePost($post_id)
    {
        // return Post::find($post_id)->blogger;
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

            $like = Like::create(
                [
                    'blogger_id' => Auth::user()['id'],
                    'post_id' => $post_id,
                ]
            );

            if ($like) {
                Notification::create([
                    'blogger_id' => Post::find($post_id)->blogger->id,
                    'description' => Auth::user()['name'] . ' liked your post',
                    'is_seen' => 0,
                ]);
            }

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
            $post = $item->post;
            $post->likes_count = $post->likes->count();
            $post->comments_count = $post->comments->count();
            $post->category = $post->category->makeHidden('created_at', 'updated_at');
            $post->category_name = $post->category->name;
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
            $post->makeHidden(['description', 'category_id', 'blogger_id', 'likes', 'comments', 'blogger', 'category']);
            $posts[] = $post;
        }

        if(empty($posts)){
            return response([
                'message' => 'You haven\'t liked any post',
                'posts' => $posts
            ]);
        }

        return response([
            'message' => 'success',
            'posts' => $posts
        ]);
    }
}
