<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditBloggerProfileRequest;
use App\Models\Blogger;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BloggerProfileController extends Controller
{
    //
    public function getAllBloggers()
    {
        $bloggers = Blogger::all()->makeHidden(['password']);
        foreach ($bloggers as $item) {
            $item->follows = $item->follows->makeHidden(['updated_at', 'created_at']);
        }
        return $bloggers;
    }

    public function getPublicProfileInfor($id)
    {
        try {
            $blogger = Blogger::where('id', $id)->first();

            $numberOfFollowing = Follow::where('blogger_id', $blogger->id)->count('following_id');
            $numberOfFollowers = Follow::where('blogger_id', $blogger->id)->count('follower_id');
            $total_view = Post::where(
                [
                    'blogger_id' => $id,
                    'status' => 1
                ]
            )->sum('view_count');

            $blogger->number_of_following = $numberOfFollowing;
            $blogger->number_of_followers = $numberOfFollowers;
            $blogger->total_view_count = (int)$total_view;
            $blogger->follows = $blogger->follows;

            $blogger->posts = $blogger
                ->posts()
                ->where('status', 1)
                ->get();

            unset($blogger->password, $blogger->created_at, $blogger->updated_at);

            foreach ($blogger->posts as $item) {
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

                unset($item->description, $item->new_post, $item->highlight, $item->blogger_id, $item->comments, $item->category, $item->category_id, $item->blogger);
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
            $total_view = Post::where(
                [
                    'blogger_id' => Auth::user()['id'],
                    'status' => 1
                ]
            )->sum('view_count');

            $tmp_created_date = new Carbon($blogger->created_at);
            $dt['created'] = $tmp_created_date->format('Y-m-d H:i:s');

            $blogger = json_decode($blogger);


            $blogger->date_joined = $dt['created'];
            $blogger->number_of_following = $numberOfFollowing;
            $blogger->number_of_followers = $numberOfFollowers;
            $blogger->total_view_count = (int)$total_view;

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

            $timestamp = strtotime(str_replace('/', '-', $request->input('birthday')));
            $newDateString = date("Y/m/d", $timestamp);

            $data = [
                'name' => $request->input('name'),
                'bio' => $request->input('bio'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'birthday' => $newDateString,
            ];

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

            $follower = Follow::create(
                [
                    'blogger_id' => $blogger_id,
                    'follower_id' => Auth::user()['id'],
                ]
            );

            $following = Follow::create(
                [
                    'blogger_id' => Auth::user()['id'],
                    'following_id' => $blogger_id,
                ],
            );

            if ($follower && $following) {
                Notification::create([
                    'blogger_id' => $blogger_id,
                    'description' => Auth::user()['name'] . ' followed you',
                    'is_seen' => 0,
                ]);
            }

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
        $follow = Follow::where(function ($query) use ($blogger_id) {
            $query->where('blogger_id', Auth::user()['id'])
                ->where('following_id', $blogger_id);
        })->orWhere(function ($query) use ($blogger_id) {
            $query->where('blogger_id', $blogger_id)
                ->where('follower_id', Auth::user()['id']);
        })->first();

        if ($follow) {
            return response([
                'message' => 'You\'ve already followed this blogger',
                'is_followed' => 1,
            ]);
        } else {
            return response([
                'message' => 'You have not followed this blogger before',
                'is_followed' => 0,
            ]);
        }
    }

    public function checkFollow($blogger_id)
    {
        $follow = Follow::where(function ($query) use ($blogger_id) {
            $query->where('blogger_id', Auth::user()['id'])
                ->where('following_id', $blogger_id);
        })->orWhere(function ($query) use ($blogger_id) {
            $query->where('blogger_id', $blogger_id)
                ->where('follower_id', Auth::user()['id']);
        })->first();

        if($follow){
            return 1;
        }

        return 0;
    }

    public function viewMyFollowing()
    {
        $myFollowing = array();
        $blogger_id = Auth::user()['id'];
        $follow = Blogger::find($blogger_id)->follows;

        foreach ($follow as $item) {
            if ($item->following_id) {
                $myFollower = Blogger::find($item->following_id);
                $myFollowing[] = $myFollower->makeHidden(
                    'password',
                    'phone',
                    'address',
                    'birthday',
                    'gender',
                    'created_at',
                    'updated_at'
                );
            }
        }

        return response([
            'status' => 'success',
            'my_following' => $myFollowing,
        ]);
    }

    public function viewMyFollower()
    {
        $followerList = array();
        $blogger_id = Auth::user()['id'];
        $follow = Blogger::find($blogger_id)->follows;

        foreach ($follow as $item) {
            if ($item->follower_id) {
                $myFollower = Blogger::find($item->follower_id);
                $followerList[] = $myFollower->makeHidden(
                    'password',
                    'phone',
                    'address',
                    'birthday',
                    'gender',
                    'created_at',
                    'updated_at'
                );
            }
        }

        foreach($followerList as $item){
            $item->is_followed = $this->checkFollow($item->id);
        }

        return response([
            'status' => 'success',
            'my_followers' => $followerList,
        ]);
    }

    public function viewMyNotification()
    {
        $notfications = Notification::where('blogger_id', Auth::user()['id'])->get();
        return response([
            'status' => 'success',
            'notifications' => $notfications,
        ]);
    }

    public function changeEMail(Request $request)
    {
        try {
            $blogger = Blogger::where('id', Auth::user()['id'])->first();
            $data = [];
            $this->validate($request, [
                'email' => 'required|email',
            ]);
            if ($request->input('email')) {
                $userEmail = User::where('email', $request->email)->first();
                $bloggerEmail = Blogger::where('email', $request->email)->first();

                if ($userEmail || $bloggerEmail) {
                    return response([
                        'message' => 'Email exists or invalid please choose another email'
                    ]);
                }

                $slug = Str::slug(explode('@', $request->email)[0], '-');

                $data['email'] = $request->input('email');
                $data['slug'] = $slug;

                $blogger->update($data);

                return response([
                    'message' => 'Success',
                    'blogger_infor' => $blogger
                ]);
            }
        } catch (\Exception $err) {
            return response([
                'message' => 'An error occurred while changing email',
                'error' => $err->getMessage()
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $blogger = Blogger::where('id', Auth::user()['id'])->first();
            $data = [];

            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required',
            ]);

            if ($request->input('password')) {
                if (!Hash::check($request->input('old_password'), Auth::user()['password']))
                    return response([
                        'status' => 401,
                        'error' => 'Unauthorized',
                        'message' => 'Wrong password',
                    ]);
                $data['password'] = bcrypt($request->input('password'));
            }

            $blogger->update($data);

            return response([
                'status' => 200,
                'message' => 'Success',
                'blogger_infor' => $blogger
            ]);
        } catch (\Exception $err) {
            return response([
                'message' => 'An error occurred while changing password',
                'error' => $err->getMessage()
            ]);
        }
    }
}
