<div class="header-height d-flex">

    <a class="navbar-brand m-auto me-md-5" href="{{ url('/user') }}">
        <img src="{{ asset('assets/symble_logo.png') }}" style="" alt="Logo" />
    </a>
</div>
<nav class="bg-primary sticky below-header-height side_menu">
    <ul class="list-unstyled" style="padding-top: 0px !important;">
        <li class="side_menu_item">
            <a href="javascript:void();" class="toggle-btn">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="side_menu_item">
            <a href="{{ url('/user') }}" @if(@$type == 'homepage') class="active" @endif>
                <i class="fas fa-home"></i>
                <span>Home Page</span>
            </a>
        </li>
        <li class="side_menu_item">
            <a href="{{ url('user/vehicles') }}" @if(@$type == 'vehicles') class="active" @endif>
                <i class="fas fa-car"></i>
                <span>My Vehicles</span>
            </a>
        </li>
        <li class="side_menu_item">
            <a href="{{ url('user/containers') }}" @if(@$type == 'containers') class="active" @endif>
                <i class="fas fa-box"></i>
                <span style="margin-left: 5px;">My Containers</span>
            </a>
        </li>
        @if(\Auth::user()->role == "2")
        <li class="side_menu_item">
            <a href="{{ url('user/financial') }}" @if(@$type == 'financial') class="active" @endif>
                <i class="fas fa-money-bill"></i>
                <span>Financial</span>
            </a>
        </li>
        @endif
    </ul>
</nav>