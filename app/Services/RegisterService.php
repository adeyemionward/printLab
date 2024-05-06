<?php

    namespace App\Services;
    use App\Models\Company;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Spatie\Permission\Models\Role;
    use Illuminate\Support\Facades\Session;
    class RegisterService
    {
        public function postCompany($data){
            DB::beginTransaction();
           try{
                $contact_person =  request('firstname').' '.request('lastname');
                $company = new Company();
                $company->name             = request('company_name');
                $company->contactperson    = $contact_person;
                $company->email            = request('email');
                $company->phone            = request('phone');
                $company->city             = request('city');
                $company->state            = request('state');
                $company->country          = request('country');
                $company->address          = request('address');
                $company->subdomain        = request('subdomain');

                $company->admin_username   = request('admin_username');
                $company->admin_password   = Hash::make(request('password'));
                $company->status           = Company::INACTIVE;

                $company->save();

                //for user
                $companyUser = new User();
                $companyUser->email         = request('email');
                $companyUser->password      = Hash::make(request('password'));
                $companyUser->user_type     = User::COMPANY;
                $companyUser->company_id     = $company->id;
                $companyUser->firstname        = request('firstname');
                $companyUser->lastname         = request('lastname');
                $companyUser->remember_token   = urlencode(Hash::make(time() . request('email')));
                $companyUser->save();


                //for admin

                $companyUserAdmin = new User();
                $companyUserAdmin->email              = 'admin@'.request('admin_username');
                $companyUserAdmin->admin_username     = request('admin_username');
                $companyUserAdmin->password           = Hash::make(request('password'));
                $companyUserAdmin->user_type          = User::COMPANY;
                $companyUserAdmin->company_id         = $company->id;
                $companyUserAdmin->firstname        = request('firstname');
                $companyUserAdmin->lastname         = request('lastname');
                $companyUserAdmin->save();

                $companyUserAdmin->assignRole('admin');


                Session::put('name', request('company_name'));
                Session::put('email', request('email'));

                //$user_cred  =  $request->only('email', 'password');
                DB::commit();

                // if (Auth::attempt($user_cred)) {
                //     if(request()->status == 'order'){
                //         return response()->json([ [12] ]);
                //     }
                //     return response()->json([ [1] ]);
                // }

            }catch(\Exception $th){
                DB::rollBack();
                return response()->json([ [5] ]);
            }
            return response()->json([ [1] ]);
        }

    }

?>
