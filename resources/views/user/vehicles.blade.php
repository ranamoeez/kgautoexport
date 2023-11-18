@extends('layouts.user')

@section('content')

    <style type="text/css">
        table th {
            font-weight: bold !important;
        }
        .select2-selection {
            min-height: 40px;
            border-color: #dee2e6 !important;
        }
        .select2.select2-container {
            width: 100% !important;
        }
        #filters-form .select2-selection__arrow {
            display: none;
        }
    </style>

    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div class="mt-5">
                <!-- Assigned By -->
                @if(\Auth::user()->role == "2")
                <div class="d-flex justify-content-end">
                    <div class="mt-6 px-14">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">Assigned By:</h4>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fs-5 fw-bold" id="admin-tab" data-bs-toggle="tab"
                                    data-bs-target="#admin" type="button">
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
                @endif

                <form method="GET" action="{{ url('user/vehicles') }}" class="row align-items-center" id="filters-form">
                    <input type="hidden" name="page" value="{{ @$page }}">
                    <div class="col-md-3 mb-2">
                        <label for="terminal" class="fw-semibold">Terminal</label>
                        <select id="terminal" name="terminal" class="selectjs form-select p-2 filter">
                            <option value="all">All</option>
                            @if(count(@$all_terminal) > 0)
                            @foreach(@$all_terminal as $key => $value)
                                @if($value->id == @$terminal)
                                <option value="{{ @$value->id }}" selected>{{ $value->name.' ('.$value->vehicles.')' }}</option>
                                @else
                                <option value="{{ @$value->id }}">{{ @$value->name.' ('.$value->vehicles.')' }}</option>
                                @endif
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="status" class="fw-semibold">Status</label>
                        <select id="status" name="status" class="selectjs form-select p-2 filter">
                            <option value="all">All</option>
                            @if(count(@$all_status) > 0)
                            @foreach(@$all_status as $key => $value)
                                @if($value['id'] == @$status)
                                <option value="{{ @$value->id }}" selected>{{ $value->name.' ('.$value->vehicles.')' }}</option>
                                @else
                                <option value="{{ @$value->id }}">{{ @$value->name.' ('.$value->vehicles.')' }}</option>
                                @endif
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="destination" class="fw-semibold">Destination</label>
                        <select id="destination" name="destination" class="selectjs form-select p-2 border border-gray-200 rounded-lg filter">
                            <option value="all">All</option>
                            @if(count(@$all_destination_port) > 0)
                            @foreach(@$all_destination_port as $key => $value)
                                @if($value->id == @$destination)
                                <option value="{{ @$value->id }}" selected>{{ $value->name }}</option>
                                @else
                                <option value="{{ @$value->id }}">{{ @$value->name }}</option>
                                @endif
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="pay_status" class="fw-semibold">Payment Status</label>
                        <select id="pay_status" name="pay_status" class="selectjs form-select p-2 filter">
                            <option value="all" @if(@$pay_status == "all") selected @endif>All</option>
                            <option value="paid" @if(@$pay_status == "paid") selected @endif>Paid</option>
                            <option value="partly paid" @if(@$pay_status == "partly paid") selected @endif>Partly paid</option>
                            <option value="unpaid" @if(@$pay_status == "unpaid") selected @endif>Unpaid</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="fuel_type" class="fw-semibold">Fuel Type</label>
                        <select id="fuel_type" name="fuel_type" class="selectjs form-select p-2 filter">
                            <option value="all" @if(@$fuel_type == "all") selected @endif>All</option>
                            <option value="GAS" @if(@$fuel_type == "GAS") selected @endif>GAS</option>
                            <option value="HYB" @if(@$fuel_type == "HYB") selected @endif>HYB</option>
                            <option value="EV" @if(@$fuel_type == "EV") selected @endif>EV</option>
                            <option value="Other" @if(@$fuel_type == "Other") selected @endif>Other</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="search" class="fw-semibold">Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control p-2 filter" name="search" value="{{ @$search }}" placeholder="Search" style="border: 1px solid #dee2e6;">
                            <div class="input-group-text">
                                <i class="fa-solid fa-magnifying-glass" style="font-size: 20px; cursor: pointer;" id="search-btn"></i>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-5">
                    <div class="d-flex justify-content-between mt-3 align-items-center">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                            List of Vehicles
                        </h4>
                        <div class="d-flex gap-2 align-items-center page-icon">
                            @php
                                $prev = (int)$page - 1;
                                $next = (int)$page + 1;
                                $prev_params = ['page='.$prev];
                                $next_params = ['page='.$next];
                                if (!empty(@$terminal)) {
                                    array_push($prev_params, 'terminal='.$terminal);
                                    array_push($next_params, 'terminal='.$terminal);
                                }
                                if (!empty(@$status)) {
                                    array_push($prev_params, 'status='.$status);
                                    array_push($next_params, 'status='.$status);
                                }
                                if (!empty(@$fuel_type)) {
                                    array_push($prev_params, 'fuel_type='.$fuel_type);
                                    array_push($next_params, 'fuel_type='.$fuel_type);
                                }
                                if (!empty(@$search)) {
                                    array_push($prev_params, 'search='.$search);
                                    array_push($next_params, 'search='.$search);
                                }
                                if (!empty(@$destination)) {
                                    array_push($prev_params, 'destination='.$destination);
                                    array_push($next_params, 'destination='.$destination);
                                }
                                if (!empty(@$pay_status)) {
                                    array_push($prev_params, 'pay_status='.$pay_status);
                                    array_push($next_params, 'pay_status='.$pay_status);
                                }
                                $pre = join("&", $prev_params);
                                $nex = join("&", $next_params);
                            @endphp
                            <a class="btn paginate" href="javascript:void();" @if(@$page == 1) data-href="0" @else data-href="{{ url('user/vehicles?'.$pre) }}" @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </a>
                            <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                            <a class="btn paginate" href="javascript:void();" @if(count($admin) < 20) data-href="0" @else data-href="{{ url('user/vehicles?'.$nex) }}" @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="table-responsive tab-pane fade show active" data-bs-toggle="tab" id="admin">
                            <table class="table">
                                <thead class="text-fs-4" style="font-size: 16px;">
                                    <th scope="col" style="text-align: left !important;">Delivery Date</th>
                                    <th scope="col" style="text-align: left !important;">Description</th>
                                    <th scope="col" style="text-align: left !important;">VIN</th>
                                    <th scope="col" style="text-align: left !important;">Destination</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Keys</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Fuel Type</th>
                                    <th scope="col" style="text-align: left !important;">Terminal</th>
                                    <th scope="col" style="text-align: left !important;">Comment</th>
                                    @if(\Auth::user()->role == "2")
                                    <th scope="col"></th>
                                    @endif
                                </thead>
                                <tbody>
                                    @if(count(@$admin) > 0)
                                    @foreach(@$admin as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                @if(@$value->vehicle->delivered_on_date && @$value->vehicle->delivered_on_date !== "0000-00-00") {{ date("M d, Y", strtotime(@$value->vehicle->delivered_on_date)) }} @endif
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->modal.' '.@$value->vehicle->company_name.' '.@$value->vehicle->name }}
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                <i class="fa-solid fa-camera" style="font-size: 16px; margin-right: 5px;"></i> {{ @$value->vehicle->vin }}
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->destination_port->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->title == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->title == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @else
                                                <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="text-fs-4">
                                                    <b>{{ @$value->vehicle->title }}</b>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->keys == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->keys == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="p-2 rounded-pill align-items-center shadow" @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #c8f3a1 !important;" @endif>
                                                @php
                                                    $icon = "new";
                                                    if (@$value->vehicle->status_id == "6") {
                                                        $icon = "terminal";
                                                    } elseif (@$value->vehicle->status_id == "7") {
                                                        $icon = "booked";
                                                    } elseif (@$value->vehicle->status_id == "8") {
                                                        $icon = "loaded";
                                                    } elseif (@$value->vehicle->status_id == "10") {
                                                        $icon = "shipped";
                                                    } elseif (@$value->vehicle->status_id == "11") {
                                                        $icon = "delivered";
                                                    } elseif (@$value->vehicle->status_id == "12") {
                                                        $icon = "released";
                                                    }
                                                @endphp
                                                <img src="{{ asset('assets/icons/'.$icon.'.png') }}" style="width: 25px;">
                                                <span class="text-fs-4 ms-2" style="font-size: 16px;">{{ @$value->vehicle->status->name }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            @php
                                                $ico = "";
                                                if (@$value->vehicle->fuel_type == "EV") {
                                                    $ico = "fa-solid fa-plug text-primary";
                                                } elseif (@$value->vehicle->fuel_type == "HYB") {
                                                    $ico = "fa-solid fa-leaf text-success";
                                                } elseif (@$value->vehicle->fuel_type == "GAS") {
                                                    $ico = "fa-solid fa-gas-pump text-secondary";
                                                }
                                            @endphp
                                            {{-- <i class="text-fs-5 fa-solid fa-charging-station"></i> --}}
                                            <i class="text-fs-5 {{ $ico }}"></i>
                                            {{-- <span class="fs-5 ms-1">{{ @$value->vehicle->fuel_type }}</span> --}}
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-bold text-fs-4">
                                                {{ @$value->vehicle->terminal->name }}
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <div class="flex items-center justify-center flex-col comment"
                                                style="width:250px; border-radius:3px">
                                                <div class="border border-1 d-flex flex-column align-items-end">
                                                    <p class="text-fs-3 p-3" style="font-size: 14px;">
                                                        {{ @$value->vehicle->notes_user }}
                                                    </p>
                                                    <button class="btn btn-sm btn-primary comment-btn fs-6 border-0" data-bs-toggle="modal" data-bs-target="#fullNoteModel1_{{ $key }}">
                                                        Full Note
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="fullNoteModel1_{{ $key }}" tabindex="-1"
                                                        aria-labelledby="fullNoteModelLabel" aria-hidden="true">
                                                        <div class="modal-dialog rounded-5">
                                                            <div class="modal-content p-3">
                                                                <div class="modal-header border-0">
                                                                    <h1 class="modal-title fw-bold" id="fullNoteModelLabel" style="font-size: 28px">Note</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <input type="text" class="form-control text-fs-5 rounded pb-4" value="{{ @$value->vehicle->notes_user }}" readonly />
                                                                    </div>
                                                                    <a href="#" data-bs-dismiss="modal"
                                                                        class="btn btn-primary border-0 mt-4 col-md-12 w-auto rounded-3 fs-5">Close</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @if(\Auth::user()->role == "2")
                                        <td>
                                            <div class="rounded-circle bg-primary p-1 user-icon"
                                                data-bs-toggle="modal" data-bs-target="#sendUserModel1_{{ $key }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                </svg>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="sendUserModel1_{{ $key }}" tabindex="-1"
                                                aria-labelledby="sendUserModelLabel" aria-hidden="true">
                                                <div class="modal-dialog rounded-5">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-body">
                                                            <div class="">
                                                                @if(count(@$sub_buyers) > 0)
                                                                @foreach(@$sub_buyers as $k => $v)
                                                                <div class="my-2">
                                                                    <form method="POST" action="{{ url("user/assign-vehicle") }}" class="d-flex shadow bg-white rounded-5 rounded assign-form" role="upload">
                                                                        <input type="hidden" name="vehicle_id" value="{{ @$value->vehicle->id }}">
                                                                        <input type="hidden" name="user_id" value="{{ @$v->id }}">
                                                                        <input class="form-control me-2 bg-white border-0 fs-5" placeholder="{{ @$v->name }}" disabled aria-label="upload">
                                                                        <button class="btn btn-primary ded" type="submit">
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                <div class="my-2">
                                                                    <input class="form-control me-2 bg-white border-0 fs-5" placeholder="No sub user found" disabled aria-label="upload">
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                        <td class="text-center" colspan="12">
                                            <p>No record found</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive tab-pane fade" data-bs-toggle="tab" id="super-admin">
                            <table class="table">
                                <thead class="text-fs-4" style="font-size: 16px;">
                                    <th scope="col" style="text-align: left !important;">Delivery Date</th>
                                    <th scope="col" style="text-align: left !important;">Description</th>
                                    <th scope="col" style="text-align: left !important;">VIN</th>
                                    <th scope="col" style="text-align: left !important;">Destination</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Keys</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Fuel Type</th>
                                    <th scope="col" style="text-align: left !important;">Terminal</th>
                                    <th scope="col" style="text-align: left !important;">Comment</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$super_user) > 0)
                                    @foreach(@$super_user as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                @if(@$value->vehicle->delivery_date && @$value->vehicle->departure !== "0000-00-00") {{ date("M d, Y", strtotime(@$value->vehicle->delivery_date)) }} @endif
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->modal.' '.@$value->vehicle->company_name.' '.@$value->vehicle->name }}
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                <i class="fa-solid fa-camera" style="font-size: 16px; margin-right: 5px;"></i> {{ @$value->vehicle->vin }}
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->destination_port->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->title == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->title == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @else
                                                <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="text-fs-4">
                                                    <b>{{ @$value->vehicle->title }}</b>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->keys == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->keys == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="p-2 rounded-pill align-items-center shadow" @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #c8f3a1 !important;" @endif>
                                                @php
                                                    $icon = "new";
                                                    if (@$value->vehicle->status_id == "6") {
                                                        $icon = "terminal";
                                                    } elseif (@$value->vehicle->status_id == "7") {
                                                        $icon = "booked";
                                                    } elseif (@$value->vehicle->status_id == "8") {
                                                        $icon = "loaded";
                                                    } elseif (@$value->vehicle->status_id == "10") {
                                                        $icon = "shipped";
                                                    } elseif (@$value->vehicle->status_id == "11") {
                                                        $icon = "delivered";
                                                    } elseif (@$value->vehicle->status_id == "12") {
                                                        $icon = "released";
                                                    }
                                                @endphp
                                                <img src="{{ asset('assets/icons/'.$icon.'.png') }}" style="width: 25px;">
                                                <span class="text-fs-4 ms-2" style="font-size: 16px;">{{ @$value->vehicle->status->name }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <i class="text-fs-5 fa-solid fa-charging-station"></i>
                                            {{-- <span class="fs-5 ms-1">{{ @$value->vehicle->fuel_type }}</span> --}}
                                        </td>
                                        <td style="text-align: left !important;">
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-bold text-fs-4">
                                                {{ @$value->vehicle->terminal->name }}
                                            </a>
                                        </td>
                                        <td style="text-align: left !important;">
                                            <div class="flex items-center justify-center flex-col comment"
                                                style="width:250px; border-radius:3px">
                                                <div class="border border-1 d-flex flex-column align-items-end">
                                                    <p class="text-fs-3 p-3" style="font-size: 14px;">
                                                        {{ @$value->vehicle->notes_user }}
                                                    </p>
                                                    <button class="btn btn-sm btn-primary comment-btn fs-6 border-0" data-bs-toggle="modal" data-bs-target="#fullNoteModel_{{ $key }}">
                                                        Full Note
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="fullNoteModel_{{ $key }}" tabindex="-1"
                                                        aria-labelledby="fullNoteModelLabel" aria-hidden="true">
                                                        <div class="modal-dialog rounded-5">
                                                            <div class="modal-content p-3">
                                                                <div class="modal-header border-0">
                                                                    <h1 class="modal-title fw-bold"
                                                                        id="fullNoteModelLabel"
                                                                        style="font-size: 28px">
                                                                        Note</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <input type="text" class="form-control text-fs-5 rounded pb-4" value="{{ @$value->vehicle->notes_user }}" readonly />
                                                                    </div>
                                                                    <a href="#" data-bs-dismiss="modal"
                                                                        class="btn btn-primary border-0 mt-4 col-md-12 w-auto rounded-3 fs-5">Close</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rounded-circle bg-primary p-1 user-icon"
                                                data-bs-toggle="modal" data-bs-target="#sendUserModel_{{ $key }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                </svg>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="sendUserModel_{{ $key }}" tabindex="-1"
                                                aria-labelledby="sendUserModelLabel" aria-hidden="true">
                                                <div class="modal-dialog rounded-5">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-body">
                                                            <div class="">
                                                                @if(count(@$sub_buyers) > 0)
                                                                @foreach(@$sub_buyers as $k => $v)
                                                                <div class="my-2">
                                                                    <form method="POST" action="{{ url("user/assign-vehicle") }}" class="d-flex shadow bg-white rounded-5 rounded assign-form" role="upload">
                                                                        <input type="hidden" name="vehicle_id" value="{{ @$value->vehicle->id }}">
                                                                        <input type="hidden" name="user_id" value="{{ @$v->id }}">
                                                                        <input class="form-control me-2 bg-white border-0 fs-5" placeholder="{{ @$v->name }}" disabled aria-label="upload">
                                                                        <button class="btn btn-primary ded" type="submit">
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                <div class="my-2">
                                                                    <input class="form-control me-2 bg-white border-0 fs-5" placeholder="No sub user found" disabled aria-label="upload">
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                        <td class="text-center" colspan="11">
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

            @if(\Auth::user()->role == "2")
            <button type="button" id="open-pickup" class="rounded-circle bg-primary p-4 border border-0 floating-button">
                <img src="{{ asset('/assets/request_car.png') }}" alt="request" />
            </button>
            @endif

            <!-- Modal -->
            <div class="modal fade modal-lg" id="requestPickupModal" tabindex="-1"
                aria-labelledby="requestPickupModalLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fw-bold" id="requestPickupModalLabel"
                                style="font-size: 28px">
                                Request Pick up</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="border-0">
                                <img src="{{ asset('/assets/pickup-car.png') }}" alt="Like" />
                            </div>
                            {{-- <div class="row mt-4">
                                <label for="password" class="col-md-4 fs-5 fw-bold">Amount</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control shadow-lg" />
                                </div>
                            </div> --}}
                            <form method="POST" action="{{ url("user/add-pickup-request") }}" class="form">
                                <div class="row mt-4">
                                    <label for="comments" class="col-md-4 fs-5 fw-bold">Comments</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control shadow-lg" id="comments" name="comments" />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="password" class="col-md-4 fs-5 fw-bold">Vehicle</label>
                                    <div class="col-md-8">
                                        <select class="form-select select2js" aria-label="Default select example" name="vehicle_id">
                                            <option value="0" selected>Choose Vehicles</option>
                                            @if(count(@$vehicles) > 0)
                                            @foreach(@$vehicles as $key => $value)
                                                <option value="{{ @$value->vehicle_id }}">{{ @$value->vehicle->modal." ".@$value->vehicle->company_name." ".@$value->vehicle->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="row mt-4">
                                    <label for="password" class="col-md-4 fs-5 fw-bold">Exchange Company</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control shadow-lg" />
                                    </div>
                                </div> --}}
                                <div class="row mt-4">
                                    <label for="password" class="col-md-4 fs-5 fw-bold">Upload</label>
                                    <div class="col-md-8">
                                        <div class="d-flex shadow bg-white rounded" role="upload">
                                            <input type="file" class="form-control me-2 bg-white border-0 rounded fs-5" aria-label="upload" name="file" id="images">
                                            <button class="btn btn-primary rounded upload-images" type="button">
                                                <div class="d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="22"
                                                        viewBox="0 0 19 22" fill="none">
                                                        <path
                                                            d="M13.0253 0.170898H6.05884C5.10095 0.170898 4.31722 0.954626 4.31722 1.91252V15.8455C4.31722 16.8033 5.10095 17.5871 6.05884 17.5871H16.5085C17.4664 17.5871 18.2502 16.8033 18.2502 15.8455V5.39575L13.0253 0.170898ZM16.5085 15.8455H6.05884V1.91252H12.1545V6.26656H16.5085V15.8455ZM2.5756 3.65413V19.3287H16.5085V21.0703H2.5756C1.61771 21.0703 0.833984 20.2866 0.833984 19.3287V3.65413H2.5756ZM7.80046 8.87899V10.6206H14.7669V8.87899H7.80046ZM7.80046 12.3622V14.1038H12.1545V12.3622H7.80046Z"
                                                            fill="white" />
                                                    </svg>
                                                    <span class="">Choose</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Request Pickup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="requestPickupConfirmModel" tabindex="-1"
                aria-labelledby="requestPickupConfirmModelLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-body">
                            <div class="border-0">
                                <img src="{{ asset('assets/like.png') }}" alt="Like" />
                            </div>
                            <div class="card-body request-pickup-popup">
                                <div class="mt-4">
                                    <h5 class="card-title fw-bold fs-2">Pick up Requested
                                        <span>Successfully</span></h5>
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
        $(document).ready(() => {
            $('.selectjs').select2();
            $(document).on("click", "#open-pickup", function () {
                $(".select2js").select2({
                    dropdownParent: $('#requestPickupModal')
                });
                $("#requestPickupModal").modal("show");
                $("#requestPickupModal .select2.select2-container").css("width", "100%");
                $("#requestPickupModal .select2-selection").css("height", "40px");
                $("#requestPickupModal .select2-selection__arrow").css("display", "none");
            });
        })
    </script>
    <script>
        // Function to update the background color (selected option)
        $(document).ready(function () {
            function updateBackgroundColor(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const color = selectedOption.dataset.color;
                $(selectElement).removeClass("bg-danger bg-success");
                $(selectElement).addClass(`bg-${color}`);
                $(selectedOption).addClass("text-white");
            }

            $("select.option-select").on("change", function () {
                updateBackgroundColor(this);
            });

            $(document).on("click", ".paginate", function () {
                $(this).attr('disabled', true);
                if ($(this).attr('data-href') !== "0") {
                    window.location.href = $(this).attr('data-href');
                    $(this).attr('data-href', '0');
                }
            });

            $("select.option-select").each(function () {
                updateBackgroundColor(this);
            });

            $(document).on("click", ".upload-images", function () {
                $("#images").click();
            });

            $(document).on("change", "#buyer, #terminal, #status, #destination, #pay_status, #fuel_type", function () {
                $("#filters-form").submit();
                $(".filter").attr("disabled", true);
            });

            $(document).on("click", "#search-btn", function () {
                $("#filters-form").submit();
                $(".filter").attr("disabled", true);
            });

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
                            $("#requestPickupModal").modal("hide");
                            $("#requestPickupConfirmModel").modal("show");

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr["error"](res.msg, "Failed!");
                        }
                    }
                });
            });

            $(document).on("submit", ".assign-form", function (event) {
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
        });
    </script>

@endsection