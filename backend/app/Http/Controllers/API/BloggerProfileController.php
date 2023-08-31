<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditBloggerProfileRequest;
use App\Models\Blogger;
use App\Models\Follow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BloggerProfileController extends Controller
{
    //
    public function getAllBloggers(){
        return Blogger::all()->makeHidden(['password']);
    }

    public function getPublicProfileInfor($id)
    {
        try {
            $blogger = Blogger::where('id', $id)->first();

            $numberOfFollowing = Follow::where('blogger_id', $blogger->id)->count('following_id');
            $numberOfFollowers = Follow::where('blogger_id', $blogger->id)->count('follower_id');

            $blogger->number_of_following = $numberOfFollowing;
            $blogger->number_of_followers = $numberOfFollowers;

            $blogger->posts = $blogger
                ->posts()
                ->where('status', 1)
                ->get();

            unset($blogger->password, $blogger->created_at, $blogger->updated_at);

            foreach ($blogger->posts as $item) {
                unset($item->description, $item->new_post, $item->highlight, $item->blogger_id);
            }

            return response([
                'message' => 'success',
                'blogger_infor' => $blogger,
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while getting profile',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function getMyProfileInfor()
    {
        try {
            $blogger = Auth::user() ?? "";

            $numberOfFollowing = Follow::where('blogger_id', $blogger->id)->count('following_id');
            $numberOfFollowers = Follow::where('blogger_id', $blogger->id)->count('follower_id');

            $tmp_created_date = new Carbon($blogger->created_at);
            $dt['created'] = $tmp_created_date->format('Y-m-d H:i:s');

            $blogger = json_decode($blogger);


            $blogger->date_joined = $dt['created'];
            $blogger->number_of_following = $numberOfFollowing;
            $blogger->number_of_followers = $numberOfFollowers;

            unset($blogger->created_at,  $blogger->updated_at);

            return response([
                'message' => 'sucecss',
                'blogger_info' => $blogger,
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while getting profile',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function updateBloggerProfile(EditBloggerProfileRequest $request)
    {
        try {
            $blogger = Blogger::where('id', Auth::user()['id'])->first();

            $data = [
                'name' => $request->input('name'),
                'bio' => $request->input('bio'),
            ];

            if ($request->input('password')) {
                $data['password'] = bcrypt($request->input('password'));
            }

            if ($request->has('profile_image')) {
                $image = $request->profile_image;
                $name = time() . '-' . $image->getClientOriginalName();
                $path = public_path('images/avatar');
                $image->move($path, $name);
                $newPath = $name;
                $data['profile_image'] = $newPath;
            }

            if ($request->has('profile_banner')) {
                $image = $request->profile_banner;
                $name = time() . '-' . $image->getClientOriginalName();
                $path = public_path('images/banner');
                $image->move($path, $name);
                $newPath = $name;
                $data['banner'] = $newPath;
            }

            $blogger->update($data);

            return response([
                'message' => 'sucecss',
                'blogger_infor' => $blogger,
            ]);
        } catch (\Exception $err) {

            return response()->json([
                'message' => 'An error occurred while updating profile',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function follow($blogger_id)
    {
        try {
            $following = Follow::where([
                'blogger_id' => Auth::user()['id'],
                'following_id' => $blogger_id,
            ])->first();

            $follower = Follow::where([
                'blogger_id' => $blogger_id,
                'follower_id' => Auth::user()['id'],
            ])->first();

            if ($following && $follower) {
                $following->delete();
                $follower->delete();
                return response([
                    'message' => 'unfollow sucecssfully',
                ]);
            }

            Follow::create(
                [
                    'blogger_id' => $blogger_id,
                    'follower_id' => Auth::user()['id'],
                ]
            );

            Follow::create(
                [
                    'blogger_id' => Auth::user()['id'],
                    'following_id' => $blogger_id,
                ],
            );

            return response([
                'message' => 'follow sucecssfully',
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'An error occurred while following blogger, maybe blogger is not available',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function isFollowed($blogger_id)
    {
        $follow = Follow::where(function($query) use ($blogger_id) {
            $query->where('blogger_id', Auth::user()['id'])
                  ->where('following_id', $blogger_id);
        })->orWhere(function($query) use ($blogger_id) {
            $query->where('blogger_id', $blogger_id)
                  ->where('follower_id', Auth::user()['id']);
        })->first();

        if ($follow) {
            return response([
                'message' => 'You\'ve already followed this blogger',
                'is_followed' => 1,
            ]);
        }
        else{
            return response([
                'message' => 'You have not followed this blogger before',
                'is_followed' => 0,
            ]);
        }
    }

    // public function unfollow($blogger_id)
    // {
    //     $follow = Follow::where([
    //         'blogger_id' => Auth::user()['id'],
    //         'following_id' => $blogger_id,
    //     ])->first();

    //     $follow->delete();

    //     return response([
    //         'message' => 'sucecss',
    //     ]);
    // }
}
