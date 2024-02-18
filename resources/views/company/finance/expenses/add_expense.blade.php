
@extends('layout.master')
@section('content')
@section('title', 'Add Expense')

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Expense</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{route('finance.expenses.all_expenses')}}"><li class="active btn btn-primary" style="">Expenses List</li></a>
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
                                            <h5 class="card-title mb-0 text-muted">Create Expense</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 mb-3 mt-3">
                                                            <div class="col-md-12">
                                                                <form method="POST"  id="add_twenty_leaves" class="add_twenty_leaves">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="row">

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlInput1">Expense Title </label>
                                                                            <input type="text" required name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" id="title">
                                                                            @error('title')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="size">Supplier  </label>
                                                                            <select name="supplier_id" required class="form-control {{ $errors->has('supplier_id') ? ' is-invalid' : '' }} form-select"   id="supplier_id">
                                                                                <option value="">--Select Supplier--</option>
                                                                                @foreach ($suppliers as $val)
                                                                                    <option value="{{$val->id}}">{{$val->company_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('supplier_id')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="size">Category  </label>
                                                                            <select name="category_id" required class="form-control {{ $errors->has('category_id') ? ' is-invalid' : '' }} form-select"  id="exampleFormControlSelect1">
                                                                                <option value="">--Select Category--</option>
                                                                                @foreach ($categories as $val)
                                                                                    <option value="{{ $val->id }}">{{$val->category_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('category_id')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlInput1">Total Cost </label>
                                                                            <input type="number" required name="total_cost" class="form-control {{ $errors->has('total_cost') ? ' is-invalid' : '' }}" value="{{ old('total_cost') }}"  id="total_cost">
                                                                            @error('total_cost')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="proof_needed">Payment Type</label>
                                                                            <select class="form-control {{ $errors->has('payment_type') ? ' is-invalid' : '' }} form-select" name="payment_type" value="{{ old('payment_type') }}" required>
                                                                                <option value="">--Select Payment Type--</option>
                                                                                <option value="Full Payment">Full Payment</option>
                                                                                <option value="Part Payment">Part Payment</option>
                                                                            </select>
                                                                            @error('payment_type')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlInput1"> Amount Paid </label>
                                                                            <input type="number" required name="amount_paid" class="form-control{{ $errors->has('amount_paid') ? ' is-invalid' : '' }}" value="{{ old('amount_paid') }}"  id="amount_paid">
                                                                            @error('amount_paid')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlInput1">Expense Date </label>
                                                                            <input type="date" required name="expense_date" class="form-control {{ $errors->has('expense_date') ? ' is-invalid' : '' }} " value="{{ old('expense_date') }}"  id="expense_date">
                                                                            @error('expense_date')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-12">
                                                                            <label for="exampleFormControlInput1">Description </label>
                                                                            <textarea name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }} " id="" cols="10" rows="3">{{ old('description') }}</textarea>
                                                                            @error('description')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <button class="btn btn-sm btn-danger" type="submit">
                                                                        <i class="text-white me-2" data-feather="check-circle"></i>Save
                                                                    </button>
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
@endsection
