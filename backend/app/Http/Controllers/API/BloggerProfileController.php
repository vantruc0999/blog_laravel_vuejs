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

class BloggerProfileController extends Controller
{
    //
    public function getAllBloggers()
    {
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

                unset($item->description, $item->new_post, $item->highlight, $item->blogger_id, $item->comments, $item->likes, $item->category, $item->category_id, $item->blogger);
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
        // if (!preg_match('/^(03|05|07|08|09)[0-9]{8}$/', $request->phone))
        //     return response([
        //         'message' => 'Invalid number',
        //     ]);

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

            if ($request->input('email')) {
                $userEmail = User::where('email', $request->email)->first();
                $bloggerEmail = Blogger::where('email', $request->email)->first();

                if ($userEmail || $bloggerEmail) {
                    return response([
                        'status' => 400,
                        'message' => 'Email exists or invalid please choose another email'
                    ]);
                }

                $data['email'] = $request->input('email');
            }

            if ($request->input('password')) {
                if (!Hash::check($request->input('old_password'), Auth::user()['password']))
                    return response([
                        'message' => 'Wrong password',
                    ]);
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

    public function viewMyFollowing()
    {
        $res = array();
        $blogger_id = Auth::user()['id'];
        $follow = Blogger::find($blogger_id)->follows;
        foreach ($follow as $item) {
            if ($item->following_id) {
                $myFollower = Blogger::find($item->following_id);
                $res[] = $myFollower->makeHidden('password', 'phone', 'address', 'birthday', 'gender', 'created_at', 'updated_at');
            }
        }
        return response([
            'status' => 'success',
            'my_following' => $res,
        ]);
    }

    public function viewMyFollower()
    {
        $res = array();
        $blogger_id = Auth::user()['id'];
        $follow = Blogger::find($blogger_id)->follows;
        foreach ($follow as $item) {
            if ($item->follower_id) {
                $myFollower = Blogger::find($item->follower_id);
                $res[] = $myFollower->makeHidden(
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
            'my_followers' => $res,
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

    public function viewCreatedPost()
    {
        $posts = Post::where('blogger_id', Auth::user()['id'])->get();

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
                $item->likes,
                $item->category,
                $item->category_id,
                $item->pivot,
                $item->blogger,
            );
        }
        return response([
            'status' => 'success',
            'posts' => $posts,
        ]);
    }
}
