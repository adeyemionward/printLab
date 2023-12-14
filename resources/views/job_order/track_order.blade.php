
@extends('layout.master')
@section('content')
@section('title', 'Track Order')
@php $page = 'track_order' @endphp
<style>
    .question{
        color:red;
        font-weight: bold;
        width: 20% !important;
    }
    th, td {
        padding: 5px;
    }

    .track_title{
        color: green;
        font-size:16px;
        font-weight:bold
    }
    .track_title_no{
        color: gray;
        font-size:16px;
        font-weight:bold
    }

</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Job Order</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Job Order</li>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('job_order.job_order_view_inc')

                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">Track Job Order</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="row">

                                                    <div class="col-md-2">
                                                        @if ($job_order_track->pending_status != null)
                                                            <span class="track_title">Created</span>
                                                            <p>{{$job_order_track->pending_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Created</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        @if ($job_order_track->designed_status != null)
                                                            <span class="track_title"> Designed</span>
                                                            <p>{{$job_order_track->designed_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Designed</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        @if ($job_order_track->proof_read_status != null)
                                                            <span class="track_title">Proof Read</span>
                                                            <p>{{$job_order_track->proof_read_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Proof Read</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        @if ($job_order_track->customer_approved_status != null)
                                                            <span class="track_title">Customer Approved</span>
                                                            <p>{{$job_order_track->customer_approved_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Customer Approved</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        @if ($job_order_track->prepressed_status != null)
                                                            <span class="track_title">Prepressed</span>
                                                            <p>{{$job_order_track->prepressed_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Prepressed</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        @if ($job_order_track->printed_status != null)
                                                            <span class="track_title">Printed</span>
                                                            <p>{{$job_order_track->printed_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Printed</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if ($job_order_track->binded_status != null)
                                                            <span class="track_title">Binded</span>
                                                            <p>{{$job_order_track->binded_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Binded</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if ($job_order_track->completed_status != null)
                                                            <span class="track_title">Completed</span>
                                                            <p>{{$job_order_track->completed_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Completed</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if ($job_order_track->delivered_status != null)
                                                        <span class="track_title">Delivered</span>
                                                        <p>{{$job_order_track->delivered_date}}</p>
                                                        @else
                                                            <span class="track_title_no">Delivered</span>
                                                            <p>None</p>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
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
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Customer Name :</td>
                                                                        <td>{{$job_order->customer->firstname.' '.$job_order->customer->lastname ?? 'N/A'}}</td>
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
                                                                        <td width="10%" class="question">Ink :</td>
                                                                        <td>{{$job_order->ink ?? 'N/A'}}</td>
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
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Total Cost :</td>
                                                                        <td>{{$job_order->total_cost ?? 'N/A'}}</td>
                                                                    </tr>

                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Production Days :</td>
                                                                        <td>{{$job_order->production_days ?? 'N/A'}}</td>
                                                                    </tr class="det">

                                                                    <tr>
                                                                        <td width="10%" class="question">Status :</td>
                                                                        <td>{{$job_order->status ?? 'N/A'}}</td>
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
            </div>

        </div>

    </div>
@endsection
