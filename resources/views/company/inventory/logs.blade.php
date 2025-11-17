@extends('company.layout.master')
@section('title', 'Stock Logs')

@section('content')

<div class="content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row mt-2">
            <div class="col-md-6 float-start">
                <h4 class="m-0 text-dark text-muted">Stock Logs - {{ $item->item_name }}</h4>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="{{ route('company.inventory.list') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stock Logs</li>
                </ol>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="card mt-3">
            <div class="card-header bg-white">
                <h5 class="card-title text-muted mb-0">Stock Movements</h5>
            </div>

            <div class="card-body p-3">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th class="text-center">Previous Stock</th>
                            <th class="text-center">Quantity Changed</th>
                            <th class="text-center">Current Stock</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($log->type === 'IN')
                                    <span class="badge bg-success">Added</span>
                                @else
                                    <span class="badge bg-danger">Removed</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $log->previous_stock }}</td>
                            <td class="text-center">{{ $log->qty_change }}</td>
                            <td class="text-center">{{ $log->current_stock }}</td>
                            <td>{{ $log->note ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No stock movements found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <a href="{{ route('company.inventory.list') }}" class="btn btn-secondary mt-2">Back to Inventory</a>
            </div>
        </div>

    </div>
</div>

@endsection
