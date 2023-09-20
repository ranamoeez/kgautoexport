<nav class="navbar navbar-expand-lg navbar-light header-height">
    <div class="container-fluid align-items-end">

        <div class="w-100">
            <div class="d-flex flex-column">
                <h4 class="d-inline fw-bold fs-3 mt-3 text-center text-md-start">Welcome {{ \Auth::user()->surname }}!</h4>
                <form class="d-none d-md-flex w-auto p-1 shadow-lg me-5  bg-white" role="search">
                    <input class="form-control me-2 bg-white border-0 text-fs-5" type="search"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary w-25 text-fs-5" type="submit">Search</button>
                </form>
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
                        href="javascript:void(0);">Add New Sub-user</a></li>
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
                        <form action="{{ url('user/users/add') }}" method="POST" class="form">
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
                                                <div class="input-group-text  rounded-start-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#194AF9" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                                                    </svg>
                                                </div>
                                                <select class="form-select countries" id="countries"
                                                    name="country" aria-label="Default select example"
                                                    required>

                                                </select>
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
                                                <div class="input-group-text  rounded-start-4">
                                                    <input type="hidden" name="dial_code" id="top_dial_code" value="">
                                                    <input name="phone" type="text" id="phone" class="py-2 form-control rounded-end-4 border-0" placeholder="Enter Number" required />
                                                </div>
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

                        <script>




                            //Phone format





                            /*
                            Object of countries based on
                            http://en.wikipedia.org/wiki/List_of_IOC_country_codes
                            */
                            function countriesDropdown(container) {
                                var countries = {
                                    IRQ: "Iraq",
                                    JOR: "Jordan",
                                    UAE: "United Arab Emirates",
                                    AFG: "Afghanistan",
                                    ALB: "Albania",
                                    ALG: "Algeria",
                                    AND: "Andorra",
                                    ANG: "Angola",
                                    ANT: "Antigua and Barbuda",
                                    ARG: "Argentina",
                                    ARM: "Armenia",
                                    ARU: "Aruba",
                                    ASA: "American Samoa",
                                    AUS: "Australia",
                                    AUT: "Austria",
                                    AZE: "Azerbaijan",
                                    BAH: "Bahamas",
                                    BAN: "Bangladesh",
                                    BAR: "Barbados",
                                    BDI: "Burundi",
                                    BEL: "Belgium",
                                    BEN: "Benin",
                                    BER: "Bermuda",
                                    BHU: "Bhutan",
                                    BIH: "Bosnia and Herzegovina",
                                    BIZ: "Belize",
                                    BLR: "Belarus",
                                    BOL: "Bolivia",
                                    BOT: "Botswana",
                                    BRA: "Brazil",
                                    BRN: "Bahrain",
                                    BRU: "Brunei",
                                    BUL: "Bulgaria",
                                    BUR: "Burkina Faso",
                                    CAF: "Central African Republic",
                                    CAM: "Cambodia",
                                    CAN: "Canada",
                                    CAY: "Cayman Islands",
                                    CGO: "Congo",
                                    CHA: "Chad",
                                    CHI: "Chile",
                                    CHN: "China",
                                    CIV: "Cote d'Ivoire",
                                    CMR: "Cameroon",
                                    COD: "DR Congo",
                                    COK: "Cook Islands",
                                    COL: "Colombia",
                                    COM: "Comoros",
                                    CPV: "Cape Verde",
                                    CRC: "Costa Rica",
                                    CRO: "Croatia",
                                    CUB: "Cuba",
                                    CYP: "Cyprus",
                                    CZE: "Czech Republic",
                                    DEN: "Denmark",
                                    DJI: "Djibouti",
                                    DMA: "Dominica",
                                    DOM: "Dominican Republic",
                                    ECU: "Ecuador",
                                    EGY: "Egypt",
                                    ERI: "Eritrea",
                                    ESA: "El Salvador",
                                    ESP: "Spain",
                                    EST: "Estonia",
                                    ETH: "Ethiopia",
                                    FIJ: "Fiji",
                                    FIN: "Finland",
                                    FRA: "France",
                                    FSM: "Micronesia",
                                    GAB: "Gabon",
                                    GAM: "Gambia",
                                    GBR: "Great Britain",
                                    GBS: "Guinea-Bissau",
                                    GEO: "Georgia",
                                    GEQ: "Equatorial Guinea",
                                    GER: "Germany",
                                    GHA: "Ghana",
                                    GRE: "Greece",
                                    GRN: "Grenada",
                                    GUA: "Guatemala",
                                    GUI: "Guinea",
                                    GUM: "Guam",
                                    GUY: "Guyana",
                                    HAI: "Haiti",
                                    HKG: "Hong Kong",
                                    HON: "Honduras",
                                    HUN: "Hungary",
                                    INA: "Indonesia",
                                    IND: "India",
                                    IRI: "Iran",
                                    IRL: "Ireland",
                                    ISL: "Iceland",
                                    ISR: "Israel",
                                    ISV: "Virgin Islands",
                                    ITA: "Italy",
                                    IVB: "British Virgin Islands",
                                    JAM: "Jamaica",
                                    JPN: "Japan",
                                    KAZ: "Kazakhstan",
                                    KEN: "Kenya",
                                    KGZ: "Kyrgyzstan",
                                    KIR: "Kiribati",
                                    KOR: "South Korea",
                                    KOS: "Kosovo",
                                    KSA: "Saudi Arabia",
                                    KUW: "Kuwait",
                                    LAO: "Laos",
                                    LAT: "Latvia",
                                    LBA: "Libya",
                                    LBR: "Liberia",
                                    LCA: "Saint Lucia",
                                    LES: "Lesotho",
                                    LIB: "Lebanon",
                                    LIE: "Liechtenstein",
                                    LTU: "Lithuania",
                                    LUX: "Luxembourg",
                                    MAD: "Madagascar",
                                    MAR: "Morocco",
                                    MAS: "Malaysia",
                                    MAW: "Malawi",
                                    MDA: "Moldova",
                                    MDV: "Maldives",
                                    MEX: "Mexico",
                                    MGL: "Mongolia",
                                    MHL: "Marshall Islands",
                                    MKD: "Macedonia",
                                    MLI: "Mali",
                                    MLT: "Malta",
                                    MNE: "Montenegro",
                                    MON: "Monaco",
                                    MOZ: "Mozambique",
                                    MRI: "Mauritius",
                                    MTN: "Mauritania",
                                    MYA: "Myanmar",
                                    NAM: "Namibia",
                                    NCA: "Nicaragua",
                                    NED: "Netherlands",
                                    NEP: "Nepal",
                                    NGR: "Nigeria",
                                    NIG: "Niger",
                                    NOR: "Norway",
                                    NRU: "Nauru",
                                    NZL: "New Zealand",
                                    OMA: "Oman",
                                    PAK: "Pakistan",
                                    PAN: "Panama",
                                    PAR: "Paraguay",
                                    PER: "Peru",
                                    PHI: "Philippines",
                                    PLE: "Palestine",
                                    PLW: "Palau",
                                    PNG: "Papua New Guinea",
                                    POL: "Poland",
                                    POR: "Portugal",
                                    PRK: "North Korea",
                                    PUR: "Puerto Rico",
                                    QAT: "Qatar",
                                    ROU: "Romania",
                                    RSA: "South Africa",
                                    RUS: "Russia",
                                    RWA: "Rwanda",
                                    SAM: "Samoa",
                                    SEN: "Senegal",
                                    SEY: "Seychelles",
                                    SIN: "Singapore",
                                    SKN: "Saint Kitts and Nevis",
                                    SLE: "Sierra Leone",
                                    SLO: "Slovenia",
                                    SMR: "San Marino",
                                    SOL: "Solomon Islands",
                                    SOM: "Somalia",
                                    SRB: "Serbia",
                                    SRI: "Sri Lanka",
                                    SSD: "South Sudan",
                                    STP: "Sao Tome and Principe",
                                    SUD: "Sudan",
                                    SUI: "Switzerland",
                                    SUR: "Suriname",
                                    SVK: "Slovakia",
                                    SWE: "Sweden",
                                    SWZ: "Swaziland",
                                    SYR: "Syria",
                                    TAN: "Tanzania",
                                    TGA: "Tonga",
                                    THA: "Thailand",
                                    TJK: "Tajikistan",
                                    TKM: "Turkmenistan",
                                    TLS: "Timor-Leste",
                                    TOG: "Togo",
                                    TPE: "Chinese Taipei",
                                    TTO: "Trinidad and Tobago",
                                    TUN: "Tunisia",
                                    TUR: "Turkey",
                                    TUV: "Tuvalu",
                                    UGA: "Uganda",
                                    UKR: "Ukraine",
                                    URU: "Uruguay",
                                    USA: "United States",
                                    UZB: "Uzbekistan",
                                    VAN: "Vanuatu",
                                    VEN: "Venezuela",
                                    VIE: "Vietnam",
                                    VIN: "Saint Vincent and the Grenadines",
                                    YEM: "Yemen",
                                    ZAM: "Zambia",
                                    ZAN: "Zanzibar",
                                    ZIM: "Zimbabwe"
                                }
                                var out = "<select><option rel=''>Country</option>";
                                for (var key in countries) {
                                    out += "<option rel='" + key + "'>" + countries[key] + "</option>";
                                }
                                out += "</select>";

                                document.getElementById(container).innerHTML = out;
                            }
                            countriesDropdown("countries");

                            pincodeDropdown("pincode");

                            $("#myForm").validate({
                                errorLabelContainer: "#messageBox",
                                wrapper: "li",
                                submitHandler: function () { alert("Submitted!") }
                            });
                        </script>

                        <script>
                            $(document).ready(function () {
                                $("#addstudent").validate({
                                    debug: false,
                                    rules: {
                                        studentid: "required",
                                        teacher: "required",
                                        assignment: "required",
                                        date: "required",
                                    },
                                    messages: {
                                        studentid: "Please enter the student's ID number.",
                                        teacher: "Please enter your name.",
                                        assignment: "Please select a tutoring assignment.",
                                        date: "Please select a day.",
                                    },
                                    submitHandler: function (form) {

                                        $.ajax({
                                            url: 'add.php',
                                            type: 'POST',
                                            data: $("form.addstudent").serialize(),
                                            success: function () {
                                                $("#studentid").val(""), $('#studentid').focus(), $('#results').load('addresults.php', function () {
                                                });

                                            }
                                        });

                                        return false;
                                    }
                                });
                            });
                        </script>
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