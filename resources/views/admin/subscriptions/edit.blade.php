
@extends('admin.layout.master')
@section('content')
@section('title', 'Add Subscription')

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Subscription</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Subscription</li>
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
                                            <h5 class="card-title mb-0 text-muted">Create Subscription Details</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 mb-3 mt-3">
                                                            <div class="col-md-12">
                                                                <form method="POST"  id="add_company" class="add_company">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="row">

                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="status">Company:</label>
                                                                            <select name="company_id" id="" class="form-select form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{ old('company') }}">
                                                                                <option value="">--Select Company--</option>
                                                                                @forelse ($companies as $val)
                                                                                    <option value="{{$val->id}}" <?php if($subscription->company_id == $val->id) echo 'selected' ?>>{{$val->name}}</option>
                                                                                @empty
                                                                                        
                                                                                <option value="" disabled>No company</option>
                                                                                @endforelse
                                                                            </select>
                                                                            @error('company')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        
                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="sub_amount">Subscription Plan:</label>
                                                                            <select required name="subscription_plan" id="" class="form-select form-control{{ $errors->has('subscription_plan') ? ' is-invalid' : '' }}" >
                                                                                <option value="">Select Subscription Plan</option>
                                                                                @foreach ($subs as $val)
                                                                                    <option value="{{$val->name}}" <?php if($subscription->plan == $val->name) echo 'selected' ?>>{{$val->name.'----'.$val->amount}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('subscription_plan')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="sub_start_date">Start Date:</label>
                                                                            <input required type="date" name="sub_start_date" id="sub_start_date" class="form-control{{ $errors->has('sub_start_date') ? ' is-invalid' : '' }}" value="{{$subscription->sub_start_date ?? '' }}">
                                                                            @error('sub_start_date')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="sub_end_date">End Date:</label>
                                                                            <input required type="date" name="sub_end_date" id="sub_end_date" class="form-control{{ $errors->has('sub_end_date') ? ' is-invalid' : '' }}" value="{{$subscription->sub_end_date ?? '' }}">
                                                                            @error('sub_end_date')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        
                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="status">Status:</label>
                                                                            <select name="status" id="" class="form-select form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
                                                                                <option value="">--Select Status--</option>
                                                                                <option value="active" <?php if($subscription->status == 'active') echo 'selected' ?>>Active</option>
                                                                                <option value="inactive" <?php if($subscription->status == 'inactive') echo 'selected' ?>>Inactive</option>
                                                                            </select>
                                                                            @error('gender')
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


