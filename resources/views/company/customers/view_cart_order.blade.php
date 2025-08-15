
@extends('company.layout.master')
@section('content')
@section('title', 'Customer Job Orders')
@php $page = 'cart'; @endphp
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Job Orders for {{$customer->firstname.' '.$customer->lastname}} </h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Customer Job Order</a></li>
                        <li class="breadcrumb-item active">All Orders</li>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('company.customers.side_inc')
                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">View Cart Job Order</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 ">
                                                            <div class="col-md-12">
                                                                <table width="100%"  class="details">
                                                                    <tr class="det">
                                                                      <td width="10%" class="question">Job Id :</td>
                                                                      <td>{{$job_order->id ?? 'N/A'}}</td>
                                                                    </tr>
                                                                  
                                                                    <tr>
                                                                        <td width="10%" class="question">Created By :</td>
                                                                        <td>{{@$job_order->createdBy->firstname.' '.@$job_order->createdBy->lastname ?? 'N/A'}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td width="10%" class="question">Created At :</td>
                                                                        <td>{{$job_order->created_at ?? 'N/A'}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td width="10%" class="question">Updated By :</td>
                                                                        <td>{{@$job_order->updatedBy->firstname.' '.@$job_order->updatedBy->lastname ?? 'N/A'}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td width="10%" class="question">Updated At :</td>
                                                                        <td>{{$job_order->updated_at ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Customer Name :</td>
                                                                       <td> <a style="text-decoration:underline; color:blue" href="{{route('company.customers.view_customer',$job_order->user_id)}}">{{$job_order->user->firstname.' '.$job_order->user->lastname ?? 'N/A'}}</a></td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Job Order Type :</td>
                                                                        <td>{{$job_order->job_order_name ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Quantity :</td>
                                                                        <td>{{$job_order->quantity ?? 'N/A'}}</td>
                                                                    </tr>



                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Total Cost :</td>
                                                                        <td>&#8358;{{number_format($job_order->total_cost) ?? 'N/A'}}</td>
                                                                    </tr>

                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Production Days :</td>
                                                                        <td>{{$job_order->production_days ?? 'N/A'}}</td>
                                                                    </tr class="det">

                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Ink :</td>
                                                                        <td>{{$job_order->ink ?? 'N/A'}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td width="10%" class="question">Status :</td>
                                                                        <td>{{$job_order->status ?? 'N/A'}}</td>
                                                                    </tr>



                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Paper Type :</td>
                                                                        <td>{{$job_order->paper_type ?? 'N/A'}}</td>
                                                                    </tr>

                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Bleed :</td>
                                                                        <td>{{$job_order->bleed ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Page Count :</td>
                                                                        <td>{{$job_order->page_count ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Folding :</td>
                                                                        <td>{{$job_order->folding ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Shrink Wrap :</td>
                                                                        <td>{{$job_order->shrink_wrap ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Back Sided Print :</td>
                                                                        <td>{{$job_order->back_sided_print ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Proof Needed :</td>
                                                                        <td>{{$job_order->proof_needed ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Hole Drilling :</td>
                                                                        <td>{{$job_order->hole_drilling ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Perforating :</td>
                                                                        <td>{{$job_order->perforating ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Edge to Glue :</td>
                                                                        <td>{{$job_order->edge_to_glue ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Binding :</td>
                                                                        <td>{{$job_order->binding ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Binding Edge :</td>
                                                                        <td>{{$job_order->binding_edge ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Cut to Size :</td>
                                                                        <td>{{$job_order->cut_to_size ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Books with Cover :</td>
                                                                        <td>{{$job_order->books_with_covers ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Numbering Needed :</td>
                                                                        <td>{{$job_order->numbering_needed ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Start Number :</td>
                                                                        <td>{{$job_order->start_number ?? 'N/A'}}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr/>
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

                <!-- 							Canvas Wrapper End -->

            </div>
        </div>

    </div>
@endsection

