<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Company;
use App\Models\ErrorLog;
use App\Services\LoginService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Session;

class AuthController extends Controller
{
    
    public function login()
    {
        return view('front.login');
    }

    public function postLogin(LoginRequest $request, LoginService $loginService){
        return $loginService->login($request);
    }

    public function register()
    {
        return view('front.register');
    }


    public function postregister(RegisterRequest $request, RegisterService $registeservice){
        return $response = $registeservice->postCompany($request);
    }

    public function logout(){
        Session::flush();

        Auth::logout();

        // return redirect('/');
        return redirect('/')->with('flash_success','Logout Successful');
    }
}
