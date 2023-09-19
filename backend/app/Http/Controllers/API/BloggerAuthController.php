<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blogger;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BloggerAuthController extends Controller
{

    public function register(Request $request)
    {
        $userEmail = User::where('email', $request->email)->first();
        $bloggerEmail = Blogger::where('email', $request->email)->first();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($userEmail || $bloggerEmail) {
            return response([
                'status' => 400,
                'message' => 'Email exists or invalid please choose another email'
            ]);
        }

        $slug = Str::slug(explode('@', $request->email)[0], '-');

        $blogger = Blogger::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'slug' => $slug
        ]);

        $token = $blogger->createToken('token_' . $blogger->name)->accessToken;

        return response([
            'status' => 200,
            'message' => 'success, Hello ' . $blogger->name,
            'token' => $token,
            'blogger' => $blogger
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $blogger = Blogger::where('email', $request->email)->first();

        if ($blogger && Hash::check($request->password, $blogger->password)) {

            $token =  $blogger->createToken('token_' . $blogger->name);
            $access_token =  $token->accessToken;

            // dd($token);
            // unset($blogger['password'], $blogger['created_at'], $blogger['updated_at']);
            $blogger->makeHidden(['password', 'created_at','updated_at']);

            return response()->json([
                'status' => 200,
                'message' => 'Login successfully, Hello ' . $blogger->name,
                'access_token' => $access_token,
                'token_type' => 'Bearer',
                'blogger_infor' => $blogger
            ]);
        } else {
            return response()->json([
                'status' => 'fails',
                'message' => 'Invalid username or password'
            ], 401);
        }
    }

    public function forgetPassword(){
        $mail = Mail::send();
        
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'status' => 200,
            'message' => 'Logged Out Successfully',
        ]);
    }
}
