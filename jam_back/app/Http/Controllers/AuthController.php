<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // ユーザー登録
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $json = [
            'data' => $user
        ];
        return response()->json($json, Response::HTTP_OK);
    }

    // 旧ログイン
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::whereEmail($request->email)->first();
            $user->tokens()->delete();
            $token = $user->createToken("login:user{$user->id}")->plainTextToken;
            // $hashedToken = Hash::make($token);
            //ログインが成功した場合はトークンを返す
            $cookie = cookie('token', $token, 1); //第３引数は有効期限

            return response()->json(['token' => $token], Response::HTTP_OK)->withCookie($cookie);

            // return response()->json(['token' => $token], Response::HTTP_OK);
        }
        return response()->json('Can Not Login.', Response::HTTP_FORBIDDEN);
    }

    // SPA
    // public function login(Request $request)
    // {
    //     // $credentials = $request->validate([
    //     //     'email' => ['required', 'email'],
    //     //     'password' => ['required'],
    //     // ]);
    //     echo 'login echo test';
    //     // $request->session()->start();

    //     // exit();
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $request->session()->regenerate();

    //         return response()->json(Auth::user(), Response::HTTP_OK);
    //     }
    //     return response()->json('Can Not Login.', Response::HTTP_INTERNAL_SERVER_ERROR);
    // }

    public function logout(Request $request)
    {
        //勝手に返す500をフロントで未ログインです等のメッセージを出力
        // $request->user()->currentAccessToken()->delete();
        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = User::whereEmail($request->email)->first();
        $user->tokens()->delete();
        return response()->json(['message' => 'logout'], 200);
        // }
        // return response()->json('Can Not Logout.', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function tokenCheck(Request $request)
    {
        // $postData = Hash::make($request->input('body'));
        $postData = $request->input('body');
        // $hashedToken = Hash::make($postData);
        $tokenCheck = DB::table('personal_access_tokens')
            ->where('id', '=', $postData)
            ->exists();
        Log::info("Post Data: " . $postData);
        Log::info("Token Check Result: " . ($tokenCheck ? 'true' : 'false'));
        if ($tokenCheck) {
            return response()->json([
                'status' => "OKeee",
                'user_test' => $postData
            ], Response::HTTP_OK);
        } else {
            return response()->json('Can Not Login.', Response::HTTP_FORBIDDEN);
        }
    }
    public function tokenCheckTest(Request $request)
    {
        // $request->user()->currentAccessToken();
        //トークンがなかったら勝手に500返す
        $login_check = $request->user();
        return response()->json([
            'status' => "OK",
            'user_test' => $request->user()->currentAccessToken()
        ]);
    }
}
