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
                <a class="nav-link <?php if($page == 'list') echo 'active active_red'  ?>"
                    href="{{route('admin.company.list',request()->id)}}"
                    aria-selected="false">List All Companies</a>
                   <div class="dropdown-divider"></div>

                <a class="nav-link <?php if($page == 'view') echo 'active active_red'  ?>"
                    href="{{route('admin.company.view',request()->id)}}"
                    aria-selected="false">View Company</a>
                   <div class="dropdown-divider"></div>

                <a class="nav-link <?php if($page == 'edit') echo 'active active_red'  ?>" id="nav-database-tab"
                href="{{route('admin.company.edit', request()->id)}}"
                aria-selected="false">Edit Company </a>
               <div class="dropdown-divider"></div>

                <a class="nav-link" id="nav-database-tab" onclick="return confirm('Are you sure you want to deactivate this company?');"
                 href="{{route('admin.company.delete', request()->id)}}"
                 aria-selected="false">Deactivate Company </a>
                <div class="dropdown-divider"></div>

            </div>

        </div>
    </div>
</div>
