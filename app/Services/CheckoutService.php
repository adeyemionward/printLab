<?php
    namespace App\Services;

    use Illuminate\Http\Request;
    use App\Models\JobOrder;
    use App\Models\User;
    use App\Models\JobOrderTracking;
    use Illuminate\Support\Facades\Auth;
    use App\Mail\CustomerOrderReceipt;
    use Illuminate\Support\Facades\DB;


    use Mail;
    use Illuminate\Support\Facades\Validator;
    use Barryvdh\DomPDF\Facade\Pdf;
    class CheckoutService
    {
        protected $auth;
        protected $jobOrder;
        protected $user;
        protected $mail;
        protected $order_date;

        public function __construct(Auth $auth, JobOrder $jobOrder, User $user, Mail $mail){
            $this->auth = $auth;
            $this->jobOrder = $jobOrder;
            $this->user = $user;
            $this->mail = $mail;
            $this->order_date = date('Y-m-d');
        }

        protected function updateJobOrders($user, $jobIds,  $order_date, $randomInteger){
            $this->jobOrder->whereIn('id', $jobIds)->update([
                'user_id' => $user,
                'cart_order_status' => 2,
                'order_no' => $randomInteger,
            ]);

            foreach ($jobIds as $jobId) {
                DB::table('job_order_trackings')->insert([
                    'job_order_id' => $jobId,
                    'pending_status' => 1,
                    'pending_date' => $order_date
                ]);
            }
        }


        protected function sendOrderEmails($user, $jobIds){
            $userDetails = $this->user->find($this->auth::user()->id);
            $userEmail = $userDetails->email;
            $userName = $userDetails->firstname . ' ' . $userDetails->lastname;

            $orderDetails = $this->jobOrder->whereIn('id', $jobIds)->get();

            $pdfAttachment = Pdf::loadView('invoice_attachment', [
                'amount_paid' => 0,
                'userDetails' => $userDetails,
                'orderDetails' => $orderDetails,
            ]);

            $this->mail::to($userEmail)->send(new CustomerOrderReceipt($orderDetails, 0, $userName, $pdfAttachment));
            $this->mail->to(env('MAIL_USERNAME'))->send(new CustomerOrderToAdmin($orderDetails, 0, $userName, $pdfAttachment));
        }


        public function processCheckout(){
            if (!$this->auth::check()) {
                return redirect(route('login', ['status' => 'order']));
            }

            $user = $this->auth::user();
            $jobIds = request('job_id');
            $randomInteger = random_int(100000, 999999);

            $this->updateJobOrders($user->id, $jobIds, $this->order_date, $randomInteger);
            $this->sendOrderEmails($user->id, $jobIds);

            return redirect(route('track_orders.index'))->with('flash_success', 'Product Order Successful');
        }
    }

