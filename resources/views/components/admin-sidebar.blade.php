<div class="header-height d-flex">

    <a class="navbar-brand m-auto me-md-5" href="{{ url('/admin') }}">
        <img src="{{ asset('assets/symble_logo.png') }}" style="" alt="Logo" />
    </a>
</div>
<nav class="bg-primary sticky below-header-height side_menu">
    <ul class="list-unstyled">

        @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("1", json_decode(\Auth::user()->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/vehicles') }}" @if(@$type == 'vehicles') class="active" @endif>
                <i class="fas fa-car"></i>
                <span>Vehicles List</span>
            </a>
        </li>
        @endif
        @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("1.1", json_decode(\Auth::user()->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/vehicles/add') }}" @if(@$type == 'add-vehicle') class="active" @endif>
                <i class="fas fa-car"></i>
                <span>Add New Vehicle</span>
            </a>
        </li>
        @endif
        @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2", json_decode(\Auth::user()->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/containers') }}" @if(@$type == 'containers') class="active" @endif>
                <i class="fas fa-box"></i>
                <span>Container List</span>
            </a>
        </li>
        @endif
        @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.1", json_decode(\Auth::user()->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/containers/add') }}" @if(@$type == 'add-container') class="active" @endif>
                <i class="fas fa-box"></i>
                <span>Add new container</span>
            </a>
        </li>
        @endif
        @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("3", json_decode(\Auth::user()->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/financial-system') }}" @if(@$type == 'financial-system') class="active" @endif>
                <i class="fas fa-money-bill"></i>
                <span>Financial System</span>
            </a>
        </li>
        @endif
        @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("4", json_decode(\Auth::user()->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/pickup-history') }}" @if(@$type == 'pickup-history') class="active" @endif>
                <i class="fa-solid fa-list"></i>
                <span>Pickup History</span>
            </a>
        </li>
        @endif
        @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("5", json_decode(\Auth::user()->access)))
        <li class="side_menu_item">
            <a href="{{ url('admin/system-configuration/users') }}" @if(@$type == 'system-configuration') class="active" @endif>
                <i class="fas fa-chart-bar"></i>
                <span>System Configuration</span>
            </a>
        </li>
        @endif
    </ul>
</nav>