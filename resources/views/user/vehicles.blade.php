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
                        <select id="terminal" name="terminal" class="selectjs form-select p-2">
                            <option value="all">All</option>
                            @if(count(@$all_terminal) > 0)
                            @foreach(@$all_terminal as $key => $value)
                                @if($value->id == @$terminal)
                                <option value="{{ @$value->id }}" selected>{{ $value->name.' ('.count($value->vehicles).')' }}</option>
                                @else
                                <option value="{{ @$value->id }}">{{ @$value->name.' ('.count($value->vehicles).')' }}</option>
                                @endif
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="status" class="fw-semibold">Status</label>
                        <select id="status" name="status" class="selectjs form-select p-2">
                            <option value="all">All</option>
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

                    <div class="col-md-3 mb-2">
                        <label for="destination" class="fw-semibold">Destination</label>
                        <select id="destination" name="destination" class="selectjs form-select p-2 border border-gray-200 rounded-lg">
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
                        <select id="pay_status" name="pay_status" class="selectjs form-select p-2">
                            <option value="all" @if(@$pay_status == "all") selected @endif>All</option>
                            <option value="paid" @if(@$pay_status == "paid") selected @endif>Paid</option>
                            <option value="partly paid" @if(@$pay_status == "partly paid") selected @endif>Partly paid</option>
                            <option value="unpaid" @if(@$pay_status == "unpaid") selected @endif>Unpaid</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="fuel_type" class="fw-semibold">Fuel Type</label>
                        <select id="fuel_type" name="fuel_type" class="selectjs form-select p-2">
                            <option value="all" @if(@$fuel_type == "all") selected @endif>All</option>
                            <option value="GAS" @if(@$fuel_type == "GAS") selected @endif>GAS</option>
                            <option value="HYB" @if(@$fuel_type == "HYB") selected @endif>HYB</option>
                            <option value="EV" @if(@$fuel_type == "EV") selected @endif>EV</option>
                            <option value="Other" @if(@$fuel_type == "Other") selected @endif>Other</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="search" class="fw-semibold">Search</label>
                        <input type="text" class="form-control p-2" name="search" value="{{ @$search }}" id="search-veh" placeholder="Search">
                    </div>
                </form>

                <div class="mt-5">
                    <div class="d-flex justify-content-between mt-3">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                            List of Vehicles
                        </h4>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="table-responsive tab-pane fade show active" data-bs-toggle="tab" id="admin">
                            <table class="table">
                                <thead class="text-fs-4" style="font-size: 16px;">
                                    <th scope="col"></th>
                                    <th scope="col">Description</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Keys</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Fuel Type</th>
                                    <th scope="col">Terminal</th>
                                    <th scope="col">Comment</th>
                                    @if(\Auth::user()->role == "2")
                                    <th scope="col"></th>
                                    @endif
                                </thead>
                                <tbody>
                                    @if(count(@$admin) > 0)
                                    @foreach(@$admin as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td @if(@$value->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex flex-column justify-content-center">
                                                @if(!empty(@$value->vehicle->vehicle_documents))
                                                    @if(count(@$value->vehicle->vehicle_documents) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                                @if(!empty(@$value->vehicle->vehicle_images))
                                                    @if(count(@$value->vehicle->vehicle_images) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->modal.' '.@$value->vehicle->company_name.' '.@$value->vehicle->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->vin }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                @if(@$value->vehicle->delivery_date) {{ date("M d, Y", strtotime(@$value->vehicle->delivery_date)) }} @endif
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->destination_port->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->title == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->title == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @else
                                                <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="text-fs-4">
                                                    {{ @$value->vehicle->title }}
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->keys == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->keys == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex px-3 p-1 rounded-pill align-items-center shadow">
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
                                                <span class="text-fs-4 ms-2" style="font-size: 14px;">{{ @$value->vehicle->status->name }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center" @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
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
                                            <i class="text-fs-5 {{ $ico }}" style="font-size: 14px;"></i>
                                            {{-- <span class="fs-5 ms-1">{{ @$value->vehicle->fuel_type }}</span> --}}
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-bold text-fs-4">
                                                {{ @$value->vehicle->terminal->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="flex items-center justify-center flex-col comment"
                                                style="width:250px; border-radius:3px">
                                                <div class="border border-1 d-flex flex-column align-items-end">
                                                    <p class="text-fs-3" style="font-size: 14px;">
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
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
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
                                                                        <input class="form-control me-2 bg-white border-0 fs-5" placeholder="{{ @$v->surname }}" disabled aria-label="upload">
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
                                    <th scope="col"></th>
                                    <th scope="col">Description</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Keys</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Fuel</th>
                                    <th scope="col">Terminal</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$super_user) > 0)
                                    @foreach(@$super_user as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td @if(@$value->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex flex-column justify-content-center">
                                                @if(!empty(@$value->vehicle->vehicle_documents))
                                                    @if(count(@$value->vehicle->vehicle_documents) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                                @if(!empty(@$value->vehicle->vehicle_images))
                                                    @if(count(@$value->vehicle->vehicle_images) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->modal.' '.@$value->vehicle->company_name.' '.@$value->vehicle->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->vin }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                @if(@$value->vehicle->delivery_date) {{ date("M d, Y", strtotime(@$value->vehicle->delivery_date)) }} @endif
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->destination_port->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->title == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->title == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @else
                                                <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="text-fs-4">
                                                    {{ @$value->vehicle->title }}
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->keys == 'NO')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @elseif(@$value->vehicle->keys == 'YES')
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex px-3 p-1 rounded-pill align-items-center shadow">
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
                                                <span class="text-fs-4 ms-2" style="font-size: 14px;">{{ @$value->vehicle->status->name }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center" @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <i class="text-fs-5 fa-solid fa-charging-station"></i>
                                            {{-- <span class="fs-5 ms-1">{{ @$value->vehicle->fuel_type }}</span> --}}
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-bold text-fs-4">
                                                {{ @$value->vehicle->terminal->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="flex items-center justify-center flex-col comment"
                                                style="width:250px; border-radius:3px">
                                                <div class="border border-1 d-flex flex-column align-items-end">
                                                    <p class="text-fs-3" style="font-size: 14px;">
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
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
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
                                                                        <input class="form-control me-2 bg-white border-0 fs-5" placeholder="{{ @$v->surname }}" disabled aria-label="upload">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            $("select.option-select").each(function () {
                updateBackgroundColor(this);
            });

            $(document).on("click", ".upload-images", function () {
                $("#images").click();
            });

            $(document).on("change", "#buyer, #terminal, #status, #destination, #search-veh, #pay_status, #fuel_type", function () {
                $("#filters-form").submit();
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
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
    </script>

@endsection