@extends('company.layout.master')
@section('content')
@section('title', 'Product Pricing Volume')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Product Pricing Volume</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{route('company.settings.category.add_product_pricing')}}">
                            <li class="active btn btn-primary">Add Product Pricing</li>
                        </a>
                    </ol>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success m-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-2">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="content" id="tableContent">
                    <div class="canvas-wrapper">
                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product Type Name</th>
                                    <th>Min Qty</th>
                                    <th>Max Qty</th>
                                    <th>Unit Cost (₦)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productPricingVolumes as $index => $pricing)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        
                                        <td>{{ $pricing->productType->name ?? 'N/A' }}</td>
                                        
                                        <td>{{ number_format($pricing->min_qty) }}</td>
                                        <td>{{ number_format($pricing->max_qty) }}</td>
                                        <td>₦{{ number_format($pricing->cost, 2) }}</td>
                                        
                                        <td>
                                            <a href="{{ route('company.settings.category.edit_product_pricing', $pricing->id) }}" title="Edit Pricing">
                                                <span><i class="fa fa-edit me-2"></i></span>
                                            </a>
                                            <a href="{{ route('company.settings.category.delete_product_pricing', $pricing->id) }}" onclick="return confirm('Are you sure you want to delete this pricing?');" title="Delete Pricing" class="text-danger">
                                                <span><i class="fa fa-trash"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection