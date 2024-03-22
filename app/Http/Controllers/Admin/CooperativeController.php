<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CooperativeLoanPayout;
use App\Services\CooperativeService;
use App\Repository\CooperativeRepository;
use App\Http\Requests\CooperativeContributionPaymentRequest;
use App\Http\Requests\CooperativeContributionPayoutRequest;
use App\Http\Requests\CooperativeLoanPayoutRequest;
use App\Http\Requests\CooperativeLoanRepaymentRequest;


class CooperativeController extends Controller
{
    protected  $cooperativerepository;
    protected  $cooperativeservice;

    public function __construct(CooperativeRepository $cooperativerepository, CooperativeService $cooperativeservice){
        $this->cooperativerepository = $cooperativerepository;
        $this->cooperativeservice = $cooperativeservice;
    }

    public function listContributionsPayments()
    {
        $contribution_payments = $this->cooperativerepository->getContributionPayment();
        return view('dashboard.admin.cooperative.contributions.payments.index', compact('contribution_payments'));
    }

    public function storeContributionsPayments(CooperativeContributionPaymentRequest $request)
    {
        return $this->cooperativeservice->postContributionPayment($request);
    }

    public function listContributionsPayouts()
    {
        $contribution_payments = $this->cooperativerepository->getContributionPayout();
        return view('dashboard.admin.cooperative.contributions.payouts.index', compact('contribution_payments'));
    }



    public function storeContributionsPayouts(CooperativeContributionPayoutRequest $request)
    {
        return $this->cooperativeservice->postContributionPayout($request);
    }

    public function getMemberLoans($member_id){

        $loan_payouts = CooperativeLoanPayout::where('member_id', $member_id)->get();
        return response()->json($loan_payouts);
    }

    public function listLoansPayments()
    {
        $loan_repayments = $this->cooperativerepository->getLoanPayment();
        $loan_payouts = $this->cooperativerepository->getLoanPayout();
        return view('dashboard.admin.cooperative.loans.repayments.index', compact('loan_repayments','loan_payouts'));
    }


    public function storeLoansRepayments(CooperativeLoanRepaymentRequest $request)
    {
        return $this->cooperativeservice->postLoanRepayment($request);
    }

    public function listLoansPayouts()
    {
        $loan_payouts = $this->cooperativerepository->getLoanPayout();
        return view('dashboard.admin.cooperative.loans.payouts.index', compact('loan_payouts'));
    }

    public function storeLoansPayouts(CooperativeLoanPayoutRequest $request)
    {
        return $this->cooperativeservice->postLoanPayout($request);
    }

}
