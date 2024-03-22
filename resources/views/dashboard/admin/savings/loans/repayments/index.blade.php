
@extends('layout.master')
@section('content')
@section('title', 'All Savings Loans')
{{-- start pay modal --}}
<!-- CSS -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



<form method="POST"  action="{{route('dashboard.admin.savings.loans.repayments.post')}}" class="">
    @csrf
    @method('POST')
    <div class="modal fade" id="exampleModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Money for savings Loans Repayment </h5> <br>

                    <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group col-md-12">
                        <label for="backsided">Select the customer</label>
                        <select required class="form-control form-select select-member"  name="member_id" id="member-select"  style="width: 100%;">
                            <option value="">--select a customer--</option>
                            @forelse ($members as $val) {{--members is from usertype provider --}}
                                <option value="{{$val->id}}">{{$val->firstname.' '.$val->lastname}}</option>
                            @empty
                                <option value="" disabled>No members available</option>
                            @endforelse
                        </select>
                    </div> <br>

                    <div class="form-group col-md-12">
                        <label for="backsided">Select Loan</label> <span id="loading-icon" style="margin-left: 200px; color:blue">Loading...</span>
                        <select required class="form-control form-select select-member"  name="loan_payout_id" id="loan_payout_id"  style="width: 100%;">
                            <option value="" >--select loan--</option>

                        </select>
                    </div> <br>
                    <div class="form-group col-md-12">
                        <label for="amount_paid">Amount Paid <span style="margin-left: 200px; color:red">use savings <input type="checkbox" id="use_savings" name="use_savings"></span> </label>
                        <input required type="number" name="amount_repayed" class="form-control">
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
                        <i class="text-white me-2" data-feather="check-circle"></i>Add Money
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
                    <h4 class="m-0 text-dark text-muted">Cooperative Loans Repayments</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a style="cursor: pointer" id="myBtn1" data-bs-toggle="modal" data-bs-target="#exampleModal" class=" btn btn-success"
                            aria-selected="false">Add Money</a>
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
                                    <th>Loan ID</th>
                                    <th>Customer Name</th>
                                    <th>Amount</th>
                                    <th>Loan Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loan_repayments as $val)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>00</td>
                                        <td>{{$val->member->firstname.' '. $val->member->lastname}}</td>
                                        <td>
                                            {{'₦'.$val->amount_repayed}}
                                            <p style="font-size: 12px">Total Repayment:
                                                <span style="color: green; font-weight:600">₦{{$val->loan_details->amount_repayed}}</span>
                                            </p>
                                        </td>
                                        <td>{{$val->loan_details->amount_payout}}</td>
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script>

    $('#loading-icon').hide();
    $(document).on('change', '#member-select', function() {
        console.log('hello');
        var member_id = $(this).val();
        $('#loading-icon').show();

        $.ajax({
            url: '/get-member-savings-loans/' + member_id,
            type: 'GET',
            success: function(response) {
                var options = '<option value="">--select loan--</option>';
                if (response.length > 0) {
                    $.each(response, function(index, loan) {
                        options += '<option value="' + loan.id + '">₦' + loan.amount_payout + ' ---- Loan ID: 00' + loan.id + '</option>';
                    });
                } else {
                    options += '<option value="" disabled>No loans available for this member</option>';
                }

                $('#loan_payout_id').html(options);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            },
            complete: function() {
                // Hide loading icon after request completion
                $('#loading-icon').hide();
            }
        });
    });
    </script>
@endsection

