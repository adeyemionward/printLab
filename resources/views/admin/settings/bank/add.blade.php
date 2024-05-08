
@extends('admin.layout.master')
@section('content')
@section('title', 'Add Subscription')

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Bank Details</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{route('admin.settings.bank.list_bankaccount')}}"><li class="active btn btn-primary" style="">Add Bank Details </li></a>
                    </ol>
                </div>
            </div>
            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">Create Bank Details</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 mb-3 mt-3">
                                                            <div class="col-md-12">
                                                                <form method="POST"  id="add_subscription" class="add_subscription">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="row">
                                                                                       
                                                                        
                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="bank_name">Bank Name:</label>
                                                                            <input type="text" name="bank_name" id="bank_name" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="{{ old('bank_name') }}">
                                                                            @error('bank_name')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="account_no">Bank Account No:</label>
                                                                            <input type="text" name="account_no" id="account_no" class="form-control{{ $errors->has('account_no') ? ' is-invalid' : '' }}" value="{{ old('account_no') }}">
                                                                            @error('account_no')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="account_name">Account Name:</label>
                                                                            <input type="text" name="account_name" id="account_name" class="form-control{{ $errors->has('account_name') ? ' is-invalid' : '' }}" value="{{ old('account_name') }}">
                                                                            @error('account_name')
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


