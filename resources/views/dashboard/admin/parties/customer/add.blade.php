
@extends('layout.master')
@section('content')
@section('title', 'Add Customer')
<style>
    .asterik{
        color:red
    }
</style>

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Customer</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
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
                                            <h5 class="card-title mb-0 text-muted">Create Customer Details</h5>

                                        </div>

                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">
                                                        <div class="row g-3 mb-3 mt-3">

                                                            <p>All Asterik <span class="asterik">(*) </span> Fields are Required</p>
                                                            <div class="col-md-12">
                                                                <form method="POST"  id="add_customer" class="add_customer">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="row">
                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="firstname">Firstname <span class="asterik">*</span></label>
                                                                            <input type="text" required name="firstname" id="firstname" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" value="{{ old('firstname') }}">
                                                                            @error('firstname')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="lastname">Lastname <span class="asterik">*</span></label>
                                                                            <input type="text" required name="lastname" id="lastname" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" value="{{ old('lastname') }}">
                                                                            @error('lastname')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="gender">Gender <span class="asterik">*</span></label>
                                                                            <select name="gender" required id="" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }} form-select" value="{{ old('gender') }}">
                                                                                <option value="male">Male</option>
                                                                                <option value="female">Female</option>
                                                                            </select>
                                                                            @error('gender')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>



                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" name="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
                                                                            @error('email')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="phone">Phone <span class="asterik">*</span></label>
                                                                            <input type="phone" required name="phone" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}">
                                                                            @error('phone')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="membership_type">Membership Type <span class="asterik">*</span></label>
                                                                            <select name="membership_type" required id="" class="form-control{{ $errors->has('membership_type') ? ' is-invalid' : '' }} form-select" value="{{ old('membership_type') }}">
                                                                                <option value="savings">Savings</option>
                                                                                <option value="cooperative">Cooperative</option>
                                                                            </select>
                                                                            @error('membership_type')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>



                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="membership_no">Membership No <span class="asterik">*</span></label>
                                                                            <input type="text" name="membership_no" id="membership_no" class="form-control{{ $errors->has('membership_no') ? ' is-invalid' : '' }}" value="{{ old('membership_no') }}">
                                                                            @error('membership_no')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">

                                                                        <div class="form-group mt-3 mb-3 col-md-12">
                                                                            <label for="address">Address <span class="asterik">*</span></label>
                                                                                <textarea name="address" required class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}"
                                                                                id="address"></textarea>
                                                                                @error('address')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                        </div>
                                                                    </div>



                                                                    <button class="btn btn-sm btn-success" type="submit">
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

                <!-- 							Canvas Wrapper End -->

            </div>
        </div>
    </div>
@endsection


