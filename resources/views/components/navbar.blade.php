<nav class="navbar navbar-expand-lg navbar-light header-height">
    <div class="container-fluid align-items-end">

        <div class="w-100">
            <div class="d-flex flex-column">
                <h4 class="d-inline fw-bold fs-3 mt-3 text-center text-md-start welcome-text">Welcome {{ \Auth::user()->surname }}!</h4>
                {{-- <form class="d-none d-md-flex w-auto p-1 shadow-lg me-5  bg-white" role="search">
                    <input class="form-control me-2 bg-white border-0 text-fs-5" type="search"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary w-25 text-fs-5" type="submit">Search</button>
                </form> --}}
            </div>
        </div>


        <button class="me-2 rounded-lg btn shadow-lg" id="btn-sidemenu">
            <svg width="24" height="20" viewBox="0 0 32 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="2.32422" y1="1.83032" x2="29.5094" y2="1.83032" stroke="#232323" stroke-width="3"
                    stroke-linecap="round" />
                <line x1="6.3877" y1="9.83032" x2="25.4461" y2="9.83032" stroke="#232323" stroke-width="3"
                    stroke-linecap="round" />
                <line x1="11.0312" y1="17.8303" x2="20.8019" y2="17.8303" stroke="#232323" stroke-width="3"
                    stroke-linecap="round" />
            </svg>
        </button>


        <button class="navbar-toggler rounded-lg btn shadow-lg me-2 border-0" type="button" id="search"
            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>


        <div class="dropdown">
            <button class="rounded-lg btn shadow-lg me-2" id="notification" data-bs-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </button>
            <ul class="dropdown-menu dropdown-menu-end bg-white" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">New Notification</a></li>
                <li><a class="dropdown-item" href="#">New Notification</a></li>
            </ul>
        </div>


        <div class="dropdown">
            <button id="profile_icon" class="btn dropdown-toggle rounded-circle" type="button"
                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('assets/profileImage.jpg') }}" class="w-100 rounded-circle" alt="user-image" />
            </button>
            <ul class="dropdown-menu dropdown-menu-end bg-white" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add-new-user-modal"
                        href="javascript:void(0);">Add New User</a></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf              
                </form>
            </ul>
        </div>

        <!-- Modal -->
        <div class="modal fade modal-lg" id="add-new-user-modal" tabindex="-1"
            aria-labelledby="add-new-user-modalLabel" aria-hidden="true">
            <div class="modal-dialog rounded-5">
                <div class="modal-content p-3">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fw-bold" id="add-new-user-modalLabel"
                            style="font-size: 28px">
                            Add a New User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('admin/system-configuration/users/add') }}" method="POST" class="user-form">
                            @csrf
                            <div class="row mt-4">

                                <div class="col-md-6 mb-4">
                                    <!-- username -->
                                    <div class="row">
                                        <label for="" class="col-md-4"> Username </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text  rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                                    </svg>
                                                </div>
                                                <input type="text" name="name" value="" class="py-2 form-control rounded-end-4" placeholder="John Sabestin" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Company -->
                                    <div class="row">
                                        <label for="" class="col-md-4"> Company </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text  rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                                    </svg>
                                                </div>
                                                <input type="text" name="company" class="py-2 form-control rounded-end-4" placeholder="Hn Sabestin" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Name -->
                                    <div class="row">
                                        <label for="" class="col-md-4"> Name </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text  rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                    </svg>
                                                </div>
                                                <input type="text" name="surname" class="py-2 form-control rounded-end-4" placeholder="Amazon" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Country -->
                                    <div class="row">
                                        <label for="" class="col-md-4"> Country </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                                                    </svg>
                                                </div>
                                                <div style="width: 84% !important;">
                                                    <select class="select3js form-select countries" id="countries" name="country" aria-label="Default select example" required>
                                                        @if(count(@$countries) > 0)
                                                        @foreach(@$countries as $key => $value)
                                                        <option value="{{ $value->nicename }}" data-code="{{ $value->phonecode }}">{{ $value->nicename }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Email -->
                                    <div class="row">
                                        <label for="" class="col-md-4"> Email </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text  rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                    </svg>
                                                </div>
                                                <input type="text" name="email" class="py-2 form-control rounded-end-4" placeholder="abc123@gmail.com" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Phone -->
                                    <div class="row">
                                        <label for="" class="col-md-4">
                                            <div class="row">
                                                <span class="col align-self-center">
                                                    Phone
                                                </span>
                                            </div>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text rounded-start-4" style="width: 20% !important; height: 40px !important;">
                                                    <input type="text" name="phone_code" class="phone_code" value="+93" readonly style=" border: none; outline: none;" />
                                                </div>
                                                <div class="input-group-text rounded-end-4" style="width: 80% !important; height: 40px !important;">
                                                    <input name="phone" type="text" id="phone" class="form-control rounded-end-4 border-0" placeholder="Enter Number" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <label for="" class="col-md-2">User Level</label>
                                        <div class="col-md-10">
                                            <div class="input-group shadow-lg rounded-4">
                                                <select class="form-select level" name="level_id">
                                                    @if(count(@$user_levels) > 0)
                                                    @foreach(@$user_levels as $key => $value)
                                                        <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Password -->
                                    <div class="row">
                                        <label for="" class="col-md-4"> Password </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text  rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                    </svg>
                                                </div>
                                                <input type="password" name="password" class="py-2 form-control rounded-end-4" placeholder="Password" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Repeat Password -->
                                    <div class="row">
                                        <label for="" class="col-md-4"> Repeat Password </label>
                                        <div class="col-md-8">
                                            <div class="input-group shadow-lg rounded-4">
                                                <div class="input-group-text  rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                    </svg>
                                                </div>
                                                <input type="password" name="cpassword" class="py-2 form-control rounded-end-4" placeholder="Password" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- button -->
                            <div class="d-flex justify-content-center mt-4">
                                <button class="btn btn-primary px-5" type="submit">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <div class="w-100 d-block d-md-none">
                        <form class="d-flex w-100 me-5 mt-4 shadow-lg p-1 bg-white" role="search">
                            <input class="form-control me-2 bg-white border-0" type="search"
                                placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>