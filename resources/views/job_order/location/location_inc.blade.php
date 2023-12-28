<style>
    .active_red{
        background-color: #df4226 !important;
    }
</style>
<div class="col-md-3 col-xl-3">
    <div class="card mb-3">
        <div class="card-body text-center">

            <div class="nav nav-pills flex-column bg-white"
                id="nav-tab" role="tablist">
                <a class="nav-link <?php if($page == 'add_location') echo 'active active_red'  ?>"
                 href="{{route('products.add_higher_education')}}"
                 aria-selected="false">Add Location</a>
                <div class="dropdown-divider"></div>

                <a class="nav-link <?php if($page == 'all_location') echo 'active active_red'  ?>"
                 href="{{route('products.add_twenty_leaves')}}"
                 aria-selected="false">View All Location </a>
                <div class="dropdown-divider"></div>



            </div>

        </div>
    </div>
</div>
