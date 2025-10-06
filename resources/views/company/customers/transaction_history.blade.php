@extends('company.layout.master')
@section('content')
@section('title', 'Customer Transaction History')
@php $page = 'transaction'; @endphp

<div class="content">
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6 float-start">
                <h4 class="m-0 text-dark text-muted">
                    Transaction History for {{ $customer->firstname . ' ' . $customer->lastname }}
                </h4>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="#">Customer Transaction History</a></li>
                    <li class="breadcrumb-item active">All Transactions</li>
                </ol>
            </div>
        </div>

        <div class="content">
            <div class="canvas-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            @include('company.customers.side_inc')
                            <div class="col-md-9 col-xl-9">
                                <div class="card">
                                    <div class="content" id="tableContent">
                                        <div class="canvas-wrapper">
                                            @include('company.customers.order_date_range')

                                            <table id="example" class="table no-margin" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Payment Type</th>
                                                        <th>Amount</th>
                                                        <th>Payment Date</th>
                                                        {{-- <th>Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($job_pay_history as $index => $val)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $val->payment_type }}</td>
                                                            <td>&#8358;{{ number_format($val->amount, 2) }}</td>
                                                            <td>{{ date('D M d, Y', strtotime($val->payment_date)) }}</td>
                                                            {{-- <td>
                                                                <!-- Edit icon -->
                                                                <a href="#"
                                                                    class="text-primary edit-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editModal"
                                                                    data-id="{{ $val->id }}"
                                                                    data-amount="{{ $val->amount }}"
                                                                    data-payment-type="{{ $val->payment_type }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

<!-- Edit Amount Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editForm" method="POST" >
      @csrf
      <input type="hidden" name="id" id="payment_id">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Payment Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body row">
          <div class="mt-3 mb-3 col-md-12">
            <label for="amount">New Amount</label>
            <input
              type="number"
              step="0.01"
              class="form-control"
              id="amount"
              name="amount"
              required>
          </div>

          {{-- <div class="mt-3 mb-3 col-md-12">
            <label for="payment_type">Payment Type</label>
            <select class="form-control" name="payment_type" id="payment_type" required>
                <option value="">--Select Payment Type--</option>
                <option value="Full Payment">Full Payment</option>
                <option value="Part Payment">Part Payment</option>
                <option value="Posted Cheque">Posted Cheque</option>
            </select>
          </div> --}}
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
.modal {
    overflow: visible !important;
}
.modal-backdrop {
    z-index: 1040 !important;
}
.modal-dialog {
    z-index: 1050 !important;
}
</style>


<!-- Script to populate modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const amount = this.getAttribute('data-amount');
                const paymentType = this.getAttribute('data-payment-type');

                document.getElementById('payment_id').value = id;
                document.getElementById('amount').value = amount;

                const paymentTypeSelect = document.getElementById('payment_type');
                paymentTypeSelect.value = paymentType; // auto-select payment type
            });
        });
    });
</script>

@endsection
