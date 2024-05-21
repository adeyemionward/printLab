@extends('layout.landing_master')
@section('content')
@section('title', 'Product Details')
<div class="hero-area section-bg2">
    <div class="container">
    <div class="row">
    <div class="col-xl-12">
    <div class="slider-area">
    <div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
    <div class="hero-caption hero-caption2">
    <h2>Product Details</h2>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-center">
    <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Product Details</a></li>
    </ol>
    </nav>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>


    <div class="services-area2 pt-50">
    <div class="container">
    <div class="row">
    <div class="col-xl-12">
    <div class="row">
    <div class="col-xl-12">
    <form method="POST">
        @csrf
        <div class="single-services d-flex align-items-center mb-0">
            <div class="features-img">

                @if ( env('APP_ENV') == 'local')
                    <img src="{{asset($product->image)}}" alt="product_image" style="width: 70%; height:450px">
                @else
                    <img src="{{asset($product->image)}}"  alt="product_image" style="width: 70%; height:450px">
                @endif




                <center style="color:#fff; font-size:24px; padding-top:16px;"><label for="">Select Other Specifications</label></center>
                @if(request()->title == 'video_brochure')
                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">
                            <label for="" style="color: #fff">Cover Paper</label>
                            <select class="form-control form-select"  name="cover_paper" id="cover_paper">
                                <option value="soft_cover" @php if($product->cover_paper == 'soft_cover') echo 'selected' @endphp>Soft Cover Paper</option>
                                <option value="hard_cover" @php if($product->cover_paper == 'hard_cover') echo 'selected' @endphp>Hard Cover Paper</option>
                            </select>
                        </div>

                        <div class="form-group mt-3 mb-3 col-md-4">
                            <label for="" style="color: #fff">Memory</label>
                            <select class="form-control form-select"  name="memory" id="memory">
                                {{-- <option value="">--Select Memory Information--</option> --}}
                                    @foreach ($video_profiling_memory as $val)
                                        <option value="{{$val->memory}}" @php if($val->memory == $product->memory) echo 'selected' @endphp>{{$val->memory}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">
                            <label for="" style="color: #fff">Color Type</label>
                            <select name="ink" class="form-control form-select"
                                id="ink">
                                <option value="single" @php if($product->ink == 'single') echo 'selected' @endphp>Single Color</option>
                                <option value="full" @php if($product->ink == 'full') echo 'selected' @endphp>Full Color</option>
                            </select>
                        </div>
                        <div class="form-group mt-3 mb-3 col-md-4">
                            <label for="" style="color: #fff">Paper Type</label>
                            <select name="paper_type" class="form-control form-select"  id="paper_type">
                                <option value="50g" @php if($product->paper_type == '50g') echo 'selected' @endphp>50g</option>
                                <option value="60g" @php if($product->paper_type == '60g') echo 'selected' @endphp>60g</option>
                                <option value="70g" @php if($product->paper_type == '70g') echo 'selected' @endphp>70g</option>
                                <option value="80g" @php if($product->paper_type == '80g') echo 'selected' @endphp>80g</option>
                            </select>
                        </div>
                        <div class="form-group mt-3 mb-3 col-md-4">
                            <label for="" style="color: #fff">Thickness</label>
                            <select class="form-control form-select"  name="thickness" id="thickness">
                                <option value="199g" @php if($product->thickness == '199g') echo 'selected' @endphp>199g</option>
                                <option value="280g" @php if($product->thickness == '280g') echo 'selected' @endphp>280g</option>
                                <option value="300g" @php if($product->thickness == '300g') echo 'selected' @endphp>300g</option>
                            </select>
                        </div>
                    </div>
                @endif



                <p style="color: #fff">NOTE: You will be contacted on delivery processes as soon as we receive your order</p>
            </div>
            @if (request()->title == 'higher_notebook')
                <div class="features-caption">
                    <h3>Higher Education NoteBook</h3>

                    <input type="hidden" value="Higher NoteBook" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>


                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_higher_education as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                    </div>


                </div>
            @endif

            @if (request()->title == 'eighty_leaves')
                <div class="features-caption">
                    <h3>Eighty Leaves</h3>

                    <input type="hidden" value="Eighty Leaves" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>


                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_eighty_leaves as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                    </div>


                </div>
            @endif

            @if (request()->title == 'forty_leaves')
                <div class="features-caption">
                    <h3>Forty Leaves</h3>
                    <input type="hidden" value="Forty Leaves" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>


                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_forty_leaves as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                    </div>


                </div>
            @endif

            @if (request()->title == 'twenty_leaves')
                <div class="features-caption">
                    <h3>Twenty Leaves</h3>
                    <input type="hidden" value="Twenty Leaves" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>

                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_twenty_leaves as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                </div>

                </div>
            @endif

            @if (request()->title == 'sixty_leaves')
                <div class="features-caption">
                    <h3>Sixty Leaves</h3>
                    <input type="hidden" value="Sixty Leaves" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>

                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_sixty_leaves as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                </div>

                </div>
            @endif

            @if (request()->title == '2A_notebook')
                <div class="features-caption">
                    <h3>2A NoteBook</h3>
                    <input type="hidden" value="2A NoteBook" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>

                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_2a_notebook as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                </div>

                </div>
            @endif

            @if (request()->title == '2B_notebook')
                <div class="features-caption">
                    <h3>2B NoteBook</h3>
                    <input type="hidden" value="2B NoteBook" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>

                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_2b_notebook as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                </div>

                </div>
            @endif

             @if (request()->title == '2D_notebook')
                <div class="features-caption">
                    <h3>2D NoteBook</h3>
                    <input type="hidden" value="2D NoteBook" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    {{ucfirst($product->ink).' Color'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->paper_type.' Paper'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->thickness.' Thickness'}}
                                </li>
                                <li style="list-style-type: square">
                                    {{$product->production_days.' Production Days' }}
                                </li>
                            </ul>
                        </span></p>
                    <div class="price">
                        <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                        <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                    </div>

                    <div class="row">
                        <div class="form-group mt-3 mb-3 col-md-4">

                            <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                @foreach ($product_costs_2d_notebook as $val)
                                    <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mt-3 mb-3 col-md-8">
                            <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                        </div>
                    </div>
                </div>

                </div>
            @endif


            @if (request()->title == 'video_brochure')
                <div class="features-caption">
                    <h3>{{$product->title}}</h3>
                    <input type="hidden" value="{{$product->title}}" id="product_name" name="product_name">
                    <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$product->description}}</span></p>
                    <p><b style="color: white; font-size:24px"> Specifications: </b>
                        <span>
                            <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                                <li style="list-style-type: square">
                                    Battery: {{ucfirst($product->battery)}}
                                </li>
                                <li style="list-style-type: square">
                                    Display Area: {{$product->display_area}}
                                </li>
                                <li style="list-style-type: square">
                                Screen Size:  {{$product->screen_size}}
                                </li>
                                <li style="list-style-type: square">
                                Resolution:  {{$product->resolution}}
                                </li>
                            </ul>
                        </span></p>
                        <div class="price">
                            <input type="hidden" value="{{$product_cost->total_cost}}" id="total_cost" name="total_cost">
                            <span id="price-container">&#8358;{{$product_cost->total_cost}}</span>
                        </div>

                        <div class="row">
                            <div class="form-group mt-3 mb-3 col-md-4">
                                <select name="quantity"  class="form-control form-select j-btn"  id="quantity">
                                    @foreach ($video_profiling_quantity as $val)
                                        <option value="{{$val->quantity}}">{{$val->quantity}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" mt-3 mb-3 col-md-8">
                                <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Add&nbsp;to&nbsp;Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </form>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>


        </main> <br><br><br>
@endsection
@section('scripts')


        @if(request()->title =='forty_leaves' || request()->title =='higher_notebook' || request()->title =='twenty_leaves' || request()->title =='eighty_leaves')
        <script>
        $('select').change(function() {

            var ink = $('#ink').val();
            var paper_type = $('#paper_type').val();
            var thickness = $('#thickness').val();
            var quantity = $('#quantity').val();
            var product_name = $('#product_name').val();
            var total_cost = $('#total_cost').val();
            // Collect values from other dropdowns as needed

            $.ajax({
                url: "{{route('get_price', [request()->title, request()->id])}}",
                type: "POST",
                data: {
                    ink: ink,
                    paper_type: paper_type,
                    thickness: thickness,
                    quantity: quantity,
                    product_name: product_name,
                    total_cost: total_cost,
                    // Add other specifications as needed
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.price);

                    $('#price-container').html('₦'+response.price);
                    $('#total_cost').val(response.price);
                    //alert(response.price);
                },
                error: function(error) {
                    console.error(error);
                    // Handle error gracefully, e.g., display an error message
                }
            });
        });
        </script>
        @endif


        @if(request()->title =='video_brochure')
        <script>
            $('select').change(function() {
                //alert();
                var quantity = $('#quantity').val();
                var memory = $('#memory').val();
                var cover_paper = $('#cover_paper').val();
                //alert(cover_paper);
                var total_cost = $('#total_cost').val();
                // Collect values from other dropdowns as needed

                $.ajax({
                    url: "{{route('get_video_profile_price',[request()->title, request()->id])}}",
                    type: "POST",
                    data: {

                        quantity: quantity,
                        memory: memory,
                        cover_paper: cover_paper,
                        total_cost: total_cost,
                        // Add other specifications as needed
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        //alert(response.price);

                        $('#price-container').html('₦'+response.price);
                        $('#total_cost').val(response.price);
                        //alert(response.price);
                    },
                    error: function(error) {
                        console.error(error);
                        // Handle error gracefully, e.g., display an error message
                    }
                });
            });
        </script>
        @endif

@endsection
