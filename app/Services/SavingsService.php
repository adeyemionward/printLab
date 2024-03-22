<?php

    namespace App\Services;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
    use App\Models\SavingsContributionPayment;
    use App\Models\SavingsContributionPayout;
    use App\Models\MemberSavingsCurrentMoney;
    use App\Models\SavingsLoanRepayment;
    use App\Models\MemberLoanCurrentMoney;
    use App\Models\SavingsLoanPayout;

    class SavingsService
    {
        public function postContributionPayment($data){

            DB::beginTransaction();
            try{
                $user_logged = Auth::user();


                $payment = new SavingsContributionPayment();
                $payment->member_id        = request('member_id');
                $payment->collector_id     = request('collector_id');
                $payment->amount           = request('amount');
                $payment->date             = request('date');
                $payment->created_by       = $user_logged->id;
                $payment->save();
                $receiverCustomer = MemberSavingsCurrentMoney::where('member_id', request('member_id'))->first();

                    // If the record does not exist, create a new one
                    if (!$receiverCustomer) {
                        $receiverCustomer = MemberSavingsCurrentMoney::firstOrCreate(
                            ['member_id' => request('member_id')],
                            ['amount' => request('amount')]
                        );
                    }else{
                              // Now $receiverCustomer contains the existing or newly created record
                        $amountPaying = $receiverCustomer->amount ?? 0;

                        $newAmount = $amountPaying + request('amount');

                        // Update the amount directly
                        $receiverCustomer->update(['amount' => $newAmount]);
                    }



                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('dashboard.admin.savings.contributions.payments.index'))->with('flash_success','payment saved successfully');
        }

        public function postContributionPayout($data){

            DB::beginTransaction();
            try{
                $user_logged = Auth::user();


                $payment = new SavingsContributionPayout();
                $payment->member_id        = request('member_id');
                $payment->amount           = request('amount');
                $payment->date             = request('date');
                $payment->created_by       = $user_logged->id;
                $payment->save();
                $receiverCustomer = MemberSavingsCurrentMoney::where('member_id', request('member_id'))->first();

                //check if the available amount is less than the payout amount
                if($receiverCustomer->amount <  request('amount')) return redirect()->back()->with('flash_error','Sorry, you do not have up to this amount for the repayment');

                // Now $receiverCustomer contains the existing or newly created record
                $amountPaying = $receiverCustomer->amount ?? 0;

                $newAmount = $amountPaying - request('amount');

                // Update the amount directly
                $receiverCustomer->update(['amount' => $newAmount]);


                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('dashboard.admin.savings.contributions.payouts.index'))->with('flash_success','payout saved successfully');

        }


        public function postLoanRepayment($data){

            DB::beginTransaction();
           // try{
                $user_logged = Auth::user();


                $payment = new SavingsLoanRepayment();
                $payment->member_id        = request('member_id');
                $payment->loan_payout_id   = request('loan_payout_id');
                $payment->amount_repayed   = request('amount_repayed');
                $payment->use_savings      = request('use_savings');
                $payment->date             = request('date');
                $payment->created_by       = $user_logged->id;
                $payment->save();

                $receiverCustomer = SavingsLoanPayout::where('id',request('loan_payout_id'))->first();
                $amountPaying = $receiverCustomer->amount_repayed ?? 0;

                $newAmount = $amountPaying + request('amount_repayed');
                $receiverCustomer->update(['amount_repayed' => $newAmount]);

                if(!is_null(request('use_savings'))){
                    //deduct money from Savings savings when loan is paid with saving using the check box
                    $receiverCustomer = MemberSavingsCurrentMoney::where('member_id', request('member_id'))->first();
                    if(is_null($receiverCustomer)) return redirect()->back()->with('flash_error','Sorry, there is no savings for this customer');
                    //check if the available amount is less than the payout amount
                    if($receiverCustomer->amount <  request('amount_repayed')) return redirect()->back()->with('flash_error','Sorry, you do not have up to this amount for the repayment');

                    //store in the SavingsContributionPayout for proper docs
                    $payment = new SavingsContributionPayout();
                    $payment->member_id        = request('member_id');
                    $payment->amount           = request('amount');
                    $payment->date             = request('date');
                    $payment->mode             = 'loan';
                    $payment->created_by       = $user_logged->id;
                    $payment->save();

                     // Now $receiverCustomer contains the existing or newly created record
                    $amountPaying = $receiverCustomer->amount ?? 0;

                    $newAmount = $amountPaying - request('amount_repayed');

                    // Update the amount directly
                    $receiverCustomer->update(['amount' => $newAmount]);
                }


                DB::commit();
            // }catch(\Exception $th){
            //     DB::rollBack();
            //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            // }
            return redirect(route('dashboard.admin.savings.loans.repayments.index'))->with('flash_success','payout saved successfully');

        }

        public function postLoanPayout($data){

            DB::beginTransaction();
            try{
                $user_logged = Auth::user();


                $payment = new SavingsLoanPayout();
                $payment->member_id        = request('member_id');
                $payment->amount_payout    = request('amount_payout');
                $payment->amount_repayed   = 0;
                $payment->date             = request('date');
                $payment->save();

                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('dashboard.admin.savings.loans.payouts.index'))->with('flash_success','loan payout saved successfully');

        }

    }

?>
