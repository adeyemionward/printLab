
@extends('layout.master')
@section('content')
@section('title', 'All Products')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Products</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Products</a></li>
                        <li class="breadcrumb-item active">All Products</li>
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
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Ink</th>
                                    <th>Paper Type</th>
                                    <th>Production Days</th>
                                    <th>Proof Needed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $val)
                                @php $product_name = str_replace(' ','_', $val->name)   @endphp
                                @php $product_name1 = str_replace('_',' ', $val->name)   @endphp
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$product_name1}}</td>

                                        <td>{{$val->description}} </td>
                                        <td>{{$val->ink}}</td>
                                        <td>{{$val->paper_type}}</td>
                                        <td>{{$val->production_days}}</td>
                                        <td>{{$val->proof_needed}} </td>
                                        <td><a href="{{route('products.view',[$product_name, $val->id])}}"><span><i class="fa fa-eye"></i></span></a></td>
                                    </tr>
                                @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

