<?php

    namespace App\Repository;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Models\SavingsContributionPayment;
    use App\Models\SavingsContributionPayout;
    use App\Models\SavingsLoanPayout;
    use App\Models\SavingsLoanRepayment;


    class SavingsRepository
    {
        public function getContributionPayment(){

            DB::beginTransaction();
            try{
               return $payments = SavingsContributionPayment::select('*', DB::raw('(SELECT SUM(amount) FROM member_savings_current_money AS m WHERE m.member_id = savings_contribution_payments.member_id) as total_amount'))->get();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

        public function getContributionPayout(){

            DB::beginTransaction();
            try{
               return $payments = SavingsContributionPayout::select('*', DB::raw('(SELECT SUM(amount) FROM member_savings_current_money AS m WHERE m.member_id = savings_contribution_payouts.member_id) as total_amount'))->get();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

        public function getLoanPayment(){

            DB::beginTransaction();
            try{
               return $payments = SavingsLoanRepayment::all();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

        public function getLoanPayout(){

            DB::beginTransaction();
            try{
               return $payments = SavingsLoanPayout::all();
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
        }

    }

?>
