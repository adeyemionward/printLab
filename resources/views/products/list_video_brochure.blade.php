
@extends('layout.master')
@section('content')
@section('title', 'All Products')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Video Profiles</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Products</a></li>
                        <li class="breadcrumb-item active">All Video Profiles</li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="content" id="tableContent">

                    <div class="canvas-wrapper">
                        @include('includes.date_range')
                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product Name</th>
                                    <th>Cover Paper</th>
                                    <th>Battery</th>
                                    <th>Production Days</th>
                                    <th>Screen Size</th>
                                    <th>Display Area</th>
                                    <th>Resolution</th>
                                    <th>Memory</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_video_profiling as $index => $val)
                                @php $product_name = str_replace(' ','_', $val->name)   @endphp
                                @php $product_name1 = str_replace('_',' ', $val->name)   @endphp
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$product_name1}}</td>
                                        <td>{{$val->cover_paper}}</td>
                                        <td>{{$val->battery}}</td>
                                        <td>{{$val->production_days}}</td>
                                        <td>{{$val->screen_size}} </td>
                                        <td>{{$val->display_area}} </td>
                                        <td>{{$val->resolution}} </td>
                                        <td>{{$val->memory}} </td>
                                        <td><a href="{{route('products.edit_video_profile',$val->id)}}"><span><i class="fa fa-eye"></i></span></a></td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

