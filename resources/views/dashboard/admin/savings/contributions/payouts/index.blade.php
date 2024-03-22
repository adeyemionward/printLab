
@extends('layout.master')
@section('content')
@section('title', 'All Savings Payouts')
{{-- start pay modal --}}
<!-- CSS -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



<form method="POST"  action="{{route('dashboard.admin.savings.contributions.payouts.post')}}" class="">
    @csrf
    @method('POST')
    <div class="modal fade" id="exampleModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Money for savings contributions </h5> <br>

                    <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group col-md-12">
                        <label for="backsided">Select the customer</label>
                        <select required class="form-control form-select select-member"  name="member_id" id="member-select"  style="width: 100%;">
                            <option >--select a customer--</option>
                            @forelse ($members as $val) {{--members is from usertype provider --}}
                                <option value="{{$val->id}}">{{$val->firstname.' '.$val->lastname}}</option>
                            @empty
                                <option value="" disabled>No members available</option>
                            @endforelse
                        </select>
                    </div> <br>
                    <div class="form-group col-md-12">
                        <label for="amount_paid">Amount Paid</label>
                        <input required type="number" name="amount" class="form-control">
                    </div> <br>
                    <div class="form-group col-md-12">
                        <label for="date_paid">Date Paid</label>
                        <input required type="date" name="date" class="form-control" value="{{date('Y-m-d')}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="text-white me-2" data-feather="check-circle"></i>Send Money
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- end pay modal --}}
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Cooperative Contributions Payout</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a style="cursor: pointer" id="myBtn1" data-bs-toggle="modal" data-bs-target="#exampleModal" class=" btn btn-success"
                            aria-selected="false">Send Money</a>
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
                                    <th>Customer Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contribution_payments as $val)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$val->member->firstname.' '. $val->member->lastname}}</td>
                                        <td>
                                            {{'₦'.$val->amount}}
                                            <p style="font-size: 12px">Current:
                                                <span style="color: green; font-weight:600">₦{{$val->total_amount}}</span>
                                            </p>
                                        </td>
                                        <td>{{date('D M d, Y', strtotime($val->date))}}</td>
                                        <td><a href=""><span><i class="fa fa-edit"></i></span></a></td>
                                    </tr>
                                @empty

                                @endforelse

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function() {
    $('.select-member').select2();
});
    </script>
@endsection

