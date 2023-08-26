@extends('layouts.admin')

@section('title')
    System Configuration
@endsection

@section('content')
    
    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    System Configuration
                </h4>
            </div>
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="accordion" id="accordionConfig">
                        @include('admin.system-configuration.sidebar')
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bold fs-5 mb-0">Users</h3>
                            <button class="btn border-0 add" type="button">
                                <img src="{{ asset('assets/plus_green.svg') }}" alt="add" />
                            </button>
                            <div class="modal fade new buyer" id="modal" tabindex="-1"
                                aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog rounded-5" style="max-width: 746px; width: 746px;">
                                    <div class="modal-content p-3">
                                        <div class="modal-header border-0">
                                            <h1 class="modal-title fw-bold" id="modalLabel" style="font-size: 28px">Add New User</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('admin/system-configuration/users/add') }}" method="POST" class="form">
                                                @csrf
                                                <div class="row mt-4">

                                                    <div class="col-md-6 mb-4">
                                                        <!-- username -->
                                                        <div class="row">
                                                            <label for="" class="col-md-4">Username</label>
                                                            <div class="col-md-8">
                                                                <div class="input-group shadow-lg rounded-4">
                                                                    <div class="input-group-text rounded-start-4">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                                            stroke="#194AF9" class="w-6 h-6">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                                                        </svg>
                                                                    </div>
                                                                    <input type="text" name="name" id="user-username" value=""
                                                                        class="py-2 form-control rounded-end-4"
                                                                        placeholder="John Sabestin" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <!-- Company -->
                                                        <div class="row">
                                                            <label for="" class="col-md-4">Company</label>
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
                                                                    <input type="text" name="company" id="user-company" 
                                                                        class="py-2 form-control rounded-end-4"
                                                                        placeholder="Hn Sabestin" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <!-- Name -->
                                                        <div class="row">
                                                            <label for="" class="col-md-4">Name</label>
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
                                                                    <input type="text" name="surname" id="user-surname" 
                                                                        class="py-2 form-control rounded-end-4"
                                                                        placeholder="John Sabestin" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <!-- Country -->
                                                        <div class="row">
                                                            <label for="" class="col-md-4">Country</label>
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
                                                                    <select class="form-select countries" id="country" name="country" aria-label="Default select example">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <!-- Email -->
                                                        <div class="row">
                                                            <label for="" class="col-md-4">Email</label>
                                                            <div class="col-md-8">
                                                                <div class="input-group shadow-lg rounded-4">
                                                                    <div class="input-group-text rounded-start-4">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                                            stroke="#194AF9" class="w-6 h-6">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                                        </svg>
                                                                    </div>
                                                                    <input type="email" name="email" id="user-email" 
                                                                        class="py-2 form-control rounded-end-4"
                                                                        placeholder="abc123@gmail.com" required />
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
                                                                    <input type="hidden" name="dial_code" id="dial_code" value="">
                                                                    <input name="phone" type="text" id="user-phone" class="py-2 form-control rounded-end-4 border-0" placeholder="Enter Number" required />
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
                                                                        @if(count(@$level) > 0)
                                                                        @foreach(@$level as $key => $value)
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
                                                            <label for="" class="col-md-4">Password</label>
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
                                                                    <input type="password" name="password"
                                                                        class="py-2 form-control rounded-end-4"
                                                                        placeholder="Password" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <!-- Repeat Password -->
                                                        <div class="row">
                                                            <label for="" class="col-md-4">Confirm Password</label>
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
                                                                    <input type="password" name="cpassword"
                                                                        class="py-2 form-control rounded-end-4"
                                                                        placeholder="Confirm Password" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                        </div>
                        <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">
                            <div class="d-flex gap-2 align-items-center page-icon">
                                @php
                                    $prev = (int)$page - 1;
                                    $next = (int)$page + 1;
                                    $pre = 'page='.$prev;
                                    $nex = 'page='.$next;
                                @endphp
                                <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/system-configuration/users?'.$pre) }}" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </a>
                                <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                                <a class="btn" @if(count($users) < 10) href="javascript:void();" @else href="{{ url('admin/system-configuration/users?'.$nex) }}" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col" class="fw-bold">Username</th>
                                    <th scope="col" class="fw-bold">Email</th>
                                    <th scope="col" class="fw-bold">Company</th>
                                    <th scope="col" class="fw-bold">Phone</th>
                                    <th scope="col" class="fw-bold">Level</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count($users) > 0)
                                    @foreach($users as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <span class=" text-fs-3">
                                                {{ @$value->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class=" text-fs-3">
                                                {{ @$value->email }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class=" text-fs-3">
                                                {{ @$value->company }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class=" text-fs-3">
                                                {{ @$value->phone }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class=" text-fs-3">
                                                {{ @$value->user_level->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center float-end">
                                                <span class="fs-5 text-primary me-3">
                                                    <i class="fa-solid fa-edit edit" data-id="{{ @$value->id }}" style="cursor: pointer;"></i>
                                                </span>
                                                <span class="fs-5 text-danger">
                                                    <i class="fa-solid fa-circle-xmark delete" data-url="{{ url('admin/system-configuration/users/delete', @$value->id) }}" style="cursor: pointer;"></i>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                        <td class="text-center" colspan="6">
                                            <p>No record found</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade remove" id="removeRowModal" tabindex="-1"
                        aria-labelledby="removeRowModalLabel" aria-hidden="true">
                        <div class="modal-dialog rounded-5">
                            <div class="modal-content p-3">
                                <div class="modal-header border-0">
                                    <h1 class="modal-title fw-bold" id="removeRowModalLabel" style="font-size: 28px">
                                        Delete this Record?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <button id="delete-link" type="button" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5">Ok</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-warning border-0 mt-4 col-md-12 rounded-3 fs-5" type="button" 
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
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
            var out = "<option rel='' value=''>Country</option>";
            for (var key in countries) {
                out += "<option rel='" + key + "' value="+countries[key]+">" + countries[key] + "</option>";
            }

            document.getElementById(container).innerHTML = out;
        }
        countriesDropdown("country");
    </script>

    <script>
        $(document).ready(() => {
            $('.selectjs').select2();
        })
    </script>
        <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
        var input1 = document.querySelector("#user-phone");
        window.intlTelInput(input1, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["jo", "iq"]
        });

        $(document).ready(function () {
            $(document).on("submit", ".form", function (event) {
                event.preventDefault();
                $.ajax({
                    type: $(this).attr("method"),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    url: $(this).attr("action"),
                    data: new FormData(this),
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    success: function (res) {
                        // res = JSON.parse(res);
                        console.log(res);
                        if (res.success == true) {
                            toastr["success"](res.msg, "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr["error"](res.msg, "Failed!");
                        }
                    }
                });
            });

            $(document).on("click", ".iti__country", function () {
                $("#dial_code").val($(".iti__selected-dial-code").last().text().trim());
            });

            $(document).on("click", ".add", function () {
                
                $("#modalLabel").text("Add new User");
                $("#user-username").val('');
                $("#user-email").val('');
                $("#user-surname").val('');
                $("#user-company").val('');
                $("#country option[value='']").attr("selected", true);
                $("#user-phone").val('');
                $(".level option[value='']").attr("selected", true);

                $("#modal").modal("show");
                $(".form").attr("action", "{{ url('admin/system-configuration/users/add') }}");
                        
            });

            $(document).on("click", ".edit", function () {
                var id = $(this).attr("data-id");

                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/system-configuration/users/edit') }}/"+id,
                    success: function (res) {
                        res = JSON.parse(res);
                        console.log(res);
                        if (res.success == true) {
                            $("#modalLabel").text("Edit User");
                            $("#user-username").val(res.data.name);
                            $("#user-email").val(res.data.email);
                            $("#user-surname").val(res.data.surname);
                            $("#user-company").val(res.data.company);
                            $("#country option[value="+res.data.country+"]").attr("selected", true);
                            var phone = res.data.phone.split(" ");
                            $("#user-phone").val(phone[1]);
                            $(".iti__selected-dial-code").text(phone[0]);
                            $("#dial_code").text(phone[0]);
                            $(".level option[value="+res.data.level_id+"]").attr("selected", true);

                            $("#modal").modal("show");
                            $(".form").attr("action", "{{ url('admin/system-configuration/users/edit') }}/"+id);
                        }
                    }
                });
            });

            $(document).on("click", ".delete", function () {
                $("#delete-link").attr("data-url", $(this).attr('data-url'));
                $("#removeRowModal").modal("show");
            });
            $(document).on("click", "#delete-link", function () {
                $.ajax({
                    type: "GET",
                    url: $(this).attr("data-url"),
                    success: function (res) {
                        res = JSON.parse(res);
                        $("#removeRowModal").modal("hide");
                        if (res.success == true) {
                            toastr["success"](res.msg, "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>

@endsection