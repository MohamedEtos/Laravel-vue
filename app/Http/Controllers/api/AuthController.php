<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name'=>'required',
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
}
