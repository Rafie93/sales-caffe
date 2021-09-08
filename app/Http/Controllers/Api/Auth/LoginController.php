<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public $successStatus = 200;

    public function mail(Request $request)
    {
        $this->clearLoginAttempts($request);

        if(Auth::attempt(['email' => request('email'), 'password' => request('password'),'role'=>15,'status'=>1])){
            $user = Auth::user();
            return new UserResource($user);
        }else if(Auth::attempt(['email' => request('email'), 'password' => request('password'),'role'=>15,'status'=>1])){
            $user = Auth::user();
            return new UserResource($user);
        }
        else{
            $cekUser = User::where('email',$request->email)->get()->count();
            if($cekUser > 0){
                return response()->json(['success'=>false,'message'=>'Password yang anda masukkan Salah'], 400);
            }
            else{
                return response()->json(['success'=>false,'message'=>'email yang anda masukkan tidak terdaftar'], 400);
            }
        }
    }
}
