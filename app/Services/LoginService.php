<?php

    namespace App\Services;
    use App\Models\Company;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Carbon\Carbon;

    class LoginService
    {
        protected function activeSub($data){
            $email = request('email');
            $user_details = User::where('email', $email)->first();
            $today = Carbon::today()->toDateString();
            $subdomain = explode('.', $data->getHost())[0];
            $company_details = Company::where('subdomain', $subdomain)->first();


            if($company_details->id != $user_details->company_id) return response()->json([ [7] ]);

            if($company_details->status == 'inactive') return response()->json([ [9] ]); //acount is inactive

            if($company_details->sub_end_date < $today ) return response()->json([ [10] ]); // subscription expired

        }
        public function login($data){
           // try{
                $user_cred   = $data->only('email', 'password');

                $email = request('email');
                $user_details = User::where('email', $email)->first();
                if(is_null($user_details)) return response()->json([ [7] ]);

                $user_type =  $user_details->user_type;

                if (Auth::attempt($user_cred)) {
                    if($user_type == User::CUSTOMER){

                        if ($this->activeSub($data) != null){
                            return $this->activeSub($data);
                        }

                        if(request()->status == 'order'){
                            return response()->json([ [12] ]);
                        }else{
                            return response()->json([ [13] ]); //go to user page dashboard
                        }
                    }elseif($user_type == User::ADMIN){
                        return response()->json([ [1] ]); //go to admin page dashboard
                    }elseif($user_type == User::COMPANY){
                        if ($this->activeSub($data) != null){
                            return $this->activeSub($data);
                        }else{
                            return response()->json([ [3] ]); //go to company page dashboard
                        }
                    }
                }else{
                    return response()->json([ [7] ]);
                }

            // }catch (\Throwable $th){
            //     ErrorLog::log('auth', 'signin', $th->getMessage()); //log error
            //     return response()->json([ [5] ]);
            // }
        }
    }

?>
