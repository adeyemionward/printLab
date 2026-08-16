<?php

    namespace App\Repository;
    use App\Models\JobOrderTracking;
    use App\Models\JobOrder;
    use App\Models\JobPaymentHistory;
    use Illuminate\Support\Facades\DB;
    use App\Models\HigherNoteBook;;
    use App\Models\EightyLeavesBook;
    use App\Models\FortyLeavesBook;
    use App\Models\JobOrderUnique;
    use App\Models\JobPaymentNewHistory;
    use App\Models\TwentyLeavesBook;
    use App\Models\User;
    use App\Models\MarketerCommission;
    use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

    class NoteBookRepository
    {


        public function noteBookOrder($data){
            DB::beginTransaction();
            try {
                $user = Auth::user();
                $order_date = date('Y-m-d');

                $customer_id            =  $data['customer_id'];
                $quantity               =  $data['quantity'];
                $unit_cost              =  $data['unit_cost'];
                $ink                    =  $data['ink'];
                $leaves                 =  $data['leaves'] ?? null;
                $paper_type             =  $data['paper_type'];
                $production_time        =  $data['production_time'];
                $thickness              =  $data['thickness'];
                $proof_needed           =  $data['proof_needed'];

                // Handle values checking for potential empty strings
                $total_cost             =  (!isset($data['total_cost']) || $data['total_cost'] === '') ? 0 : (float) str_replace(',', '', $data['total_cost']);
                $initial_amount_paid    =  (!isset($data['amount_paid']) || $data['amount_paid'] === '') ? 0 : (float) str_replace(',', '', $data['amount_paid']);

                $initial_payment_type   =  $data['payment_type'];
                $location               =  $data['location'];
                $posted_cheque_due_date =  $data['posted_cheque_date'] ?? null;

                $marketerId = $data['marketer_id'] ?? [];
                $percentage = $data['percentage'] ?? [];

                // Save to job
                $job_order = new JobOrder();
                $job_order->user_id                  = $customer_id;
                $job_order->company_id               = $user->company_id;
                $job_order->job_order_name           = $data['note_type'];
                $job_order->quantity                 = $quantity;
                $job_order->unit_cost                = $unit_cost;
                $job_order->ink                      = $ink;
                $job_order->leaves                   = $leaves;
                $job_order->paper_type               = $paper_type;
                $job_order->production_days          = $production_time;
                $job_order->thickness                = $thickness;
                $job_order->proof_needed             = $proof_needed;
                $job_order->total_cost               = $total_cost;
                $job_order->initial_amount_paid      = $initial_amount_paid; // Will successfully pass 0 instead of ''
                $job_order->initial_payment_type     = $initial_payment_type;
                $job_order->order_date               = $order_date;
                $job_order->order_type               = 'internal';
                $job_order->cart_order_status        = 1;
                $job_order->job_location_id          = $location;
                $job_order->created_by               = $user->id;
                $job_order->posted_cheque_due_date   = $posted_cheque_due_date;
                $job_order->save();

                for ($count = 0; $count < count($marketerId); $count++) {
                    if (!empty($marketerId[$count])) {
                        MarketerCommission::updateOrCreate(
                            [
                                'job_order_id'      => $job_order->id,
                                'company_id'        => $user->company_id,
                                'marketer_id'       => $marketerId[$count],
                                'percentage'        => $percentage[$count] ?? 0,
                            ],
                        );
                    }
                }

                DB::commit();
                return ['success' => true, 'job_order' => $job_order];

            } catch(\Exception $th) {
                DB::rollBack();
                return ['success' => false, 'error' => $th->getMessage()];
            }
        }

        public function updateNoteBookOrder($data){
            DB::beginTransaction();
            try{
                $id = request()->id;
                $user = Auth::user();
                $order_date = date('Y-m-d');

                $customer_id                =  $data['customer_id'];
                $quantity                   =  str_replace(',', '', $data['quantity']);
                $unit_cost                 =  str_replace(',', '', $data['unit_cost']);
                $ink                        =  $data['ink'];
                $leaves                     =  $data['leaves'];
                $paper_type                 =  $data['paper_type'];
                $production_time            =  $data['production_time'];
                $thickness                  =  $data['thickness'];
                $proof_needed               =  $data['proof_needed'];

                // Clean numeric values checking for empty strings safely
                $total_cost                 =  (!isset($data['total_cost']) || $data['total_cost'] === '') ? 0 : (float) str_replace(',', '', $data['total_cost']);
                $amount_paid                =  (!isset($data['amount_paid']) || $data['amount_paid'] === '') ? 0 : (float) str_replace(',', '', $data['amount_paid']);

                $payment_type               =  $data['payment_type'];
                $location                   =  $data['location'];

                $marketerId = User::find($customer_id)->marketer_id;

                $trimmedNoteType = str_replace(' ', '_', request('note_type'));

                // Save to job
                $job_order =  JobOrder::find($id);
                $job_order->user_id         = $customer_id;
                $job_order->job_order_name  = $data['note_type'] ?? null;
                $job_order->leaves          = $leaves;
                $job_order->quantity        = $quantity;
                $job_order->unit_cost                = $unit_cost;
                $job_order->ink             = $ink;
                $job_order->paper_type      = $paper_type;
                $job_order->production_days = $production_time;
                $job_order->thickness       = $thickness;
                $job_order->proof_needed    = $proof_needed;
                $job_order->total_cost      = $total_cost;

                $job_order->job_location_id = $location;
                $job_order->updated_by      = $user->id;
                $job_order->posted_cheque_due_date      = $data['posted_cheque_date'] ?? null;
                $pp = $job_order->save();

                // Get the total from the job_order
                $job_order_unique_id = $job_order->job_order_unique_id;
                JobOrder::updateJobUniqueCost($job_order_unique_id);

                $marketer_commission_id = $data['marketer_commission_id'];
                $marketerId = $data['marketer_id'] ?? [];
                $percentage = $data['percentage'] ?? [];

                $comm_id = MarketerCommission::where('job_order_id', request()->id);
                $comm_id->delete();

                if ($pp) {
                    if (!empty($marketerId) && !empty($percentage)) {
                        for ($count = 0; $count < count($marketerId); $count++) {
                            if (!empty($marketerId[$count]) && !empty($percentage[$count])) {
                                MarketerCommission::updateOrCreate(
                                    [
                                        'job_order_id' => $job_order->id,
                                        'company_id'   => $user->company_id,
                                        'marketer_id'  => $marketerId[$count],
                                    ],
                                    [
                                        'percentage'   => $percentage[$count],
                                    ]
                                );
                            }
                        }
                    }
                }

                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }

            return redirect(route('company.job_order.view_title_order',[$trimmedNoteType,$id]))->with('flash_success', $data["note_type"].' Book order updated successfully');
        }

        public function updateCartNoteBookOrder($data){
            DB::beginTransaction();
            try{
                $id = request()->job_id;
                $user = Auth::user();
                $order_date = date('Y-m-d');

                $customer_id                =  $data['customer_id'];
                $quantity                   =  str_replace(',', '', $data['quantity']);
                $unit_cost                  =  str_replace(',', '', $data['unit_cost']);
                $ink                        =  $data['ink'];
                $leaves                     =  $data['leaves'];
                $paper_type                 =  $data['paper_type'];
                $production_time            =  $data['production_time'];
                $thickness                  =  $data['thickness'];
                $proof_needed               =  $data['proof_needed'];
                $total_cost                 =  str_replace(',', '',$data['total_cost']);
                $amount_paid                =  str_replace(',', '', $data['amount_paid']);
                $payment_type               =  $data['payment_type'];
                $location                   =  $data['location'];

                $marketerId = User::find($customer_id)->marketer_id;

                $trimmedNoteType = str_replace(' ', '_', request('note_type'));
                //save to job
                $job_order =  JobOrder::find($id);
                $job_order->user_id         = $customer_id;
                // $job_order->marketer_id     = $marketerId ?? null;
                $job_order->job_order_name  = $data['note_type'] ?? null;
                $job_order->leaves          = $leaves;
                $job_order->quantity        = $quantity;
                $job_order->unit_cost       = $unit_cost;
                $job_order->ink             = $ink;
                $job_order->paper_type      = $paper_type;
                $job_order->production_days = $production_time;
                $job_order->thickness       = $thickness;
                $job_order->proof_needed    = $proof_needed;
                $job_order->total_cost      = $total_cost;
                $job_order->job_location_id = $location;
                $job_order->updated_by      = $user->id;
                $job_order->posted_cheque_due_date  = $data['posted_cheque_date'];
                $pp = $job_order->save();

                $marketer_commission_id = $data['marketer_commission_id'];
                $marketerId = $data['marketer_id'];
                $percentage = $data['percentage'];


                // $marketer_id = $request->marketer_id ?? [];
                //$marketerId = $data['marketer_id'];
              //  dd($marketerId);
                $comm_id = MarketerCommission::where('job_order_id', request()->id);
                $comm_id->delete();
              //  dd($comm_id);
                if ($pp) {

                    if (!empty($marketerId) && !empty($percentage)) {
                        for ($count = 0; $count < count($marketerId); $count++) {
                            if (!empty($marketerId[$count]) && !empty($percentage[$count])) {
                                MarketerCommission::updateOrCreate(
                                    [
                                        'job_order_id' => $job_order->id,
                                        'company_id'   => $user->company_id,
                                        'marketer_id'  => $marketerId[$count],
                                    ],
                                    [
                                        'percentage'   => $percentage[$count],
                                    ]
                                );
                            }
                        }
                    }

                }

                // JobPaymentHistory::updateJobPaymentHistory($id, $customer_id, $user->company_id, $amount_paid, $payment_type, $order_date, $user->id);

                DB::commit();
             }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later 1');
             }
            // return redirect(route('job_order.view_order',['Eighty_Leaves',$id]))->with('flash_success','Eighty Leaves Book order updated successfully');
            return redirect(route('company.customers.view_cart_order',[$job_order->user_id, $id]))->with('flash_success', 'Cart order updated successfully');
            // return redirect(route('customers.customer_cart', $customer_id))->with('flash_success','Product added to Cart');
        }

    }

?>
