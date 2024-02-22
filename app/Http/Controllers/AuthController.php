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


    public function postRegister(Request $request){
        //try{
        // if(request('register')== 'register'){
            $validate = Validator::make($request->all(), [
                'firstname' => ['required', 'string', 'max:50'],
                'lastname' => ['required', 'string', 'max:50'],
                'email' => ['unique:users', 'required',  'email', 'max:50'],
                'password' => ['required', 'string', 'min:8'],
                'company_name' => ['required', 'string'],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string'],
            ]);


            if(!$validate->passes()){
                return response()->json([
                    'status'=>0,
                    'error'=>$validate->errors()->toArray()
                ]);
            }



            $user = new User();
            $user->firstname    = request('firstname');
            $user->lastname     = request('lastname');
            $user->email        = request('email');
            $user->phone        = request('phone');
             $user->gender      = 'm';
             $user->status      = 'active';
             $user->user_type      = '2';
             $user->company_name        = request('company_name');
             $user->phone        = request('phone');
             $user->address        = request('address');
            $user->password     = bcrypt(request('password'));
            $user->save();
            $user_cred  =  $request->only('email', 'password');


            if (Auth::attempt($user_cred)) {
                if(request()->status == 'order'){
                    return response()->json([ [12] ]);
                }
                return response()->json([ [1] ]);
            }
    }

    public function logout(){
        Session::flush();

        Auth::logout();

        // return redirect('/');
        return redirect('/')->with('flash_success','Logout Successful');
    }
}
