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
    class SubscriptionRepository
    {
        public function postSubscription($data){
            DB::beginTransaction();
            try{
                //save company
                $sub_plan = SubscriptionPlan::where('name',request('subscription_plan'))->first();
               
                //save subscription
                $subscription = new Subscription();
                $subscription->company_id       = request('company_id');
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
            return redirect(route('admin.subscriptions.active'))->with('flash_success','Subscription added successfully');
        }

        public function updateSubscription($data){
            DB::beginTransaction();
            try{
                $sub_plan = SubscriptionPlan::where('name',request('subscription_plan'))->first();
                $id = request()->id;
              
                //update subscription
                $subscription = Subscription::where('company_id',$company->id)->first();
                $subscription->sub_amount       = $sub_plan->amount ?? 0;
                $subscription->sub_start_date   = request('sub_start_date');
                $subscription->sub_end_date     = request('sub_end_date');
                $subscription->status           = request('status');
                $subscription->plan             = request('subscription_plan');
                $subscription->updated_by       = Auth::user()->id;
                $subscription->save();

                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('admin.subscriptions.active',$id))->with('flash_success','Subscription updated successfully');
        }

    }

?>
