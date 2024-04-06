@extends('layout.landing_master')
@section('content')
@section('title', 'Video Profiling Product Details')
<div class="hero-area section-bg2">
    <div class="container">
    <div class="row">
    <div class="col-xl-12">
    <div class="slider-area">
    <div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
    <div class="hero-caption hero-caption2">
    <h2>Video Profiling Product Details</h2>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-center">
    <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Video Profiling Product Details</a></li>
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
                    <img src="{{asset('storage/images/'.$video_profiling->image)}}" alt="product_image" style="width: 100%">
                @else
                    <img src="{{asset('public/storage/images/'.$video_profiling->image)}}"  alt="product_image" style="width: 100%">
                @endif

                <center style="color:#fff; font-size:24px; padding-top:16px;"><label for="">Select Other Specifications</label></center>
                <div class="row">
                    <div class="form-group mt-3 mb-3 col-md-4">
                        <label for="" style="color: #fff">Cover Paper</label>
                        <select class="form-control form-select"  name="cover_paper" id="cover_paper">
                            <option value="soft_cover" @php if($video_profiling->cover_paper == 'soft_cover') echo 'selected' @endphp>Soft Cover Paper</option>
                            <option value="hard_cover" @php if($video_profiling->cover_paper == 'hard_cover') echo 'selected' @endphp>Hard Cover Paper</option>
                        </select>
                    </div>
                </div>
                <p style="color: #fff">NOTE: You will be contacted on delivery processes as soon as we receive your order</p>
            </div>


            <div class="features-caption">
                <h3>Higher Education NoteBook</h3>

                <input type="hidden" value="Higher NoteBook" id="product_name" name="product_name">
                <p><b style="color: white; font-size:24px"> Description: </b> <span style="font-size:21px">{{$video_profiling->description}}</span></p>
                <p><b style="color: white; font-size:24px"> Specifications: </b>
                    <span>
                        <ul style="color: #fff;font-size:21px; margin-top:-22px; margin-left:20px">
                            <li style="list-style-type: square">
                                Battery: {{ucfirst($video_profiling->battery)}}
                            </li>
                            <li style="list-style-type: square">
                                Display Area: {{$video_profiling->display_area}}
                            </li>
                            <li style="list-style-type: square">
                               Screen Size:  {{$video_profiling->screen_size}}
                            </li>
                            <li style="list-style-type: square">
                               Resolution:  {{$video_profiling->resolution}}
                            </li>
                            <li style="list-style-type: square">
                               Memory: {{$video_profiling->memory}}
                            </li>
                            <li style="list-style-type: square">
                                {{$video_profiling->production_days.' Production Days' }}
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
                            @foreach ($video_profiling_pricing as $val)
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

<script>
    $(document).ready(function() {
        $('#quantity').change(function() {
            ///alert();
            var quantity = $('#quantity').val();
            var total_cost = $('#total_cost').val();
            // Collect values from other dropdowns as needed

            $.ajax({
                url: "{{route('get_video_profile_price')}}",
                type: "POST",
                data: {

                    quantity: quantity,
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
    });
</script>
@endsection
