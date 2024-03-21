
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
                                            <h5 class="card-title mb-0 text-muted">Edit Subscription Plan</h5>
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
                                                                                                                                          
                                                                        <div class="form-group mt-3 mb-3 col-md-6">
                                                                            <label for="name">Subscription Plan:</label>
                                                                            <select required name="name" id="" class="form-select form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                                                                <option value="">Select Plan</option>
                                                                                <option value="Quaterly"    <?php  if($sub->name  ==   'Quaterly')  echo 'selected'?>>Quaterly</option>
                                                                                <option value="Bi-Annual"   <?php  if($sub->name  ==   'Bi-Annual') echo 'selected'?>>Bi-Annual</option>
                                                                                <option value="Annual"      <?php  if($sub->name  ==   'Annual')    echo 'selected'?>>Annual</option>
                                                                            </select>
                                                                            @error('name')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        
                                                                        <div class="form-group mt-3 mb-3 col-md-6">
                                                                            <label for="amount">Amount:</label>
                                                                            <input type="text" required name="amount" id="amount" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$sub->amount}}">
                                                                            @error('amount')
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


