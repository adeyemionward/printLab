@extends('company.layout.master')
@section('content')
@section('title', 'Add Product Catalogue')
@php $page = 'add_location' @endphp

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Product Pricing</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{route('company.settings.category.all_product_pricing')}}">
                            <li class="active btn btn-primary">All Product Pricing</li>
                        </a>
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
                                            <h5 class="card-title mb-0 text-muted">Create Product Pricing</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server" role="tabpanel">

                                                        <div class="row g-3 mb-3 mt-3">
                                                            <div class="col-md-12">
                                                                <form method="POST" id="add_twenty_leaves" class="add_twenty_leaves" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('POST')

                                                                    <div class="mb-3">
                                                                        <button type="button" id="add-product-catalogue" class="btn btn-primary mb-2">Add More</button>
                                                                    </div>

                                                                    <table id="products" class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Product Name</th>
                                                                                <th>Min Qty</th>
                                                                                <th>Max Qty</th>
                                                                                <th>Unit Cost (₦)</th>
                                                                                <th style="width: 50px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="product-row">
                                                                                <td>
                                                                                    <select required class="form-control" name="name[]">
                                                                                        <option value="" disabled selected>Select a Product Type...</option>
                                                                                        @foreach($productTypes as $type)
                                                                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" required min="1" class="form-control" name="min_qty[]" placeholder="100" />
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" required min="1" class="form-control" name="max_qty[]" placeholder="300" />
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" step="0.01" required min="0" class="form-control" name="cost[]" placeholder="50.00" />
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <button type="button" class="remove-product btn btn-danger btn-sm">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                                                        </svg>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                    <hr/>
                                                                    <button class="btn btn-sm btn-danger" type="submit">
                                                                        <i class="text-white me-2" data-feather="check-circle"></i>Save Pricing
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

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
$(document).ready(function() {
    // 1. Initialize Select2 on page load for the initial row
    $('.product-row find select').select2({
        width: '100%' // Ensures it styles properly inside bootstrap tables
    });

    // Add dynamic row functionality
    $('#add-product-catalogue').on('click', function() {
        // Find the first row
        var $firstRow = $('.product-row:first');

        // Destroy Select2 on the target template row before cloning to avoid duplicating broken Select2 HTML wrappers
        $firstRow.find('select').select2('destroy');

        // Clone the clean template structure
        var newRow = $firstRow.clone();

        // Re-initialize Select2 back onto the original first row
        $firstRow.find('select').select2({ width: '100%' });

        // Reset values inside the newly cloned inputs and dropdowns
        newRow.find('input').val('');
        newRow.find('select').val('').trigger('change'); // Reset select value safely
        
        // Append the fresh row to the table body
        $('#products tbody').append(newRow);

        // 2. Initialize Select2 explicitly on the newly appended row's select dropdown
        newRow.find('select').select2({
            width: '100%'
        });
    });

    // Remove row handling
    $('#products').on('click', '.remove-product', function() {
        if ($('#products tbody tr').length > 1) {
            // Destroy Select2 instance on this row to clean up memory before removing it
            $(this).closest('tr').find('select').select2('destroy');
            $(this).closest('tr').remove();
        } else {
            alert('At least one pricing matrix tier is required.');
        }
    });
});
</script>