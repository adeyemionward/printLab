@extends('company.layout.master')
@section('title', 'Inventory List')

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row mt-2">
            <div class="col-md-6 float-start">
                <h4 class="m-0 text-dark text-muted">Inventory List</h4>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Inventory</li>
                </ol>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h5 class="card-title text-muted mb-0">Items & Stock Levels</h5>
            </div>

            <div class="card-body p-3">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th>Unit</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Current Stock</th>
                            <th class="text-center">Min Stock</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->category->category_name  }}</td>
                            <td class="text-center">{{ $item->current_stock }}</td>
                            <td class="text-center">{{ $item->min_stock }}</td>
                            <td class="text-center">
                                @if($item->current_stock == 0)
                                    <span class="badge bg-danger">Out of Stock</span>
                                @elseif($item->current_stock <= $item->min_stock)
                                    <span class="badge bg-warning text-dark">Low Stock</span>
                                @else
                                    <span class="badge bg-success">In Stock</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- Add Stock --}}
                                <button type="button" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#addStockModal{{ $item->id }}">
                                    Add Stock
                                </button>

                                {{-- Remove Stock --}}
                                <button type="button" class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#removeStockModal{{ $item->id }}">
                                    Remove Stock
                                </button>

                                {{-- Edit --}}
                                <button type="button" class="btn btn-sm btn-secondary mb-1" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">
                                    Edit
                                </button>

                                {{-- View Logs --}}
                                <a href="{{ route('company.inventory.logs', $item->id) }}" class="btn btn-sm btn-info mb-1">
                                    Logs
                                </a>

                                {{-- Delete with confirmation --}}
                                <form action="{{ route('company.inventory.delete', $item->id) }}" method="GET" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger mb-1">Delete</button>
                                </form>
                            </td>

                        </tr>

                        {{-- Add Stock Modal --}}
                        <div class="modal fade" id="addStockModal{{ $item->id }}" tabindex="-1" aria-labelledby="addStockLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('company.inventory.addStock', $item->id) }} ">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addStockLabel{{ $item->id }}">Add Stock - {{ $item->item_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Quantity to Add</label>
                                                <input type="number" name="quantity" class="form-control" min="1" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Note (optional)</label>
                                                <input type="text" name="note" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="supplier_id">Supplier:</label>
                                                <select  name="supplier_id" id="supplier_id"
                                                        class="form-control{{ $errors->has('supplier_id') ? ' is-invalid' : '' }}">
                                                    <option value="">-- Select Supplier --</option>
                                                    @forelse ($suppliers as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ old('supplier_id') }}>
                                                            {{ $row->company_name }}
                                                        </option>
                                                    @empty
                                                        <option value="">No categories available</option>
                                                    @endforelse
                                                </select>
                                                @error('supplier_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Add Stock</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Remove Stock Modal --}}
                        <div class="modal fade" id="removeStockModal{{ $item->id }}" tabindex="-1" aria-labelledby="removeStockLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('company.inventory.removeStock', $item->id) }} "  method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="removeStockLabel{{ $item->id }}">Remove Stock - {{ $item->item_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Quantity to Remove</label>
                                                <input type="number" name="quantity" class="form-control" min="1" max="{{ $item->current_stock }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Note (optional)</label>
                                                <input type="text" name="note" class="form-control">
                                            </div>

                                            <div class=" mb-3">
                                                <label for="receiver_id">Staff Receiver:</label>
                                                <select name="receiver_id" id="receiver_id"
                                                        class="form-control{{ $errors->has('receiver_id') ? ' is-invalid' : '' }}">
                                                    <option value="">-- Select Receiver --</option>
                                                    @forelse ($users as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ old('receiver_id') }}>
                                                            {{ $row->firstname.' '.$row->lastname }}
                                                        </option>
                                                    @empty
                                                        <option value="">No categories available</option>
                                                    @endforelse
                                                </select>
                                                @error('receiver_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Remove Stock</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Edit Item Modal --}}
                        <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" aria-labelledby="editItemLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('company.inventory.update', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editItemLabel{{ $item->id }}">Edit Item - {{ $item->item_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Item Name</label>
                                                <input type="text" name="item_name" class="form-control" value="{{ $item->item_name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Unit</label>
                                                <input type="text" name="unit" class="form-control" value="{{ $item->unit }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Minimum Stock</label>
                                                <input type="number" name="min_stock" class="form-control" value="{{ $item->min_stock }}" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control">{{ $item->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary">Save Changes</button>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

@endsection
