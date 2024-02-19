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
                <a class="nav-link <?php if($page == 'view') echo 'active active_red'  ?>"
                    href="{{route('company.users.view_user', request()->id)}}"
                    aria-selected="false">View User</a>
                   <div class="dropdown-divider"></div>

                <a class="nav-link <?php if($page == 'edit') echo 'active active_red'  ?>" id="nav-database-tab"
                    href="{{route('company.users.edit_user', request()->id)}}"
                    aria-selected="false">Edit User </a>
                <div class="dropdown-divider"></div>

                <a class="nav-link" id="nav-database-tab" onclick="return confirm('Are you sure you want to delete this user?');"
                    href="{{route('company.users.delete_user', request()->id)}}"
                    aria-selected="false">Delete User </a>
                <div class="dropdown-divider"></div>

            </div>
        </div>
    </div>
</div>
