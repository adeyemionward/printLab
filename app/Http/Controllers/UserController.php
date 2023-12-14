<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;

use DB;
use Illuminate\Support\Arr;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $users = User::all();
        return view('users.all_users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles =  Role::all();
        return view('users.add_user', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'email|string|unique:users,email',
            'password' => 'required|string',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'status' => 'required|string',
            'roles' => 'required',
            'address' => 'required|string',

            // Add more rules as needed
        ], [
            'firstname.required' => 'Please enter user firstname.',
            'lastname.required' => 'Please enter user lastname.',
            'email.required' => 'Please enter user email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter user password.',
            'phone.required' => 'Please enter user phone number.',
            'status.required' => 'Please enter user status.',
            'gender.required' => 'Please enter user gender.',
            'roles.required' => 'Please select role.',
            'address.required' => 'Please enter user address.',
        ]);

        // $user = new User();
        // $user->firstname         =  request('firstname');
        // $user->lastname         =  request('lastname');
        // $user->phone            =  request('phone');
        // $user->email            =  request('email');
        // $user->gender           =  request('gender');
        // $user->password         =  bcrypt(request('password'));
        // $user->status           =  request('status');
        // $user->address          =  request('address');
        // $user->save();

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        //dd($input);
        $user = User::create($input);

        //$user->assignRole('admin');
         $user->assignRole($request->input('roles'));

        if($user){
            return redirect(route('users.all_users'))->with('flash_success','User has been created Successful');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.view_user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit_user', compact('user'));
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
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'status' => 'required|string',
            'address' => 'required|string',

            // Add more rules as needed
        ], [
            'firstname.required' => 'Please enter user firstname.',
            'lastname.required' => 'Please enter user lastname.',
            'email.required' => 'Please enter user email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter user phone number.',
            'status.required' => 'Please enter user status.',
            'gender.required' => 'Please enter user gender.',
            'address.required' => 'Please enter user address.',
        ]);

        $user =  User::find($id);

        $user->firstname         =  request('firstname');
        $user->lastname         =  request('lastname');
        $user->phone            =  request('phone');
        $user->email            =  request('email');
        $user->gender           =  request('gender');
        if(request('password') != null){
            $user->password         =  bcrypt(request('password'));
        }

        $user->status           =  request('status');
        $user->address          =  request('address');

        $user->update();

        return back()->with("flash_success","User updated successfully");
    }

    public function view_profile()
    {
        $user = Auth::user();
        return view('users.view_profile', compact('user'));
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('users.edit_profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string',
            'gender' => 'required|string',
            'address' => 'required|string',

            // Add more rules as needed
        ], [
            'firstname.required' => 'Please enter user firstname.',
            'lastname.required' => 'Please enter user lastname.',
            'email.required' => 'Please enter user email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter user phone number.',
            'gender.required' => 'Please enter user gender.',
            'address.required' => 'Please enter user address.',
        ]);



        $user->firstname         =  request('firstname');
        $user->lastname         =  request('lastname');
        $user->phone            =  request('phone');
        $user->email            =  request('email');
        $user->gender           =  request('gender');
        $user->address          =  request('address');

        $user->update();
        return back()->with("flash_success","Profile updated successfully");
        //return view('users.edit_profile', compact('user'));
    }

    public function change_password()
    {
        $user = Auth::user();
        return view('users.change_password', compact('user'));
    }

    public function update_change_password(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|confirmed',

            // Add more rules as needed
        ], [
            'old_password.required' => 'Please enter old password.',
            'password.required' => 'Please enter new password.',
            'password.confirmed' => 'Please enter password confirmation correctly.',
        ]);

        try{
            if (Hash::check(request('old_password'), $user->password)) {
                $user->password = Hash::make(request('password'));
                $user->save();
                return back()->with("flash_success","Password Changed successfully");
            }else{
                return back()->with("flash_error","Old and New Password do not match");
            }
        }catch (\Throwable $th){
            return back()->with("flash_error","Password failed to change");
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect(route('users.all_users'))->with('flash_success','User has been deleted');
    }
}
