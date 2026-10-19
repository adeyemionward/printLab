
@extends('company.layout.master')
@section('content')
@section('title', 'View Expense')
@php $page = 'view_expense' @endphp
<style>
    .question{
        color:red;
        font-weight: bold;
        width: 20% !important;
    }
    th, td {
  padding: 5px;
}
</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Expense</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Expense</li>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('company.finance.expenses.expense_view_inc')

                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">View Expense</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 ">
                                                            <div class="col-md-12">
                                                               <table width="100%" class="details">
    <tr class="det">
        <td width="15%" class="question">Expense Id :</td>
        <td>{{ $expense->id ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td width="15%" class="question">Created By :</td>
        <td>{{ optional($expense->createdBy)->firstname . ' ' . optional($expense->createdBy)->lastname ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td width="15%" class="question">Created At :</td>
        <td>{{ $expense->created_at ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td width="15%" class="question">Updated By :</td>
        <td>{{ optional($expense->updatedBy)->firstname . ' ' . optional($expense->updatedBy)->lastname ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td width="15%" class="question">Updated At :</td>
        <td>{{ $expense->updated_at ?? 'N/A' }}</td>
    </tr>
    <tr class="det">
        <td width="15%" class="question">Expense Title :</td>
        <td>{{ $expense->title ?? 'N/A' }}</td>
    </tr>
    <tr class="det">
        <td width="15%" class="question">Category :</td>
        <td>{{ optional($expense->categoryName)->category_name ?? 'N/A' }}</td>
    </tr>
    <tr class="det">
        <td width="15%" class="question">Supplier :</td>
        <td>{{ optional($expense->supplierCompany)->company_name ?? 'N/A' }}</td>
    </tr>
    <tr class="det">
        <td width="15%" class="question">Total Cost :</td>
        <td>&#8358;{{ isset($expense->total_cost) ? number_format($expense->total_cost, 2) : 'N/A' }}</td>
    </tr>
    <tr class="det">
        <td width="15%" class="question">Payment Type :</td>
        <td>{{ $expense->payment_type ?? 'N/A' }}</td>
    </tr>
    <tr class="det">
        <td width="15%" class="question">Amount Paid :</td>
        <td>&#8358;{{ number_format(optional($expense->expenseHistories)->sum('amount_paid') ?? $expense->amount_paid ?? 0, 2) }}</td>
    </tr>
    <tr class="det">
        <td width="15%" class="question">Expense Date :</td>
        <td>{{ $expense->expense_date ? date('D M d, Y', strtotime($expense->expense_date)) : 'N/A' }}</td>
    </tr>
</table>
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
@endsection
