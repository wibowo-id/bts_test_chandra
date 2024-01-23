<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;
use Illuminate\Auth\RequestGuard;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['Login', 'Register']]);
    }

    /**
     * function Login
     */
    public function Login(Request $request)
    {
        $credentials = request(['username', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * function Register
     */
    public function Register(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|email|unique:users,email',
            'username'=>'required|unique:users,username',
            'password'=>'required',
        ]);

        try {
            $model = new User;
            $model->username = $request->input('username');
            $model->email = $request->input('email');
            $model->password = Hash::make($request->input('password'));
            $model->remember_token = Str::random(40) . $request->input('email');
            $model->save();

            $code = 200;
            $message = "Data berhasil disimpan";
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
        }

        $data = array(
            'code'=> $code,
            'success'=> $code == 200 ? true : false,
            'message'=> $message
        );

        return response()->json($data);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
