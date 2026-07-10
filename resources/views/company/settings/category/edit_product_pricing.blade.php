@extends('company.layout.master')
@section('content')
@section('title', 'Product Pricing Edit')
@php $page = 'product_pricing' @endphp

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Product Pricing Edit</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{ route('company.settings.category.all_product_pricing') }}">
                            <li class="active btn btn-primary">All Product Pricing</li>
                        </a>
                    </ol>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">
                                                Edit Product Pricing
                                            </h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server" role="tabpanel" aria-labelledby="nav-server-tab">
                                                        

                                                        <form method="POST" id="edit-product-pricing" class="edit-product-pricing" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('POST')

                                                            <table id="products" class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product Type</th>
                                                                        <th>Min Qty</th>
                                                                        <th>Max Qty</th>
                                                                        <th>Unit Cost (₦)</th>
                                                                        <th style="width: 50px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="product-row">
                                                                        <td style="width: 35%;">
                                                                            <select required class="form-control select2-pricing" name="name">
                                                                                <option value="" disabled {{ !isset($productPricingVolume) ? 'selected' : '' }}>Select a Product Type...</option>
                                                                                @foreach($productTypes as $type)
                                                                                    <option value="{{ $type->id }}" {{ isset($productPricingVolume) && $productPricingVolume->product_type_id == $type->id ? 'selected' : '' }}>
                                                                                        {{ $type->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" required min="1" class="form-control" name="min_qty" placeholder="e.g. 100" value="{{ $productPricingVolume->min_qty ?? '' }}"/>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" required min="1" class="form-control" name="max_qty" placeholder="e.g. 500" value="{{ $productPricingVolume->max_qty ?? '' }}"/>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" step="0.01" required min="0" class="form-control" name="cost" placeholder="e.g. 150.00" value="{{ $productPricingVolume->cost ?? '' }}"/>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <hr/>
                                                            <button class="btn btn-sm btn-danger" type="submit">
                                                                <i class="text-white me-2" data-feather="check-circle"></i>Update Pricing
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
@endsection

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
$(document).ready(function() {
    // Initialize standard Select2 for row elements on load
    $('.select2-pricing').select2({ width: '100%' });

    // Handle creation cloning mapping tracking elements
    $('#add-product').on('click', function() {
        var $firstRow = $('.product-row:first');
        
        // Safely detach select2 structure context references
        $firstRow.find('select').select2('destroy');
        
        var newRow = $firstRow.clone();
        
        // Re-bind template select element
        $firstRow.find('select').select2({ width: '100%' });

        // Wipe default content structural elements clear out
        newRow.find('input').val('');
        newRow.find('select').val('').trigger('change');
        
        $('#products tbody').append(newRow);
        
        // Initialize Select2 specifically on our freshly generated row selector elements
        newRow.find('select').select2({ width: '100%' });
    });

});
</script>