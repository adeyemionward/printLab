<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DB;
use Illuminate\Support\Arr;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user(); return $next($request);
        });

        $this->middleware('auth');
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);


        $this->middleware('permission:user-password-create', ['only' => ['update_user_password']]);
        $this->middleware('permission:user-role-create', ['only' => ['update_add_user_role']]);

        $this->middleware('permission:testimonial-create', ['only' => ['create_testimonial','post_testimonial']]);
        $this->middleware('permission:testimonial-view', ['only' => ['view_testimonial']]);
        $this->middleware('permission:testimonial-edit', ['only' => ['edit_testimonial','update_testimonial']]);
        $this->middleware('permission:testimonial-delete', ['only' => ['delete_testimonial']]);
    }

    function handleFileUpload($hasFile, $fileName, $dir){
        if ($hasFile) {
            if ($img = $fileName) {
                $ImageName = $fileName->getClientOriginalName();
                $uniqueFileName = time() . '_' . $ImageName;
                $ImagePath = $dir.'/images/' . $uniqueFileName;
                $img->move(public_path($dir.'/images/'), $uniqueFileName);
                return $ImagePath;
            }
        }
    }

    public function find_testimonial($id)
    {
        return Testimonial::find($id);
    }
    public function index()
    {
        $users = User::where('user_type',User::COMPANY)->where('company_id',$this->user->company_id)->get();
        return view('company.users.all_users', compact('users'));
    }


    public function create()
    {
        $roles = Role::where('company_id', app('company_id'))->orWhere('name','admin')->get();
        return view('company.users.add_user', compact('roles'));
    }

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
        try{

            $input = $request->all();

            $input['password']   = Hash::make($input['password']);
            $input['user_type']  = User::COMPANY;
            $input['company_id'] = Auth::user()->company_id;
            $user = User::create($input);

            //assign roels and permission to user
            $user->assignRole($request->input('roles'));

            $role = Role::with('permissions')->where('name', request('roles'))->first();

            if ($role) {
                $permissions = $role->permissions;
                $user->syncPermissions($permissions);
            } else {
                // Handle the case where the role doesn't exist
                return back()->with("flash_error","Role doesn't exist");
            }

            if($user){
                return redirect(route('company.users.all_users'))->with('flash_success','User has been created Successful');
            }
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }

    }

    public function show($user_company_id)
    {
        $user = User::find($user_company_id);
        return view('company.users.view_user', compact('user'));
    }


    public function edit($user_company_id)
    {
        $user = User::find($user_company_id);
        return view('company.users.edit_user', compact('user'));
    }

    public function update(Request $request, $user_company_id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user_company_id,
            // 'password' => 'nullable|string',
            'phone' => 'required|string',
            'gender' => 'required|string',
            // 'status' => 'required|string',
            'address' => 'required|string',

            // Add more rules as needed
        ], [
            'firstname.required' => 'Please enter user firstname.',
            'lastname.required' => 'Please enter user lastname.',
            'email.required' => 'Please enter user email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter user phone number.',
            // 'status.required' => 'Please enter user status.',
            'gender.required' => 'Please enter user gender.',
            'address.required' => 'Please enter user address.',
        ]);

        try{


            $user =  User::find($user_company_id);

            $user->firstname         =  request('firstname');
            $user->lastname         =  request('lastname');
            $user->phone            =  request('phone');
            $user->email            =  request('email');
            $user->gender           =  request('gender');
            // if(request('password') != null){
            //     $user->password         =  bcrypt(request('password'));
            // }

            // $user->status           =  request('status');
            $user->address          =  request('address');

            $user->update();

            return back()->with("flash_success","User updated successfully");
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
    }

    public function view_profile()
    {
        $user = Auth::user();
        return view('company.users.view_profile', compact('user'));
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('company.users.edit_profile', compact('user'));
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

        try{
            $user->firstname         =  request('firstname');
            $user->lastname         =  request('lastname');
            $user->phone            =  request('phone');
            $user->email            =  request('email');
            $user->gender           =  request('gender');
            $user->address          =  request('address');

            $user->update();
            return back()->with("flash_success","Profile updated successfully1111");
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }


    }



    public function create_testimonial()
    {
        $customers =  User::where('user_type',User::CUSTOMER)->where('company_id', app('company_id'))->get();
        return view('company.users.testimonial.add_testimonial', compact('customers'));
    }


    public function post_testimonial(Request $request)
    {

        $user = Auth::user();

        $customer_id   =  request('customer_id');
        $description    =  request('description');

        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'testimonials');


        //save to testimonial
        $testimonial = new Testimonial();
        $testimonial->company_id    = $user->company_id;
        $testimonial->customer_id   =  $customer_id;
        $testimonial->description   = $description;
        $testimonial->image         = $image;
        $testimonial->created_by    = $user->id;


        // if($testimonial_img = $request->file('image')){
        //     $name = $testimonial_img->hashName(); // Generate a unique, random name...
        //     $path = $testimonial_img->store('public/images');
        //     $testimonial->image = $name;
        // }

        $testimonial->save();

        return redirect(route('company.users.testimonial.view_testimonial',$testimonial->id))->with('flash_success','Customer Testimonial saved successfully');
    }

    public function all_testimonial()
    {
        $all_testimonial = Testimonial::where('company_id', app('company_id'))->get();
        return view('company.users.testimonial.all_testimonials', compact('all_testimonial'));
    }

    public function view_testimonial($id)
    {
        $testimonial =  $this->find_testimonial($id);
        return view('company.users.testimonial.view_testimonial', compact('testimonial'));
    }

    public function edit_testimonial($id)
    {
        $testimonial =  $this->find_testimonial($id);
        $customers =  User::where('user_type',User::CUSTOMER)->where('company_id', app('company_id'))->get();
        return view('company.users.testimonial.edit_testimonial', compact('testimonial','customers'));
    }

    public function update_testimonial(Request $request, $id)
    {
        $user = Auth::user();

        $customer_id   =  request('customer_id');
        $description    =  request('description');

        try{
            $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'testimonials');
            $testimonial =  $this->find_testimonial($id);

            //update to testimonial
            $testimonial->customer_id     = $customer_id;
            $testimonial->description     = $description;
            $testimonial->updated_by      = $user->id;


            if($testimonial_img = $request->file('image')){

                $testimonial->image = $image;

            }

            $testimonial->save();
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }


        return redirect(route('company.users.testimonial.all_testimonials'))->with('flash_success','Customer Testimonial updated successfully');
    }

    public function delete_testimonial($id)
    {
        try{
            $testimonial =  $this->find_testimonial($id);
            if(is_null($testimonial)){
                return redirect(route('company.users.testimonial.all_testimonials'))->with('flash_success','Customer Testimonial not available');
            }
            $testimonial->delete();
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
        return redirect(route('company.users.testimonial.all_testimonials'))->with('flash_success','Customer Testimonial deleted');
    }

    public function change_password()
    {
        $user = Auth::user();
        return view('company.users.change_password', compact('user'));
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


    public function update_user_password(Request $request, $user_company_id)
    {
        //$user = Auth::user();

        $validatedData = $request->validate([
            'password' => 'required|confirmed',

            // Add more rules as needed
        ], [

            'password.required' => 'Please enter new password.',
            'password.confirmed' => 'Please enter password confirmation correctly.',
        ]);

        try{
            if (request('password')) {
                $user =  User::find($user_company_id);
                $user->password = Hash::make(request('password'));
                $user->save();
                return back()->with("flash_success","User Password Changed successfully");
            }
        }catch (\Throwable $th){
            return back()->with("flash_error","Password failed to change");
        }

    }


    public function update_add_user_role(Request $request, $user_company_id)
    {
        //$user = Auth::user();

        $validatedData = $request->validate([
            'role' => 'required',

            // Add more rules as needed
        ], [

            'role.required' => 'Please enter a role.',
        ]);

        try{
            if (request('role')) {
                $user =  User::find($user_company_id);
                //$current_roles = $user->getRoleNames();

                $user->save();
                $user->roles()->detach(); // Detach all existing roles
                $user->assignRole(request('role')); // Assign the new role

                $role = Role::with('permissions')->where('name', request('role'))->first();
                if ($role) {
                    $permissions = $role->permissions;
                    $user->syncPermissions($permissions);
                } else {
                    // Handle the case where the role doesn't exist
                    return back()->with("flash_error","Role doesn't exist");
                }

                return back()->with("flash_success","User Role Changed successfully");
            }
        }catch (\Throwable $th){
            return back()->with("flash_error","User role failed to change");
        }

    }


    public function destroy($user_company_id)
    {
        $user = User::find($user_company_id)->delete();
        return redirect(route('company.users.all_users'))->with('flash_success','User has been deleted');
    }
}
