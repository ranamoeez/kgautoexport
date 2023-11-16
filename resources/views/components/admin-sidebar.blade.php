<style type="text/css">
    .side_menu a {
        padding: 15px 10px !important;
    }
</style>

<div class="header-height d-flex">

    <a class="navbar-brand m-auto me-md-5" href="{{ url('/admin') }}">
        <img src="{{ asset('assets/symbol_logo.jpeg') }}" style="" alt="Logo" />
    </a>
</div>
<nav class="bg-primary sticky below-header-height side_menu">
    <ul class="list-unstyled" style="padding-top: 0px !important;">
        <li class="side_menu_item">
            <a href="javascript:void();" class="toggle-btn">
                <i class="fas fa-bars" style="margin-left: 6px;"></i>
            </a>
        </li>
        @if(empty($auth_user->admin_level->access) || @in_array("2", json_decode($auth_user->admin_level->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/vehicles') }}" @if(@$type == 'vehicles') class="active" @endif>
                <i class="fas fa-car" style="margin-left: 6px; margin-right: 15px;"></i>
                <span>Vehicles List</span>
            </a>
        </li>
        @endif
        <li class="side_menu_item">
            <a href="{{ url('admin/vehicles/add') }}" @if(@$type == 'add-vehicle') class="active" @endif>
                <i class="fas fa-plus" style="font-size: 14px; margin-right: 3px; margin-top: 5px;"></i>
                <i class="fas fa-car"></i>
                <span>Add New Vehicle</span>
            </a>
        </li>
        @if(empty($auth_user->admin_level->access) || @in_array("3", json_decode($auth_user->admin_level->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/containers') }}" @if(@$type == 'containers') class="active" @endif>
                <i class="fas fa-box" style="margin-left: 7px; margin-right: 16px;"></i>
                <span>Container List</span>
            </a>
        </li>
        @endif
        @if(empty($auth_user->admin_level->access) || @in_array("4", json_decode($auth_user->admin_level->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/containers/add') }}" @if(@$type == 'add-container') class="active" @endif>
                <i class="fas fa-plus" style="font-size: 14px; margin-right: 3px; margin-top: 5px;"></i>
                <i class="fas fa-box"></i>
                <span>Add new container</span>
            </a>
        </li>
        @endif
        @if(empty($auth_user->admin_level->access) || @in_array("5.1", json_decode($auth_user->admin_level->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/financial-system') }}" @if(@$type == 'financial-system') class="active" @endif>
                <i class="fas fa-money-bill" style="margin-left: 6px; margin-right: 15px;"></i>
                <span>Financial System</span>
            </a>
        </li>
        @endif
        @if(empty($auth_user->admin_level->access) || @in_array("6.1", json_decode($auth_user->admin_level->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/pickup-history') }}" @if(@$type == 'pickup-history') class="active" @endif>
                <i class="fa-solid fa-list" style="margin-left: 6px; margin-right: 15px;"></i>
                <span>Pickup History</span>
            </a>
        </li>
        @endif
        @if(empty($auth_user->admin_level->access) || @in_array("7", json_decode($auth_user->admin_level->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/system-configuration/users') }}" @if(@$type == 'system-configuration') class="active" @endif>
                <i class="fas fa-chart-bar" style="margin-left: 6px; margin-right: 15px;"></i>
                <span>System Configuration</span>
            </a>
        </li>
        @endif
    </ul>
</nav>