<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required',  'email', 'max:50'],
            'password'  =>  'required',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }


        try{
            $user_cred   = $request->only('email', 'password');

            $email = request('email');
            $email_details = User::where('email', $email)->first();



            if (Auth::attempt($user_cred)) {
                return response()->json([ [1] ]);
            }else{
                return response()->json([ [7] ]);
            }

        }catch (\Throwable $th){
            ErrorLog::log('auth', 'signup', $th->getMessage()); //log error
            return response()->json([ [5] ]);
        }


    }

    public function register()
    {
        return view('register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function postRegister(Request $request){
        //try{
        // if(request('register')== 'register'){
            $validate = Validator::make($request->all(), [
                'firstname' => ['required', 'string', 'max:50'],
                'lastname' => ['required', 'string', 'max:50'],
                'email' => ['unique:users', 'required',  'email', 'max:50'],
                'password' => ['required', 'string', 'min:8'],
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
            $user->password     = bcrypt(request('password'));

            $user->save();
            $user_id1          = $user->id; //id generated for this user

            $user_cred  =  $request->only('email', 'password');


            if (Auth::attempt($user_cred)) {
                return response()->json([ [1] ]);
            }
             //  }catch (\Throwable $th){
                //      ErrorLog::log('auth', 'signup', $th->getMessage()); //log error
                //      return response()->json([ [5] ]);

                //  }
                //  }else{
                    // LOGIN USER

            //         $validator = Validator::make($request->all(), [
            //             'email' => ['required',  'email', 'max:50'],
            //             'password'  =>  'required',
            //         ]);
            //         if(!$validator->passes()){
            //             return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
            //         }

            //         $user_cred   = $request->only('email', 'password');

            //         $email = request('email');
            //         $email_details = User::where('email', $email)->first();



            //         if (Auth::attempt($user_cred)) {
            //             return response()->json([ [1] ]);
            //    //     }
            //     }



     }

     public function logout()
    {
        Session::flush();

        Auth::logout();

        // return redirect('/');
        return redirect('/')->with('flash_success','Logout Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
