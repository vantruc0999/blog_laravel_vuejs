<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavePostController extends Controller
{
    //
    public function savePost($id)
    {
        try {
            $isSave = Save::where(
                [
                    'blogger_id' => Auth::user()['id'],
                    'post_id' => $id,
                ]
            )->first();

            if ($isSave) {
                $isSave->delete();
                return response([
                    'message' => 'Unsave successfully',
                ]);
            }

            $post = Post::where(
                [
                    'id' => $id,
                    'status' => 1,
                ]
            )->first();

            if (!$post) {
                return response([
                    'message' => 'No post available',
                ]);
            }

            $save = Save::create(
                [
                    'blogger_id' => Auth::user()['id'],
                    'post_id' => $id,
                ]
            );

            if ($save) {
                return response([
                    'message' => 'Save successfully',
                ]);
            }
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while like a post',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function checkSave($id)
    {
        $isLike = Save::where(
            [
                'blogger_id' => Auth::user()['id'],
                'post_id' => $id,
            ]
        )->first();

        if ($isLike) {
            return response([
                'message' => 'you have already saved this post',
                'is_save' => 1,
            ]);
        } else {
            return response([
                'message' => 'you have not saved this post before',
                'is_save' => 0,
            ]);
        }
    }

    public function getAllSavedPosts()
    {
        $blogger_id = Auth::user()['id'];

        $saves = Save::where(
            [
                'blogger_id' => $blogger_id
            ]
        )->get();

        $posts = array();

        foreach ($saves as $item) {
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

        if (empty($posts)) {
            return response([
                'message' => 'You haven\'t saved any post',
                'posts' => $posts
            ]);
        }

        return response([
            'message' => 'success',
            'posts' => $posts
        ]);
    }
}
