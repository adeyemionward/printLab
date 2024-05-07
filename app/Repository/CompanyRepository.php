<?php

    namespace App\Repository;
    use App\Models\Company;
    use App\Models\User;
    use App\Models\Subscription;
    use App\Models\SubscriptionPlan;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Spatie\Permission\Models\Role;
    class CompanyRepository
    {
        public function postCompany($data){
            DB::beginTransaction();
            try{
                //save company
                $sub_plan = SubscriptionPlan::where('name',request('subscription_plan'))->first();
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
                $company->plan             = request('subscription_plan');
                $company->sub_amount       = $sub_plan->amount ?? 0;
                $company->sub_start_date   = request('sub_start_date');
                $company->sub_end_date     = request('sub_end_date');

                $getDomain  =  Company::where('subdomain', request('subdomain'))->first();
                if(!is_null($getDomain)) return redirect()->back()->with('flash_error','Subdomain alresy exists');
                $company->save();

                //save user
                $input = $data->all();
                $input['password']      = Hash::make($input['password']);
                $input['user_type']     = User::COMPANY;
                $input['company_id']    = $company->id;
                $input['firstname']     = $input['name'];
                $input['lastname']      = $input['name'];
                $input['remember_token'] = urlencode(Hash::make(time() . request('email')));
                $companyUser = User::create($input);
                $companyUser->assignRole('admin');

                //save subscription
                $subscription = new Subscription();
                $subscription->company_id       = $company->id;
                $subscription->sub_amount       = $sub_plan->amount ?? 0;
                $subscription->sub_start_date   = request('sub_start_date');
                $subscription->sub_end_date     = request('sub_end_date');
                $subscription->status           = request('status');
                $subscription->plan             = request('subscription_plan');
                $subscription->created_by       = Auth::user()->id;
                $subscription->save();

                DB::commit();

            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('admin.company.list'))->with('flash_success','Company added successfully');
        }

        public function updateCompany($data){
            DB::beginTransaction();
            //try{
                 $sub_plan = SubscriptionPlan::where('name',request('subscription_plan'))->first();

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
                $company->plan             = request('subscription_plan');
                $company->sub_amount       = $sub_plan->amount ?? 0;
                $company->sub_start_date   = request('sub_start_date');
                $company->sub_end_date     = request('sub_end_date');
                // $company->updated_by       = Auth::user()->id;
                $company->save();

                //update subscription
                $subscription = Subscription::where('company_id',$company->id)->first();
                if(!is_null($subscription)){
                    $subscription->sub_amount       = $sub_plan->amount ?? 0;
                    $subscription->sub_start_date   = request('sub_start_date');
                    $subscription->sub_end_date     = request('sub_end_date');
                    $subscription->status           = request('status');
                    $subscription->plan             = request('subscription_plan');
                    $subscription->updated_by       = Auth::user()->id;
                    $subscription->save();
                }else{
                    $subscription = new Subscription();
                    $subscription->sub_amount       = $sub_plan->amount ?? 0;
                    $subscription->company_id       = $company->id;
                    $subscription->sub_start_date   = request('sub_start_date');
                    $subscription->sub_end_date     = request('sub_end_date');
                    $subscription->status           = request('status');
                    $subscription->plan             = request('subscription_plan');
                    $subscription->created_by       = Auth::user()->id;
                    $subscription->save();
                }


                DB::commit();
                $getDomain = Company::where('subdomain', request('subdomain'))
                    ->whereNotIn('id', [$id])
                    ->first();
                if(!is_null($getDomain)) return redirect()->back()->with('flash_error','Subdomain already exists');

                $getEmail = Company::where('email', request('email'))
                    ->whereNotIn('id', [$id])
                    ->first();
                if(!is_null($getEmail)) return redirect()->back()->with('flash_error','Email already exists');
                $company->save();
            // }catch(\Exception $th){
            //     DB::rollBack();
            //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            // }
            return redirect(route('admin.company.view',$id))->with('flash_success','Company details updated successfully');
        }

        public function companyStatus($status){

            try{
                $id = request()->id;
                $company = Company::find($id);
                $company->status  = $status;

                 $company->save();

            }catch(\Exception $th){
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }

        }



        public function deactivateCompany(){

            try{
                $this->companyStatus('inactive');

            }catch(\Exception $th){
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('admin.company.view', request()->id))->with('flash_success','Company deactivated');
        }

        public function activateCompany(){
            try{
                $this->companyStatus('active');

            }catch(\Exception $th){
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('admin.company.view', request()->id))->with('flash_success','Company activated');
        }

    }

?>
