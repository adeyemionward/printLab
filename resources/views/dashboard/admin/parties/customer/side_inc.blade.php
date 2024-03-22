<style>
    .active_red{
        background-color: #df4226 !important;
    }
</style>
<div class="col-md-3 col-xl-3">
    <div class="card mb-3">
        <div class="card-body text-center">
            <!--<h5 class="card-title mb-3 text-primary">Select Entity</h5> -->

            <div class="nav nav-pills flex-column bg-white"
                id="nav-tab" role="tablist">
                <a class="nav-link <?php if($page == 'view') echo 'active active_red'  ?>"
                    href="{{route('dashboard.admin.parties.customer.view',request()->id)}}"
                    aria-selected="false">View Customer</a>
                   <div class="dropdown-divider"></div>

                <a class="nav-link <?php if($page == 'edit') echo 'active active_red'  ?>" id="nav-database-tab"
                href="{{route('dashboard.admin.parties.customer.view', request()->id)}}"
                aria-selected="false">Edit Customer </a>
               <div class="dropdown-divider"></div>

               <a class="nav-link <?php if($page == 'cart') echo 'active active_red'  ?>" id="nav-database-tab"
                href="{{route('dashboard.admin.parties.customer.view', request()->id)}}"
                aria-selected="false"> Customer Cart </a>
               <div class="dropdown-divider"></div>

               <a class="nav-link <?php if($page == 'transaction') echo 'active active_red'  ?>" id="nav-database-tab"
                href="{{route('dashboard.admin.parties.customer.view', request()->id)}}"
                aria-selected="false"> Customer Transaction History </a>
               <div class="dropdown-divider"></div>


                <a class="nav-link" id="nav-database-tab" onclick="return confirm('Are you sure you want to delete this customer?');"
                 href="{{route('dashboard.admin.parties.customer.view', request()->id)}}"
                 aria-selected="false">Deactivate Customer </a>
                <div class="dropdown-divider"></div>

            </div>

        </div>
    </div>
</div>
