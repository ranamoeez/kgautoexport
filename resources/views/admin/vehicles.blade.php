@extends('layouts.admin')

@section('title')
    Vehicles
@endsection

@section('content')

    <style type="text/css">
        body {
            overflow-y: hidden;
        }
        a:hover {
            color: #023e8a !important;
        }
        .select2-selection {
            min-height: 37px;
        }
        .select2.select2-container {
            width: 100% !important;
        }
    </style>
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    My Vehicles List
                </h4>
            </div>

            <form method="GET" action="{{ url('admin/vehicles') }}" class="row align-items-center" id="filters-form">
                <input type="hidden" name="page" value="{{ @$page }}">
                <div class="col-md-3 mb-2">
                    <label for="buyer" class="fw-semibold">Buyer</label>
                    <select id="buyer" name="buyer" class="selectjs form-select p-2 border border-gray-200 rounded-lg filter">
                        <option value="all">All</option>
                        @if(count(@$all_buyer) > 0)
                        @foreach(@$all_buyer as $key => $value)
                            @if($value->id == @$buyer)
                            <option value="{{ @$value->id }}" selected>{{ @$value->name.' ('.@$value->surname.')' }}</option>
                            @else
                            <option value="{{ @$value->id }}">{{ @$value->name.' ('.@$value->surname.')' }}</option>
                            @endif
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="terminal" class="fw-semibold">Terminal</label>
                    <select id="terminal" name="terminal" class="selectjs form-select p-2 filter">
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
                    <select id="status" name="status" class="selectjs form-select p-2 filter">
                        <option value="all">All</option>
                        @if(count(@$all_status) > 0)
                        @foreach(@$all_status as $key => $value)
                            @if($value['id'] == @$status)
                            <option value="{{ @$value->id }}" selected>{{ $value->name.' ('.count($value->vehicles).')' }}</option>
                            @else
                            <option value="{{ @$value->id }}">{{ @$value->name.' ('.count($value->vehicles).')' }}</option>
                            @endif
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="at_terminal" class="fw-semibold">Since At Terminal</label>
                    <select id="at_terminal" name="at_terminal" class="selectjs form-select p-2 filter">
                        <option value="all">All</option>
                        <option value="1" @if(@$at_terminal == "1") selected @endif>1 day</option>
                        <option value="2" @if(@$at_terminal == "2") selected @endif>2 day</option>
                        <option value="3" @if(@$at_terminal == "3") selected @endif>3 day</option>
                        <option value="4" @if(@$at_terminal == "4") selected @endif>4 day</option>
                        <option value="5" @if(@$at_terminal == "5") selected @endif>5 day</option>
                        <option value="1w" @if(@$at_terminal == "1w") selected @endif>1 week</option>
                        <option value="2w" @if(@$at_terminal == "2w") selected @endif>2 week</option>
                        <option value="m2w" @if(@$at_terminal == "m2w") selected @endif>More than 2 week</option>
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

            <div>
                <div class="d-flex justify-content-between mt-3 align-items-center">
                    <p class="text-fs-4 m-0">Total vehicles: <b>{{ @$total_vehicles }}</b></p>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-fs-4" style="font-size: 16px;">
                            <th scope="col"></th>
                            {{-- <th scope="col" class="fw-bold">Vehicle Photo</th> --}}
                            <th scope="col" class="fw-bold">Delivery Date</th>
                            <th scope="col" class="fw-bold">Description</th>
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Buyer</th>
                            <th scope="col" class="fw-bold">Client Name</th>
                            <th scope="col" class="fw-bold">Destination</th>
                            <th scope="col" class="fw-bold">Title</th>
                            <th scope="col" class="fw-bold">Keys</th>
                            <th scope="col" class="fw-bold">Payment Status</th>
                            <th scope="col" class="fw-bold">Fuel Type</th>
                            <th scope="col" class="fw-bold">Status</th>
                            <th scope="col" class="fw-bold">Days</th>
                            <th scope="col" class="fw-bold">Terminal</th>
                            <th scope="col" class="fw-bold">Notes</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @if(count($list['data']) > 0)
                            @foreach($list['data'] as $key => $value)
                            <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <div class="d-flex flex-column justify-content-center">
                                        @if(!empty(@$value['vehicle']['vehicle_documents']))
                                            @if(count(@$value['vehicle']['vehicle_documents']) > 0)
                                            <a href="javascript:void();" class="text-link text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            </a>
                                            @endif
                                        @endif
                                        @if(!empty(@$value['vehicle']['vehicle_images']))
                                            @if(count(@$value['vehicle']['vehicle_images']) > 0)
                                            <a href="javascript:void();" class="text-link text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                {{-- <td>
                                    <img src="{{ asset('assets/FordExplorerXLT.webp') }}"
                                        class="rounded-4 table-thumbnail-image" />
                                </td> --}}
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important; text-align: left !important;" @else style="text-align: left !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value['id']) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        @if(!empty(@$value['vehicle']['delivered_on_date']) && @$value['vehicle']['delivered_on_date'] !== "0000-00-00")
                                        {{ date("M d, Y", strtotime(@$value['vehicle']['delivered_on_date'])) }}
                                        @endif
                                    </a>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important; text-align: left !important;" @else style="text-align: left !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value['id']) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        {{ @$value['vehicle']['modal'].' '.@$value['vehicle']['company_name'].' '.@$value['vehicle']['name'] }}
                                    </a>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important; text-align: left !important;" @else style="text-align: left !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value['id']) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        {{ @$value['vehicle']['vin'] }}
                                    </a>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important; text-align: left !important;" @else style="text-align: left !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value['id']) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        {{ @$value['user']['name'] }}
                                    </a>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important; text-align: left !important;" @else style="text-align: left !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value['id']) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        {{ @$value['vehicle']['client_name'] }}
                                    </a>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important; width: 170px !important;" @else style="width: 170px !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <select id="selectDestOption{{$key+1}}" class="selectjs form-select destination_port" aria-label="Default select example" data-id="{{ @$value['vehicle']['id'] }}">
                                            <option value="0">Select Destination</option>
                                            @if(count(@$all_destination_port) > 0)
                                            @foreach(@$all_destination_port as $k => $v)
                                                @if(@$v['id'] == @$value['vehicle']['destination_port_id'])
                                                <option value="{{ @$v['id'] }}" selected>{{ @$v['name'] }}</option>
                                                @else
                                                <option value="{{ @$v['id'] }}">{{ @$v['name'] }}</option>
                                                @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <select class="form-select ps-1 pe-2 py-1 title" aria-label="Default select example" data-id="{{ @$value['vehicle']['id'] }}" @if(@$value['vehicle']['title'] == "TBO") style="background-position: right; min-width: 50px; background-color: #edd4e4;" @elseif(@$value['vehicle']['title'] == "YES") style="background-position: right; min-width: 50px; background-color: #70e790;" @elseif(@$value['vehicle']['title'] == "BOS") style="background-position: right; min-width: 50px; background-color: #89ceff;" @else style="background-position: right; min-width: 50px; background-color: #ffa6a6;" @endif>
                                            <option value="NO" @if(@$value['vehicle']['title'] == "NO") selected @endif>NO</option>
                                            <option value="YES" @if(@$value['vehicle']['title'] == "YES") selected @endif>YES</option>
                                            <option value="BOS" @if(@$value['vehicle']['title'] == "BOS") selected @endif>BOS</option>
                                            <option value="TBO" @if(@$value['vehicle']['title'] == "TBO") selected @endif>TBO</option>
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <select class="form-select ps-1 pe-2 py-1 keys" aria-label="Default select example" data-id="{{ @$value['vehicle']['id'] }}" @if(@$value['vehicle']['keys'] == "YES") style="background-position: right; min-width: 50px; background-color: #70e790;" @else style="background-position: right; min-width: 50px; background-color: #ffa6a6;" @endif>
                                            <option value="NO" @if(@$value['vehicle']['keys'] == "NO") selected @endif>NO</option>
                                            <option value="YES" @if(@$value['vehicle']['keys'] == "YES") selected @endif>YES</option>
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4 d-flex justify-content-between" style="font-size: 14px;">
                                        {{-- <span style="font-size: 14px;">${{ (!empty(@$value['vehicle']['auction_price'])) ? @$value['vehicle']['auction_price'] : '0.00' }}</span> --}}
                                        <a href="{{ url('admin/vehicles/edit', @$value['id']) }}" style="text-decoration: none; color: #000000; font-size: 18px;" class="mt-1">${{ (int)@$value['vehicle']['us_towing_price'] + (int)@$value['vehicle']['us_trans_fines'] }}</a>
                                        <select class="form-select ps-1 pe-2 py-1 payment-status" aria-label="Default select example" data-id="{{ @$value['vehicle']['id'] }}" @if(@$value['vehicle']['all_paid'] == "1") style="width: 80px; border-radius: 5px; background-color: #70e790;" @else style="width: 80px; border-radius: 5px; background-color: #ffa6a6;" @endif>
                                            <option value="1" @if(@$value['vehicle']['all_paid'] == "1") selected @endif>Paid</option>
                                            <option value="0" @if(@$value['vehicle']['all_paid'] == "0") selected @endif>Unpaid</option>
                                        </select>
                                    </div>
                                </td>

                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    @php
                                        $ico = "";
                                        if (@$value['vehicle']['fuel_type'] == "EV") {
                                            $ico = "fa-solid fa-plug text-primary";
                                        } elseif (@$value['vehicle']['fuel_type'] == "HYB") {
                                            $ico = "fa-solid fa-leaf text-success";
                                        } elseif (@$value['vehicle']['fuel_type'] == "GAS") {
                                            $ico = "fa-solid fa-gas-pump text-secondary";
                                        }
                                    @endphp
                                    {{-- <i class="text-fs-5 fa-solid fa-charging-station"></i> --}}
                                    <i class="text-fs-5 {{ $ico }}"></i>
                                    {{-- <span class="fs-5 ms-1">{{ @$value['vehicle']['fuel_type'] }}</span> --}}
                                </td>

                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <select id="selectOption" class="form-select status" aria-label="Default select example" data-id="{{ @$value['vehicle']['id'] }}">
                                            @if(count(@$all_status) > 0)
                                            @foreach(@$all_status as $k => $v)
                                                @if(@$v['id'] == @$value['vehicle']['status_id'])
                                                <option value="{{ @$v['id'] }}" selected>{{ @$v['name'] }}</option>
                                                @else
                                                <option value="{{ @$v['id'] }}">{{ @$v['name'] }}</option>
                                                @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    @if(!empty(@$value['vehicle']['delivered_on_date']) && @$value['vehicle']['status_id'] == "6")
                                    @php
                                        $datetime1 = new \DateTime(@$value['vehicle']['delivered_on_date']);
                                        $datetime2 = new \DateTime(date("Y-m-d"));
                                        $interval = $datetime1->diff($datetime2);
                                    @endphp
                                    <span class="text-fs-4" style="font-size: 14px;">{{ @$interval->days }}</span>
                                    @endif
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value['id']) }}" style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        {{ @$value['vehicle']['terminal']['name'] }}
                                    </a>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <div class="border border-1 p-2 rounded-3">
                                        <p class="text-fs-3 m-0" style="font-size: 14px;">
                                            {{ @$value['vehicle']['notes'] }}
                                        </p>
                                    </div>
                                </td>
                                <td @if(@$value['vehicle']['status_id'] == '8' || @$value['vehicle']['status_id'] == '10' || @$value['vehicle']['status_id'] == '11') style="background-color: #c8f3a1 !important;" @endif>
                                    <div class="d-flex justify-content-center items-center message-icon">
                                        <i class="fa-circle-minus fa-solid fs-3 text-danger delete" data-url="{{ url('admin/vehicles/delete', @$value['vehicle']['id']) }}" style="cursor: pointer;"></i>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                <td class="text-center" colspan="14">
                                    <p>No record found</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $list['pagination'] !!}
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
                                    <button id="delete-link" type="button" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5" type="button">Ok</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-warning border-0 mt-4 col-md-12 rounded-3 fs-5"
                                        data-bs-dismiss="modal" type="button">Cancel</button>
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

            $("select.option-select").each(function () {
                updateBackgroundColor(this);
            });

            $(document).on("change", ".status", function () {
                var form = new FormData();
                form.append("status", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-vehicle-data") }}',
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    success: function(data){
                        data = JSON.parse(data);
                        if (data.success == true) {
                            toastr["success"]("Vehicle data updated successfully!", "Completed!");
                        }
                    }
                });
            });

            $(document).on("change", ".payment-status", function () {
                if ($(this).find("option:selected").val() == "0") {
                    $(this).css("background-color", "#ffa6a6");
                } else if ($(this).find("option:selected").val() == "1") {
                    $(this).css("background-color", "#70e790");
                }
                var form = new FormData();
                form.append("payment_status", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-vehicle-data") }}',
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    success: function(data){
                        data = JSON.parse(data);
                        if (data.success == true) {
                            toastr["success"]("Vehicle data updated successfully!", "Completed!");
                        }
                    }
                });
            });

            $(document).on("change", ".destination_port", function () {
                var form = new FormData();
                form.append("destination_port", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-vehicle-data") }}',
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    success: function(data){
                        data = JSON.parse(data);
                        if (data.success == true) {
                            toastr["success"]("Vehicle data updated successfully!", "Completed!");
                        }
                    }
                });
            });

            $(document).on("change", ".title", function () {
                if ($(this).find("option:selected").val() == "NO") {
                    $(this).css("background-color", "#ffa6a6");
                } else if ($(this).find("option:selected").val() == "YES") {
                    $(this).css("background-color", "#70e790");
                } else if ($(this).find("option:selected").val() == "BOS") {
                    $(this).css("background-color", "#89ceff");
                } else if ($(this).find("option:selected").val() == "TBO") {
                    $(this).css("background-color", "#edd4e4");
                }
                var form = new FormData();
                form.append("title", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-vehicle-data") }}',
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    success: function(data){
                        data = JSON.parse(data);
                        if (data.success == true) {
                            toastr["success"]("Vehicle data updated successfully!", "Completed!");
                        }
                    }
                });
            });

            $(document).on("change", ".keys", function () {
                if ($(this).find("option:selected").val() == "NO") {
                    $(this).css("background-color", "#ffa6a6");
                } else if ($(this).find("option:selected").val() == "YES") {
                    $(this).css("background-color", "#70e790");
                }
                var form = new FormData();
                form.append("keys", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-vehicle-data") }}',
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    success: function(data){
                        data = JSON.parse(data);
                        if (data.success == true) {
                            toastr["success"]("Vehicle data updated successfully!", "Completed!");
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
            $(document).on("change", "#buyer, #terminal, #status, #at_terminal, #destination, #search-veh, #pay_status, #fuel_type", function () {
                $("#filters-form").submit();
                $(".filter").attr("disabled", true);
            });
            $(document).on("click", "#search-btn", function () {
                $("#filters-form").submit();
                $(".filter").attr("disabled", true);
            });
            $(document).on("click", ".paginate", function () {
                $(this).attr('disabled', true);
                if ($(this).attr('data-href') !== "0") {
                    window.location.href = $(this).attr('data-href');
                    $(this).attr('data-href', '0');
                }
            });
            $(document).on("click", ".delete", function () {
                $("#delete-link").attr("data-url", $(this).attr('data-url'));
                $("#removeRowModal").modal("show");
            });
            $(document).on("click", ".page-link", function () {
                $(".page-item").addClass("disabled");
                $(".page-link").attr("aria-disabled", true);
            });
            $(document).on("click", "#delete-link", function () {
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('data-url'),
                    success: function(data){
                        data = JSON.parse(data);
                        if (data.success == true) {
                            $("#removeRowModal").modal("hide");
                            toastr["success"]("Vehicle deleted successfully!", "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        }
                    }
                });
            });
        });
    </script>

@endsection