
@extends('company.layout.master')
@section('content')
@section('title', 'Add Role to User')
@php $page = 'role'; @endphp


    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">User</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
            </div>
            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('company.users.side_inc')
                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">Add User Role</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 mb-3 mt-12">
                                                            <div class="col-md-12">
                                                                <form method="POST"  id="edit_user" class="edit_user">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="row">
                                                                        <div class="form-group mt-3 mb-3 col-md-3">
                                                                            <label for="email">Email:</label>
                                                                            @foreach ($roles as $val)
                                                                                <select name="role" id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">
                                                                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                                                                </select>
                                                                            @endforeach

                                                                            @error('role')
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

                <!-- 							Canvas Wrapper End -->

            </div>
        </div>
    </div>
@endsection


