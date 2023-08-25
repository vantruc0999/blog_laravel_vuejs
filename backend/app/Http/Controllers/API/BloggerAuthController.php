<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blogger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BloggerAuthController extends Controller
{
    //
    public function getInfor(){
        return Auth::user();
    }

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

        $blogger = Blogger::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name,
        ]);

        $token = $blogger->createToken('token_' . $blogger->name)->accessToken;

        return response([
            'status' => 200,
            'message' => 'Created recruiter Successfully, Hello ' . $blogger->name,
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

            $token =  $blogger->createToken('token_' . $blogger->name)->accessToken;

            unset($blogger['password'], $blogger['created_at'], $blogger['updated_at']);

            return response()->json([
                'status' => 200,
                'message' => 'Login successfully, Hello ' . $blogger->name,
                'token' => $token,
                'blogger_infor' => $blogger
            ]);
        } else {
            return response()->json([
                'status' => 'fails',
                'message' => 'Invalid username or password'
            ], 401);
        }
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
