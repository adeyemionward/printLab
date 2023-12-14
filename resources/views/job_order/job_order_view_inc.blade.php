<style>
    .active_red{
        background-color: #df4226 !important;
    }
</style>
<form method="POST"  action="{{route('job_order.view_order',[request()->job_title, request()->id])}}" class="order_status">
    @csrf
    @method('POST')
    <div class="modal fade" id="exampleModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Order Status</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <label for="backsided">Select a Status</label>
                        <select required class="form-control form-select"  name="order_status" id="order_status">
                            <option >--select a status--</option>
                            <option value="Designed">Designed</option>
                            <option value="Proof Read">Proof Read</option>
                            <option value="Customer Approved">Customer Approved</option>
                            <option value="Prepressed">Prepressed</option>
                            <option value="Printed">Printed</option>
                            <option value="Binded">Binded</option>
                            <option value="Completed">Completed</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-danger" type="submit">
                        <i class="text-white me-2" data-feather="check-circle"></i>Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="col-md-3 col-xl-3">
    <div class="card mb-3">
        <div class="card-body text-center">
            <!--<h5 class="card-title mb-3 text-primary">Select Entity</h5> -->

            <div class="nav nav-pills flex-column bg-white"
                id="nav-tab" role="tablist">
                <a class="nav-link <?php if($page == 'view_order') echo 'active active_red'  ?>"
                 href="{{route('job_order.view_order',[request()->job_title,request()->id])}}"
                 aria-selected="false">View Details</a>
                <div class="dropdown-divider"></div>

                <a  class="nav-link  <?php if($page == 'edit_order') echo 'active active_red'  ?>"
                 href="{{route('job_order.edit_order',[request()->job_title,request()->id])}}"
                 aria-selected="false">Edit Order</a>
                <div class="dropdown-divider"></div>


                <a style="cursor: pointer" id="myBtn1" data-bs-toggle="modal" data-bs-target="#exampleModal" class="nav-link <?php if($page == 'status_order') echo 'active active_red'  ?>"

                aria-selected="false">Change Order Status</a>

               <div class="dropdown-divider"></div>


               <a  class="nav-link  <?php if($page == 'track_order') echo 'active active_red'  ?>"
                href="{{route('job_order.track_order',[request()->job_title,request()->id])}}"
                aria-selected="false">Track Order</a>
               <div class="dropdown-divider"></div>

               <a  class="nav-link  <?php if($page == 'transaction') echo 'active active_red'  ?>"
                href="{{route('job_order.transaction_history',[request()->job_title,request()->id])}}"
                aria-selected="false">Order Transaction History</a>
               <div class="dropdown-divider"></div>

                <a class="nav-link <?php if($page == 'delete_order') echo 'active active_red'  ?>"
                    onclick="return confirm('Are you sure you want to delete this job order?');"  href="{{route('job_order.delete_order',[ request()->id])}}"
                aria-selected="false">Delete Order</a>
               <div class="dropdown-divider"></div>


            </div>

        </div>
    </div>
</div>
