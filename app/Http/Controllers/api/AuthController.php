<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email' => 'required|max:100|email',
            'password' => 'required|max:255|min:8',
        ], [
            'email.required' => 'هذه الحقل مطلوب',
            'email.max' => 'لا يمكن تخطي اللحد الاقصي',
            'email.email'=>'يرجي كتاابه بريد صالح',
            'password.required' => 'هذه الحقل مطلوب',
            'password.max' => 'لا يمكن تخطي اللحد الاقصي',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        };



        $users = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);



        $token = $users->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'=>200,
            'access_token'=>$token,
            'token_type'=>'Bearer',
        ]);


    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:100|email',
            'password' => 'required|max:255',
        ], [
            'email.required' => 'هذه الحقل مطلوب',
            'email.max' => 'لا يمكن تخطي اللحد الاقصي',
            'email.email'=>'يرجي كتاابه بريد صالح',
            'password.required' => 'هذه الحقل مطلوب',
            'password.max' => 'لا يمكن تخطي اللحد الاقصي',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        };


        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->plainTextToken;


        return response()->json([
           'status'=>200,
           'access_token'=>$token,
            'token_type'=>'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
       Auth::user()->tokens()->delete();

//        auth()->user()->currentAccessToken->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Logout Success',
        ]);
    }

    public function resetPassword(Request $request)
    {
//        return response()->json(['message'=>$request->all()]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:100|email|exists:users',
        ], [
            'email.required' => 'هذه الحقل مطلوب',
            'email.exists' => 'هذه الايميل غير صحيح',
            'email.max' => 'لا يمكن تخطي اللحد الاقصي',
            'email.email'=>'يرجي كتاابه بريد صالح',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status'=>500
            ]);
        };


    }

}
