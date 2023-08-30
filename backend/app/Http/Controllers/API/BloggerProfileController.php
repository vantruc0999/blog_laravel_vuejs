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
    public function getPublicProfileInfor($id)
    {
        $blogger = Blogger::where('id', $id)->first();

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
    }

    public function getMyProfileInfor()
    {
        try {
            $blogger = Auth::user() ?? "";

            $numberOfFollowing = Follow::where('blogger_id', $blogger->id)->count('following_id');
            $numberOfFollowers = Follow::where('blogger_id', $blogger->id)->count('follower_id');

            // return $numberOfFollowers;

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

    public function follow($blogger_id){
        Follow::create([
            'blogger_id' => $blogger_id,
            'following_id' => Auth::user()['id'],
        ]);
        return response([
            'message' => 'sucecss',
        ]);
    }

}
