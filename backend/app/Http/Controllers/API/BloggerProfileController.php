<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blogger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloggerProfileController extends Controller
{
    //
    public function getPublicProfileInfor($slug)
    {
        $blogger = Blogger::where('slug', $slug)->first();

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
        $blogger = Auth::user();

        return response([
            'message' => 'sucecss',
            'blogger_info' => $blogger,
        ]);
    }

    public function editBloggerProfile()
    {
    }
}
