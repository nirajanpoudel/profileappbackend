<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function auth(Request $request){
        $validator =   Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json(['error'=>$validator->messages()->first()],500);
        }

        if($request->email=='admin@admin.com' && $request->password=='123456'){
            return response()->json(['message'=>'login successful']); 
        }
       return response(['error'=>'username/password not match found'],500);
    }
}
