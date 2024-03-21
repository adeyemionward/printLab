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
           // try{
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
                $company->status           = Company::INACTIVE;

                $company->save();

                $input = $data->all();

                $input['password']      = Hash::make($input['password']);
                $input['user_type']     = User::COMPANY;
                $input['company_id']    = $company->id;
                $input['firstname']     = $input['firstname'];
                $input['lastname']      = $input['lastname'];
                $input['remember_token'] = urlencode(Hash::make(time() . request('email')));
                $companyUser = User::create($input);
                $companyUser->assignRole('admin'); 
                
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

            // }catch(\Exception $th){
            //     DB::rollBack();
            //     return response()->json([ [5] ]);
            // }
            return response()->json([ [1] ]);
        }

    }

?>
