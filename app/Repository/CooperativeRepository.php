<?php

    namespace App\Repository;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Models\CooperativeContributionPayment;
    use App\Models\CooperativeContributionPayout;
    use App\Models\CooperativeLoanPayout; 
    use App\Models\CooperativeLoanRepayment; 
    

    class CooperativeRepository
    {
        public function getContributionPayment(){

            DB::beginTransaction();
            try{
               return $payments = CooperativeContributionPayment::select('*', DB::raw('(SELECT SUM(amount) FROM member_cooperative_current_money AS m WHERE m.member_id = cooperative_contribution_payments.member_id) as total_amount'))->get();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

        public function getContributionPayout(){

            DB::beginTransaction();
            try{
               return $payments = CooperativeContributionPayout::select('*', DB::raw('(SELECT SUM(amount) FROM member_cooperative_current_money AS m WHERE m.member_id = cooperative_contribution_payouts.member_id) as total_amount'))->get();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

        public function getLoanPayment(){

            DB::beginTransaction();
            try{
               return $payments = CooperativeLoanRepayment::all();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

        public function getLoanPayout(){

            DB::beginTransaction();
            try{
               return $payments = CooperativeLoanPayout::all();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

    }

?>
