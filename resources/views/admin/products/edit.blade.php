
@extends('layout.master')
@section('content')
@section('title', 'Dashboard')
@php $page = 'edit_product' @endphp
<style>
    .question{
        color:red;
        font-weight: bold;
        width: 20% !important;
    }
    th, td {
  padding: 5px;
}
</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Edit Product</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('products.product_view_inc')

                                <div class="col-md-9 col-xl-9">
                                    @if(request()->job_title == 'higher_notebook')
                                        <div class="card">
                                            <div class="card-header bg-white">
                                                <h5 class="card-title mb-0 text-muted">Edit Product</h5>
                                            </div>
                                            <div class="card-body h-100">
                                                <div class="align-items-start">
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-server"
                                                            role="tabpanel" aria-labelledby="nav-server-tab">

                                                            <form method="POST"  id="add_twenty_leaves" class="add_twenty_leaves" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Product Name</label>
                                                                        <select name="product_name" required class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }} form-select">
                                                                            <option value="higher_notebook" <?php if ($product->name == request()->job_title) echo 'selected' ?>>Higher Education</option>
                                                                            @error('product_name')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Upload Image <span class="text-warning">(Don't upload if you are not uploading a new image) </span>
                                                                            </label>
                                                                            <input  type="file" name="image" class="form-control"
                                                                            id="image">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="exampleFormControlSelect1">Default Ink

                                                                        </label>
                                                                        <select name="ink" required class="form-control form-select" id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Color Type--</option>
                                                                            <option value="single" <?php if ($product->ink == 'single') echo 'selected' ?>>Single Color</option>
                                                                            <option value="full" <?php if ($product->ink == 'full') echo 'selected' ?>>Full Color</option>
                                                                        </select>
                                                                    </div>


                                                                </div>


                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Production Time (Days)
                                                                            </label> <input required type="number" name="production_time" class="form-control"
                                                                            id="quantity" placeholder="eg: 4" value="{{$product->production_days}}">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="thickness">Default Cover Thickness</label>
                                                                        <select class="form-control form-select" required  name="thickness" id="thickness">
                                                                            <option value="">--Select Default Cover Thickness--</option>
                                                                            <option value="199g" <?php if ($product->thickness == '199g') echo 'selected' ?>>199g</option>
                                                                            <option value="280g" <?php if ($product->thickness == '280g') echo 'selected' ?>>280g</option>
                                                                            <option value="300g" <?php if ($product->thickness == '300g') echo 'selected' ?>>300g</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="paper_type">Default Paper Type </label>
                                                                        <select name="paper_type" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Paper Type--</option>
                                                                            <option value="50g" <?php if ($product->paper_type == '50g') echo 'selected' ?>>50g</option>
                                                                            <option value="60g" <?php if ($product->paper_type == '60g') echo 'selected' ?>>60g</option>
                                                                            <option value="70g" <?php if ($product->paper_type == '70g') echo 'selected' ?>>70g</option>
                                                                            <option value="80g" <?php if ($product->paper_type == '80g') echo 'selected' ?>>80g</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- <table id="products">

                                                                    <a id="add-product" class="btn btn-primary" >Add Pricing</a>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Quantity</th>
                                                                            <th>Price</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Initial row, can be hidden -->
                                                                        <tr class="product-row">
                                                                            <td style="width:50%"><input type="number" required class="form-control quantity"  name="quantity[]" /></td>
                                                                            <td style="width:50%"><input type="number" required class="form-control price"  name="total_cost[]" /></td>

                                                                            <td>
                                                                                <a class="remove-product btn btn-danger">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                                                    </svg>
                                                                                    </a>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table> --}}

                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-12">
                                                                        <label for="address">Product Description
                                                                            </label>
                                                                            <textarea name="description" required  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}"
                                                                            id="description">{{$product->description}}</textarea>
                                                                            @error('description')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                    </div>



                                                                </div>

                                                                <button class="btn btn-sm btn-danger" type="submit">
                                                                    <i class="text-white me-2" data-feather="check-circle"></i>Save
                                                                </button>
                                                            </form>
                                                            <hr/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(request()->job_title == 'eighty_leaves')
                                        <div class="card">
                                            <div class="card-header bg-white">
                                                <h5 class="card-title mb-0 text-muted">Edit Product</h5>
                                            </div>
                                            <div class="card-body h-100">
                                                <div class="align-items-start">
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-server"
                                                            role="tabpanel" aria-labelledby="nav-server-tab">

                                                            <form method="POST"  id="add_twenty_leaves" class="add_twenty_leaves" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Product Name</label>
                                                                        <select name="product_name" required class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }} form-select">
                                                                            <option value="eighty_leaves" <?php if ($product->name == request()->job_title) echo 'selected' ?>>Eighty Leaves</option>
                                                                            @error('product_name')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Upload Image <span class="text-warning">(Don't upload if you are not uploading a new image) </span>
                                                                            </label>
                                                                            <input  type="file" name="image" class="form-control"
                                                                            id="image">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="exampleFormControlSelect1">Default Ink

                                                                        </label>
                                                                        <select name="ink" required class="form-control form-select" id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Color Type--</option>
                                                                            <option value="single" <?php if ($product->ink == 'single') echo 'selected' ?>>Single Color</option>
                                                                            <option value="full" <?php if ($product->ink == 'full') echo 'selected' ?>>Full Color</option>
                                                                        </select>
                                                                    </div>


                                                                </div>


                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Production Time (Days)
                                                                            </label> <input required type="number" name="production_time" class="form-control"
                                                                            id="quantity" placeholder="eg: 4" value="{{$product->production_days}}">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="thickness">Default Cover Thickness</label>
                                                                        <select class="form-control form-select" required  name="thickness" id="thickness">
                                                                            <option value="">--Select Default Cover Thickness--</option>
                                                                            <option value="199g" <?php if ($product->thickness == '199g') echo 'selected' ?>>199g</option>
                                                                            <option value="280g" <?php if ($product->thickness == '280g') echo 'selected' ?>>280g</option>
                                                                            <option value="300g" <?php if ($product->thickness == '300g') echo 'selected' ?>>300g</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="paper_type">Default Paper Type </label>
                                                                        <select name="paper_type" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Paper Type--</option>
                                                                            <option value="50g" <?php if ($product->paper_type == '50g') echo 'selected' ?>>50g</option>
                                                                            <option value="60g" <?php if ($product->paper_type == '60g') echo 'selected' ?>>60g</option>
                                                                            <option value="70g" <?php if ($product->paper_type == '70g') echo 'selected' ?>>70g</option>
                                                                            <option value="80g" <?php if ($product->paper_type == '80g') echo 'selected' ?>>80g</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- <table id="products">

                                                                    <a id="add-product" class="btn btn-primary" >Add Pricing</a>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Quantity</th>
                                                                            <th>Price</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Initial row, can be hidden -->
                                                                        <tr class="product-row">
                                                                            <td style="width:50%"><input type="number" required class="form-control quantity"  name="quantity[]" /></td>
                                                                            <td style="width:50%"><input type="number" required class="form-control price"  name="total_cost[]" /></td>

                                                                            <td>
                                                                                <a class="remove-product btn btn-danger">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                                                    </svg>
                                                                                    </a>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table> --}}

                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-12">
                                                                        <label for="address">Product Description
                                                                            </label>
                                                                            <textarea name="description" required  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}"
                                                                            id="description">{{$product->description}}</textarea>
                                                                            @error('description')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                    </div>



                                                                </div>

                                                                <button class="btn btn-sm btn-danger" type="submit">
                                                                    <i class="text-white me-2" data-feather="check-circle"></i>Save
                                                                </button>
                                                            </form>
                                                            <hr/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(request()->job_title == 'forty_leaves')
                                        <div class="card">
                                            <div class="card-header bg-white">
                                                <h5 class="card-title mb-0 text-muted">Edit Product</h5>
                                            </div>
                                            <div class="card-body h-100">
                                                <div class="align-items-start">
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-server"
                                                            role="tabpanel" aria-labelledby="nav-server-tab">

                                                            <form method="POST"  id="add_twenty_leaves" class="add_twenty_leaves" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Product Name</label>
                                                                        <select name="product_name" required class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }} form-select">
                                                                            <option value="forty_leaves" <?php if ($product->name == request()->job_title) echo 'selected' ?>>Forty Leaves</option>
                                                                            @error('product_name')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Upload Image <span class="text-warning">(Don't upload if you are not uploading a new image) </span>
                                                                            </label>
                                                                            <input  type="file" name="image" class="form-control"
                                                                            id="image">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="exampleFormControlSelect1">Default Ink

                                                                        </label>
                                                                        <select name="ink" required class="form-control form-select" id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Color Type--</option>
                                                                            <option value="single" <?php if ($product->ink == 'single') echo 'selected' ?>>Single Color</option>
                                                                            <option value="full" <?php if ($product->ink == 'full') echo 'selected' ?>>Full Color</option>
                                                                        </select>
                                                                    </div>


                                                                </div>


                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Production Time (Days)
                                                                            </label> <input required type="number" name="production_time" class="form-control"
                                                                            id="quantity" placeholder="eg: 4" value="{{$product->production_days}}">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="thickness">Default Cover Thickness</label>
                                                                        <select class="form-control form-select" required  name="thickness" id="thickness">
                                                                            <option value="">--Select Default Cover Thickness--</option>
                                                                            <option value="199g" <?php if ($product->thickness == '199g') echo 'selected' ?>>199g</option>
                                                                            <option value="280g" <?php if ($product->thickness == '280g') echo 'selected' ?>>280g</option>
                                                                            <option value="300g" <?php if ($product->thickness == '300g') echo 'selected' ?>>300g</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="paper_type">Default Paper Type </label>
                                                                        <select name="paper_type" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Paper Type--</option>
                                                                            <option value="50g" <?php if ($product->paper_type == '50g') echo 'selected' ?>>50g</option>
                                                                            <option value="60g" <?php if ($product->paper_type == '60g') echo 'selected' ?>>60g</option>
                                                                            <option value="70g" <?php if ($product->paper_type == '70g') echo 'selected' ?>>70g</option>
                                                                            <option value="80g" <?php if ($product->paper_type == '80g') echo 'selected' ?>>80g</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- <table id="products">

                                                                    <a id="add-product" class="btn btn-primary" >Add Pricing</a>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Quantity</th>
                                                                            <th>Price</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Initial row, can be hidden -->
                                                                        <tr class="product-row">
                                                                            <td style="width:50%"><input type="number" required class="form-control quantity"  name="quantity[]" /></td>
                                                                            <td style="width:50%"><input type="number" required class="form-control price"  name="total_cost[]" /></td>

                                                                            <td>
                                                                                <a class="remove-product btn btn-danger">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                                                    </svg>
                                                                                    </a>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table> --}}

                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-12">
                                                                        <label for="address">Product Description
                                                                            </label>
                                                                            <textarea name="description" required  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}"
                                                                            id="description">{{$product->description}}</textarea>
                                                                            @error('description')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                    </div>



                                                                </div>

                                                                <button class="btn btn-sm btn-danger" type="submit">
                                                                    <i class="text-white me-2" data-feather="check-circle"></i>Save
                                                                </button>
                                                            </form>
                                                            <hr/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(request()->job_title == 'twenty_leaves')
                                        <div class="card">
                                            <div class="card-header bg-white">
                                                <h5 class="card-title mb-0 text-muted">Edit Product</h5>
                                            </div>
                                            <div class="card-body h-100">
                                                <div class="align-items-start">
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-server"
                                                            role="tabpanel" aria-labelledby="nav-server-tab">

                                                            <form method="POST"  id="add_twenty_leaves" class="add_twenty_leaves" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Product Name</label>
                                                                        <select name="product_name" required class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }} form-select">
                                                                            <option value="twenty_leaves" <?php if ($product->name == request()->job_title) echo 'selected' ?>>Twenty Leaves</option>
                                                                            @error('product_name')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Upload Image <span class="text-warning">(Don't upload if you are not uploading a new image) </span>
                                                                            </label>
                                                                            <input  type="file" name="image" class="form-control"
                                                                            id="image">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="exampleFormControlSelect1">Default Ink

                                                                        </label>
                                                                        <select name="ink" required class="form-control form-select" id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Color Type--</option>
                                                                            <option value="single" <?php if ($product->ink == 'single') echo 'selected' ?>>Single Color</option>
                                                                            <option value="full" <?php if ($product->ink == 'full') echo 'selected' ?>>Full Color</option>
                                                                        </select>
                                                                    </div>


                                                                </div>


                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="production_time">Production Time (Days)
                                                                            </label> <input required type="number" name="production_time" class="form-control"
                                                                            id="quantity" placeholder="eg: 4" value="{{$product->production_days}}">
                                                                    </div>

                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="thickness">Default Cover Thickness</label>
                                                                        <select class="form-control form-select" required  name="thickness" id="thickness">
                                                                            <option value="">--Select Default Cover Thickness--</option>
                                                                            <option value="199g" <?php if ($product->thickness == '199g') echo 'selected' ?>>199g</option>
                                                                            <option value="280g" <?php if ($product->thickness == '280g') echo 'selected' ?>>280g</option>
                                                                            <option value="300g" <?php if ($product->thickness == '300g') echo 'selected' ?>>300g</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mt-3 mb-3 col-md-4">
                                                                        <label for="paper_type">Default Paper Type </label>
                                                                        <select name="paper_type" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                            <option value="">--Select Default Paper Type--</option>
                                                                            <option value="50g" <?php if ($product->paper_type == '50g') echo 'selected' ?>>50g</option>
                                                                            <option value="60g" <?php if ($product->paper_type == '60g') echo 'selected' ?>>60g</option>
                                                                            <option value="70g" <?php if ($product->paper_type == '70g') echo 'selected' ?>>70g</option>
                                                                            <option value="80g" <?php if ($product->paper_type == '80g') echo 'selected' ?>>80g</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- <table id="products">

                                                                    <a id="add-product" class="btn btn-primary" >Add Pricing</a>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Quantity</th>
                                                                            <th>Price</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Initial row, can be hidden -->
                                                                        <tr class="product-row">
                                                                            <td style="width:50%"><input type="number" required class="form-control quantity"  name="quantity[]" /></td>
                                                                            <td style="width:50%"><input type="number" required class="form-control price"  name="total_cost[]" /></td>

                                                                            <td>
                                                                                <a class="remove-product btn btn-danger">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                                                    </svg>
                                                                                    </a>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table> --}}

                                                                <div class="row">
                                                                    <div class="form-group mt-3 mb-3 col-md-12">
                                                                        <label for="address">Product Description
                                                                            </label>
                                                                            <textarea name="description" required  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}"
                                                                            id="description">{{$product->description}}</textarea>
                                                                            @error('description')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                    </div>



                                                                </div>

                                                                <button class="btn btn-sm btn-danger" type="submit">
                                                                    <i class="text-white me-2" data-feather="check-circle"></i>Save
                                                                </button>
                                                            </form>
                                                            <hr/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
@endsection
