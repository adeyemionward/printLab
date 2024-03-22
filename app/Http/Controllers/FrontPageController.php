<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProfileRequest;
use App\Repository\ProfileRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use App\Services\CheckoutService;


use Mail;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
// use Google\Recaptcha\Recaptcha;
class FrontPageController extends Controller
{

    public function index()
    {
        return view('index');
    }
       public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
