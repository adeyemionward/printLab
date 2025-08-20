
@extends('company.layout.master')
@section('content')
@section('title', 'Add Payment')

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Customer Payments</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{route('company.finance.transactions.all_transactions')}}"><li class="active btn btn-primary" style="">Customer Payments List</li></a>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                {{-- @include('job_order.job_order_inc') --}}

                                <div class="col-md-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">Create Customer Payment</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 mb-3 mt-3">
                                                            <div class="col-md-12">
                                                                <form method="POST" >
    @csrf

    <div class="row">
        <div class="form-group mt-3 mb-3 col-md-12">
            <label for="customer_id">Select Company</label>
            <select name="customer_id" id="customer_select" required class="form-control form-select">
                <option value="">-- Select Company --</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <hr>

    <div id="payment_repeater">
        <div id="payment_rows_container">
            <div class="row payment-row align-items-end">

                <div class="form-group mt-3 mb-3 col-md-4">
                    <label>Job Order</label>
                    <select name="order_id[]" required class="form-control form-select job-order-select">
                        <option value="">-- Select a Company First --</option>
                    </select>
                </div>

               

                <div class="form-group mt-3 mb-3 col-md-3">
                    <label>Payment Type</label>
                    <select class="form-control form-select payment-type-select" name="payment_type[]" required>
                        <option value="">-- Select Type --</option>
                        <option value="Full Payment">Full Payment</option>
                        <option value="Part Payment">Part Payment</option>
                    </select>
                </div>

                <div class="form-group mt-3 mb-3 col-md-3">
                    <label>Amount Paid</label>
                    <input type="text" required name="amount_paid[]" class="form-control numberFormat">
                </div>

                <div class="form-group mt-3 mb-3 col-md-2">
                    <button type="button" class="btn btn-danger remove-payment-row">Remove</button>
                </div>

            </div></div>

        <div class="row mt-2">
            <div class="col-md-12">
                <button type="button" id="add_payment_row" class="btn btn-success">Add Another Payment</button>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-primary" type="submit">Save Payments</button>
    </div>

</form>
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

                <!-- 							Canvas Wrapper End -->

            </div>

        </div>

    </div>
    {{-- @section('scripts') --}}

@endsection
