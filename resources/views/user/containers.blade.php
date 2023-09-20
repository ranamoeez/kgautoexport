@extends('layouts.user')

@section('content')

    <style type="text/css">
        table th {
            font-weight: bold !important;
        }
    </style>

    <div class="below-header-height outer-container">
        <div class="inner-container">
            <!-- information page -->

            <div>
                <!-- Assigned By -->
                <div class="mt-5 d-flex justify-content-between">
                    <div class="">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                            Container Details
                        </h4>
                    </div>
                    <!-- Assigned By -->
                    <div class="d-flex justify-content-end">
                        <div class="mt-6 px-14">
                            <h4 class="fw-bold fs-md-13 fs-lg-25">Assigned By:</h4>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fs-5 fw-bold" id="admin-tab"
                                        data-bs-toggle="tab" data-bs-target="#admin" type="button">
                                        Admin
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-5 fw-bold btn" id="super-admin-tab"
                                        data-bs-toggle="tab" data-bs-target="#super-admin" type="button">
                                        Super User
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <form method="GET" action="{{ url('user/containers') }}" class="row align-items-center" id="filters-form">
                    <div class="col-md-2">
                        <label for="port" class="fw-semibold">Port</label>
                        <select class="selectjs form-select p-2 border border-gray-200 rounded-lg" id="port" name="port">
                        <option value="all" selected>All</option>
                        @if(count(@$all_port) > 0)
                        @foreach(@$all_port as $key => $value)
                            @if($value['id'] == @$port)
                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                            @else
                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                            @endif
                        @endforeach
                        @endif
                    </select>
                    </div>

                    <div class="col-md-2">
                        <label for="status" class="fw-semibold">Status</label>
                        <select id="status" name="status" class="selectjs form-select p-2">
                            <option value="all" selected>All</option>
                            @if(count(@$all_status) > 0)
                            @foreach(@$all_status as $key => $value)
                                @if($value['id'] == @$status)
                                <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                @else
                                <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                @endif
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="search" class="fw-semibold">Search</label>
                        <input type="text" class="form-control p-2" placeholder="Search" name="search" value="{{ @$search }}" id="search-cont">
                    </div>

                    <div class="col-md-2">
                        <label for="pay_status" class="fw-semibold">Payment Status</label>
                        <select id="pay_status" name="pay_status" class="selectjs form-select p-2">
                            <option value="all" @if(@$paystatus == "all") selected @endif>All</option>
                            <option value="1" @if(@$pay_status == "1") selected @endif>Paid</option>
                            <option value="0" @if(@$pay_status == "0") selected @endif>Unpaid</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- shipment details list -->
            <div class="mt-5">
                <div class="d-flex justify-content-between mt-3">
                    <h4 class="fw-bold fs-md-13 text-fs-5">
                        Containers List
                    </h4>
                </div>

                <div class="tab-content" id="pills-tabContent">

                    <div class="table-responsive tab-pane fade show active" id="admin">
                        <table class="table">
                            <thead class="fs-4">
                                <th scope="col">Booking No.</th>
                                <th scope="col">Container No.</th>
                                <th scope="col">Departure</th>
                                <th scope="col">Arrival</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tracking</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @if(count($admin) > 0)
                                @foreach($admin as $key => $value)
                                <tr class="align-middle overflow-hidden shadow mb-2">
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->booking_no }}
                                        </a>
                                    </td>
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->container_no }}
                                        </a>
                                    </td>
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->departure }}
                                        </a>
                                    </td>
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->arrival }}
                                        </a>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <div class="d-flex justify-content-center">
                                            <div class="text-center px-3 py-1 rounded-pill shadow">
                                                <span class="fs-5 ms-1">{{ @$value->destination_port->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <div class="d-flex justify-content-center">
                                            <div class="d-flex p-1 px-3 rounded-pill shadow">
                                                @php
                                                    $icon = "booked";
                                                    if (@$value->status_id == "2") {
                                                        $icon = "loaded";
                                                    } elseif (@$value->status_id == "3") {
                                                        $icon = "shipped";
                                                    } elseif (@$value->status_id == "4") {
                                                        $icon = "delivered";
                                                    }
                                                @endphp
                                                <img src="{{ asset('assets/icons/'.$icon.'.png') }}" style="width: 25px;">
                                                <span class="fs-5 ms-1">{{ @$value->status->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <div class="py-2 flex items-center justify-content-center flex-column">
                                            <div class="px-0.5 py-1">
                                                <button class="btn btn-primary rounded-1 border border-0 fs-5 tracking" type="button" data-text="{{ @$value->shipping_line->name }}" data-id="{{ @$value->container_no }}">
                                                    Tracking
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <button data-target="#detail_{{ @$value->id }}"
                                            class="details-button rounded-circle bg-primary p-1 user-icon"
                                            style="transition: all 0.2s linear;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse fade show" id="detail_{{ @$value->id }}">
                                    <td colspan="8">
                                        <div class="container">
                                            <div class="rounded row shadow header-shipment">
                                                <div class="col text-center fw-bold py-2">Details</div>
                                                <div class="col text-center fw-bold py-2">P.Status</div>
                                                <div class="col text-center fw-bold py-2">Shipping line</div>
                                            </div>
                                            <div class="row">
                                                <div class="col mt-3 text-fs-3 shipment-details">
                                                    <ul>
                                                        @if(count(@$value->buyers) > 0)
                                                        @foreach(@$value->buyers as $k => $v)
                                                        @if(@$v->user->id == auth()->user()->id)
                                                        Buyer:<span class="fw-bold"> {{ @$v->user->surname }}</span>
                                                        @foreach($v->vehicles as $ke => $val)
                                                        <li class="list-unstyled">
                                                            » <span class="fw-bold">{{ @$val->vehicle->company_name.' '.@$val->vehicle->name.' '.@$val->vehicle->modal }}</span>,
                                                            VIN: <span class="fw-bold fs-5"><a
                                                                    href="{{ url('user/containers/1') }}"
                                                                    class="text-dark text-decoration-none">{{ @$val->vehicle->vin }}</a></span>
                                                        </li>
                                                        @endforeach
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </ul>
                                                </div>

                                                <div
                                                    class="col d-flex align-items-center justify-content-center">
                                                    <button class="@if(@$value->all_paid == "1") bg-success @elseif(@$value->all_paid == "0") bg-danger @endif rounded-1 text-white fs-5 px-4 py-1 border border-0">
                                                        @if(@$value->all_paid == "1") Paid @elseif(@$value->all_paid == "0") Unpaid @endif
                                                    </button>
                                                </div>

                                                <div class="col d-flex align-items-center justify-content-center text-fs-4 fw-medium">
                                                    {{ @$value->shipping_line->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                    <td class="text-center" colspan="8">
                                        <p>No record found</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive tab-pane fade" id="super-admin">
                        <table class="table">
                            <thead class="fs-4">
                                <th scope="col">Booking No.</th>
                                <th scope="col">Container No.</th>
                                <th scope="col">Departure</th>
                                <th scope="col">Arrival</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tracking</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @if(count($super_user) > 0)
                                @foreach($super_user as $key => $value)
                                <tr class="align-middle overflow-hidden shadow mb-2">
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->booking_no }}
                                        </a>
                                    </td>
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->container_no }}
                                        </a>
                                    </td>
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->departure }}
                                        </a>
                                    </td>
                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <a href="{{ url('user/containers', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold mb-2 text-fs-3">
                                            {{ @$value->arrival }}
                                        </a>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <div class="d-flex justify-content-center">
                                            <div class="text-center px-3 py-1 rounded-pill shadow">
                                                <span class="fs-5 ms-1">{{ @$value->destination_port->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <div class="d-flex justify-content-center">
                                            <div class="d-flex p-1 px-3 rounded-pill shadow">
                                                @php
                                                    $icon = "booked";
                                                    if (@$value->status_id == "2") {
                                                        $icon = "loaded";
                                                    } elseif (@$value->status_id == "3") {
                                                        $icon = "shipped";
                                                    } elseif (@$value->status_id == "4") {
                                                        $icon = "delivered";
                                                    }
                                                @endphp
                                                <img src="{{ asset('assets/icons/'.$icon.'.png') }}" style="width: 25px;">
                                                <span class="fs-5 ms-1">{{ @$value->status->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <div class="py-2 flex items-center justify-content-center flex-column">
                                            <div class="px-0.5 py-1">
                                                <button class="btn btn-primary rounded-1 border border-0 fs-5 tracking" type="button" data-text="{{ @$value->shipping_line->name }}" data-id="{{ @$value->container_no }}">
                                                    Tracking
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                        <button data-target="#detail1_{{ @$value->id }}"
                                            class="details-button rounded-circle bg-primary p-1 user-icon"
                                            style="transition: all 0.2s linear;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse fade show" id="detail1_{{ @$value->id }}">
                                    <td colspan="8">
                                        <div class="container">
                                            <div class="rounded row shadow header-shipment">
                                                <div class="col text-center fw-bold py-2">Details</div>
                                                <div class="col text-center fw-bold py-2">P.Status</div>
                                                <div class="col text-center fw-bold py-2">Shipping line</div>
                                            </div>
                                            <div class="row">
                                                <div class="col mt-3 text-fs-3 shipment-details">
                                                    <ul>
                                                        @if(count(@$value->buyers) > 0)
                                                        @foreach(@$value->buyers as $k => $v)
                                                        @if(@$v->user->id == auth()->user()->id)
                                                        Buyer:<span class="fw-bold"> {{ @$v->user->surname }}</span>
                                                        @foreach($v->vehicles as $ke => $val)
                                                        <li class="list-unstyled">
                                                            » <span class="fw-bold">{{ @$val->vehicle->company_name.' '.@$val->vehicle->name.' '.@$val->vehicle->modal }}</span>,
                                                            VIN: <span class="fw-bold fs-5"><a
                                                                    href="{{ url('user/containers/1') }}"
                                                                    class="text-dark text-decoration-none">{{ @$val->vehicle->vin }}</a></span>
                                                        </li>
                                                        @endforeach
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </ul>
                                                </div>

                                                <div
                                                    class="col d-flex align-items-center justify-content-center">
                                                    <button class="@if(@$value->all_paid == "1") bg-success @elseif(@$value->all_paid == "0") bg-danger @endif rounded-1 text-white fs-5 px-4 py-1 border border-0">
                                                        @if(@$value->all_paid == "1") Paid @elseif(@$value->all_paid == "0") Unpaid @endif
                                                    </button>
                                                </div>

                                                <div class="col d-flex align-items-center justify-content-center text-fs-4 fw-medium">
                                                    {{ @$value->shipping_line->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                    <td class="text-center" colspan="8">
                                        <p>No record found</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(() => {
            $('.selectjs').select2();
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(() => {
            $('.details-button').click((e) => {
                $($(e.target).closest('.details-button').attr('data-target')).toggleClass('show')
                if (
                    $(e.target).closest('.details-button').css('transform') == 'none'
                ) $(e.target).closest('.details-button').css('transform', 'rotate(360deg)')
                else {
                    $(e.target).closest('.details-button').css('transform', 'none')
                }
            })
        })
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');

            $(document).on("change", "#port, #status, #search-cont, #pay_status", function () {
                $("#filters-form").submit();
            });

            $(document).on("click", ".tracking", function () {
                var data = $(this).attr('data-text');
                var id = $(this).attr('data-id');
                if (id == "") {
                    toastr["error"]("Container number is empty!", "Failed!");
                } else {
                    if (data == "MAERSK LINE") {
                        window.open("https://www.maersk.com/tracking/"+id);
                    } else if (data == "HAPAG-LLOYD") {
                        window.open("https://www.hapag-lloyd.com/en/online-business/track/track-by-container-solution.html?container="+id);
                    } else {
                        window.open("https://www.searates.com/container/tracking/?container="+id+"&sealine=AUTO");
                    }
                }
            });
        });
    </script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
    </script>

@endsection