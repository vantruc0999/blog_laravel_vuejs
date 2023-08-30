<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    private function checkActivePost($slug)
    {
        $post = Post::where(
            [
                'slug' => $slug,
                'status' => 1,
            ]
        )->first();

        if (!$post) {
            return false;
        }

        return $post;
    }

    public function commentPost(Request $request, $slug)
    {
        try {
            $post = $this->checkActivePost($slug);
            $this->validate($request, [
                'description' => 'required|max:255',
            ]);
            $comment = Comment::create([
                'description' => $request->input('description'),
                'post_id' => $post->id,
                'blogger_id' => Auth::user()['id'],
            ]);
            return response([
                'message' => 'success',
                'comment' => $comment
            ]);
        } catch (\Exception $err) {

            return response()->json([
                'message' => 'An error occurred while createing comment',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function editComment(Request $request, $id)
    {
        try{
            $this->validate($request, [
                'description' => 'required|max:255',
            ]);
    
            $comment = Comment::where('id', $id)->first();
    
            if (Auth::user()['id'] != $comment->blogger_id) {
                return response([
                    'message' => 'You do not have permission to edit this comment',
                ]);
            }
    
            $comment->update([
                'description' => $request->input('description')
            ]);
    
            return response([
                'message' => 'update comment successfully',
                'comment' => $comment
            ]);
    
        }    
        catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while editing comment',
                'error' => $err->getMessage()
            ], 500);
        }
        
    }

    public function deleteComment($id)
    {
        try{
            $comment = Comment::where('id', $id)->first();

            if (Auth::user()['id'] != $comment->blogger_id) {
                return response([
                    'message' => 'You do not have permission to delete this comment',
                ]);
            }
    
            $comment->delete();
    
            return response([
                'message' => 'delete comment successfully',
            ]);
        }
        catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while deleting comment',
                'error' => $err->getMessage()
            ], 500);
        }      
    }
}
