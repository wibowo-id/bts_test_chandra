<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    const Login = ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function Login()
    {
        return response->json("ini login api");
    }
}
