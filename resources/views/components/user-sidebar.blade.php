<style type="text/css">
    .side_menu a {
        padding: 15px 10px !important;
    }
</style>

<div class="header-height d-flex">

    <a class="navbar-brand m-auto me-md-5" href="{{ url('/user') }}">
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
        <li class="side_menu_item">
            <a href="{{ url('/user') }}" @if(@$type == 'homepage') class="active" @endif>
                <i class="fas fa-home" style="margin-left: 4px; margin-right: 15px;"></i>
                <span>Home Page</span>
            </a>
        </li>
        <li class="side_menu_item">
            <a href="{{ url('user/vehicles') }}" @if(@$type == 'vehicles') class="active" @endif>
                <img src="{{ asset('assets/car.png') }}" style="margin-left: 4px; margin-right: 15px; width: 30px; height: 30px;"></i>
                {{-- <i class="fas fa-car"></i> --}}
                <span>My Vehicles</span>
            </a>
        </li>
        <li class="side_menu_item">
            <a href="{{ url('user/containers') }}" @if(@$type == 'containers') class="active" @endif>
                <img src="{{ asset('assets/container.png') }}" style="margin-left: 2px; margin-right: 15px; width: 33px; height: 30px;"></i>
                {{-- <i class="fas fa-box"></i> --}}
                <span>My Containers</span>
            </a>
        </li>
        @if(\Auth::user()->role == "2")
        <li class="side_menu_item">
            <a href="{{ url('user/financial') }}" @if(@$type == 'financial') class="active" @endif>
                <i class="fas fa-money-bill" style="margin-left: 4px; margin-right: 15px;"></i>
                <span>Financial</span>
            </a>
        </li>
        @endif
    </ul>
</nav>