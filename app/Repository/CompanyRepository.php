<?php

    namespace App\Repository;
    use App\Models\Company;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Spatie\Permission\Models\Role;
    class CompanyRepository
    {
        public function postCompany($data){
            DB::beginTransaction();
            try{
                $company = new Company();
                $company->name             = request('name');
                $company->contactperson    = request('contactperson');
                $company->email            = request('email');
                $company->phone            = request('phone');
                $company->city             = request('city');
                $company->state            = request('state');
                $company->country          = request('country');
                $company->address          = request('address');
                $company->subdomain        = request('subdomain');
                $company->status           = request('status');
           
                $company->save();

                //$companyUser = new User();
                // $companyUser->lastname      = request('name');
                // $companyUser->firstname     = request('name');
                // $companyUser->email         = request('email');
                // $companyUser->phone         = request('phone');
                //$companyUser->password      = Hash::make(request('password'));
               // $companyUser->remember_token   = urlencode(Hash::make(time() . request('email')));
                //$companyUser->user_type  = User::COMPANY;
               // $companyUser->status           = request('status');
                //$companyUser->company_id    = $company->id;
                //$companyUser->save();
                
                //$companyUser->assignRole($data->input('roles'));
                 
                $input = $data->all();

                $input['password']      = Hash::make($input['password']);
                $input['user_type']     = User::COMPANY;
                $input['company_id']    = $company->id;
                $input['firstname']     = $input['name'];
                $input['lastname']      = $input['name'];
                $input['remember_token'] = urlencode(Hash::make(time() . request('email')));
                $companyUser = User::create($input);
                $companyUser->assignRole($data->input('roles'));

                DB::commit();

            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('admin.company.list'))->with('flash_success','Company added successfully');
        }

        public function updateCompany($data){
            DB::beginTransaction();
            try{
                $id = request()->id;
                $company = Company::find($id);
                $company->name             = request('name');
                $company->contactperson    = request('contactperson');
                $company->email            = request('email');
                $company->phone            = request('phone');
                $company->city             = request('city');
                $company->state            = request('state');
                $company->country          = request('country');
                $company->address          = request('address');
                $company->subdomain        = request('subdomain');
                $company->status           = request('status');
                $company->save();

                DB::commit();

            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('admin.company.list'))->with('flash_success','Company details updated successfully');
        }

    }

?>
