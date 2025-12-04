@extends('company.layout.master')
@section('content')
@section('title', 'Add Inventory')

<div class="content">
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6 float-start">
                <h4 class="m-0 text-dark text-muted">Inventory</h4>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="#"> Home</a></li>
                    <li class="breadcrumb-item active">Add Inventory</li>
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
                                        <h5 class="card-title mb-0 text-muted">Create Inventory Item</h5>
                                    </div>

                                    <div class="card-body h-100">
                                        <div class="align-items-start">
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-server"
                                                    role="tabpanel" aria-labelledby="nav-server-tab">

                                                    <div class="row g-3 mb-3 mt-3">
                                                        <div class="col-md-12">

                                                            <form method="POST" id="add_inventory" class="add_inventory">
                                                                @csrf
                                                                @method('POST')

                                                                <div class="row">

                                                                    <!-- Item Name -->
                                                                    <div class="form-group mt-3 mb-3 col-md-3">
                                                                        <label for="item_name">Item Name:</label>
                                                                        <input type="text" name="item_name" id="item_name"
                                                                               class="form-control{{ $errors->has('item_name') ? ' is-invalid' : '' }}"
                                                                               value="{{ old('item_name') }}">
                                                                        @error('item_name')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>


                                                                    <!-- Unit -->
                                                                    <div class="form-group mt-3 mb-3 col-md-3">
                                                                        <label for="unit">Unit (pcs, box, ream, bottle):</label>
                                                                        <input type="text" name="unit" id="unit"
                                                                               class="form-control{{ $errors->has('unit') ? ' is-invalid' : '' }}"
                                                                               value="{{ old('unit') }}">
                                                                        @error('unit')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <!-- Minimum Stock -->
                                                                    <div class="form-group mt-3 mb-3 col-md-3">
                                                                        <label for="min_stock">Minimum Stock:</label>
                                                                        <input type="number" name="min_stock" id="min_stock"
                                                                               class="form-control{{ $errors->has('min_stock') ? ' is-invalid' : '' }}"
                                                                               value="{{ old('min_stock') }}">
                                                                        @error('min_stock')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-3">
                                                                        <label for="inventory_category_id">Category:</label>
                                                                        <select name="inventory_category_id" id="inventory_category_id"
                                                                                class="form-control{{ $errors->has('inventory_category_id') ? ' is-invalid' : '' }}">
                                                                            <option value="">-- Select Category --</option>
                                                                            @forelse ($inventoryCategories as $category)
                                                                                <option value="{{ $category->id }}"
                                                                                    {{ old('inventory_category_id') }}>
                                                                                    {{ $category->category_name }}
                                                                                </option>
                                                                            @empty
                                                                                <option value="">No categories available</option>
                                                                            @endforelse
                                                                        </select>
                                                                        @error('inventory_category_id')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>


                                                                </div>



                                                                <!-- Description -->
                                                                <div class="form-group mt-3 mb-3 col-md-12">
                                                                    <label for="description">Description:</label>
                                                                    <textarea name="description" id="description"
                                                                                class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                                    >{{ old('description') }}</textarea>
                                                                    @error('description')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <button class="btn btn-sm btn-danger" type="submit">
                                                                    <i class="text-white me-2" data-feather="check-circle"></i>
                                                                    Save
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
