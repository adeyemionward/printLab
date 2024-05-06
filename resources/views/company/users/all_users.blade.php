
@extends('company.layout.master')
@section('content')
@section('title', 'All Users')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Users</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">All users</li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="content" id="tableContent">

                    <div class="canvas-wrapper">

                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $val)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$val->firstname}}</td>
                                        <td>{{$val->lastname}}</td>
                                        <td>{{$val->email}}</td>
                                        <td>{{$val->phone}}</td>
                                        <td>{{$val->address}}</td>
                                        <td><a href="{{route('company.users.edit_user',$val->id)}}"><span><i class="fa fa-edit"></i></span></a></td>
                                    </tr>
                                @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

