<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SavingsLoanPayout;
use App\Services\SavingsService;
use App\Repository\SavingsRepository;
use App\Http\Requests\SavingsContributionPaymentRequest;
use App\Http\Requests\SavingsContributionPayoutRequest;
use App\Http\Requests\SavingsLoanPayoutRequest;
use App\Http\Requests\SavingsLoanRepaymentRequest;

class SavingController extends Controller
{

    protected  $savingsservice;
    protected  $savingsrepository;
    public function __construct(SavingsRepository $savingsrepository, SavingsService $savingsservice){
        $this->savingsrepository = $savingsrepository;
        $this->savingsservice = $savingsservice;
    }

    public function listContributionsPayments()
    {
        $contribution_payments = $this->savingsrepository->getContributionPayment();
        return view('dashboard.admin.savings.contributions.payments.index', compact('contribution_payments'));
    }


    public function storeContributionsPayments(SavingsContributionPaymentRequest $request)
    {
        return $this->savingsservice->postContributionPayment($request);
    }

    public function listContributionsPayouts()
    {
        $contribution_payments = $this->savingsrepository->getContributionPayout();
        return view('dashboard.admin.savings.contributions.payouts.index', compact('contribution_payments'));
    }

    public function storeContributionsPayouts(SavingsContributionPayoutRequest $request)
    {
        return $this->savingsservice->postContributionPayout($request);
    }

    public function getMemberLoans($member_id){

        $loan_payouts = SavingsLoanPayout::where('member_id', $member_id)->get();
        return response()->json($loan_payouts);
    }

    public function listLoansPayments()
    {
        $loan_repayments = $this->savingsrepository->getLoanPayment();
        $loan_payouts = $this->savingsrepository->getLoanPayout();
        return view('dashboard.admin.savings.loans.repayments.index', compact('loan_repayments','loan_payouts'));
    }

    public function storeLoansRepayments(SavingsLoanRepaymentRequest $request)
    {
        return $this->savingsservice->postLoanRepayment($request);
    }


    public function listLoansPayouts()
    {
        $loan_payouts = $this->savingsrepository->getLoanPayout();
        return view('dashboard.admin.savings.loans.payouts.index', compact('loan_payouts'));
    }


    public function storeLoansPayouts(SavingsLoanPayoutRequest $request)
    {
        return $this->savingsservice->postLoanPayout($request);
    }
}
