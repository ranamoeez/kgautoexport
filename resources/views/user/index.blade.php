@extends('layouts.user')

@section('content')

    <style type="text/css">
        table th {
            font-weight: bold !important;
        }
    </style>

    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div>
                <div class="row">
                    <div class="col-md mb-2 mb-md-0">
                        <div class="card border-0 shadow-lg h-100">
                            <a href="{{ url('user/vehicles') }}?status=6" class="card-body p-5 d-flex flex-row" style="text-decoration: none;">
                                <div class="me-3 rounded-circle home-card-icons bg-primary p-3">
                                    <img src="{{ asset('assets/at_terminal.png') }}" alt="car" class="" />
                                </div>
                                <div class="align-self-center">
                                    <h2 class="card-subtitle fw-bold">{{ @$at_terminal_vehicles }}</h2>
                                    <p class="card-text">At Terminal</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md mb-2 mb-md-0">
                        <div class="card border-0 shadow-lg h-100">
                            <a href="{{ url('user/vehicles') }}?status=10" class="card-body p-5 d-flex flex-row" style="text-decoration: none;">
                                <div class="me-3 rounded-circle home-card-icons bg-primary p-3">
                                    <img src="{{ asset('assets/cargo-ship (2).png') }}" alt="car" class="" />
                                </div>
                                <div class="align-self-center">
                                    <h2 class="card-subtitle fw-bold">{{ @$shipped_vehicles }}</h2>
                                    <p class="card-text">Shipped</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md mb-2 mb-md-0">
                        <div class="card border-0 shadow-lg h-100">
                            <a href="{{ url('user/vehicles') }}?status=11" class="card-body p-5 d-flex flex-row"  style="text-decoration: none;">
                                <div class="me-3 rounded-circle home-card-icons bg-primary p-3">
                                    <img src="{{ asset('assets/check-circle.svg') }}" alt="car" class="" />
                                </div>
                                <div class="align-self-center">
                                    <h2 class="card-subtitle fw-bold">{{ @$delivered_vehicles }}</h2>
                                    <p class="card-text">Delivered</p>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="px-14 mt-32">
                <div class="d-flex justify-content-between mt-3">
                    <h4 class="fw-bold fs-md-13 fs-lg-25">
                        New Vehicles added to the account
                    </h4>
                    <a href="{{ url('user/vehicles') }}" class="vehicle-icon fw-bold fs-md-13 fs-lg-25">Vehicles list
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3.5" stroke="currentColor" class="w-3 h-3  fs-md-13">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-fs-4">
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
                            @if(!empty(@$latest) > 0)
                            @foreach(@$latest as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td style="text-align: left !important;">
                                    <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        @if(@$value->vehicle->delivery_date && @$value->vehicle->delivery_date !== "0000-00-00") {{ date("M d, Y", strtotime(@$value->vehicle->delivery_date)) }} @endif
                                    </a>
                                </td>
                                <td style="text-align: left !important;">
                                    <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->vehicle->modal.' '.@$value->vehicle->company_name.' '.@$value->vehicle->name }}
                                    </a>
                                </td>
                                <td style="text-align: left !important;">
                                    <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        <i class="fa-solid fa-camera" style="font-size: 16px; margin-right: 5px;"></i> {{ @$value->vehicle->vin }}
                                    </a>
                                </td>
                                <td style="text-align: left !important;">
                                    <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold text-fs-4">
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
                                        <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="text-fs-4">
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
                                <td>
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
                                    <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold text-fs-4">
                                        {{ @$value->vehicle->terminal->name }}
                                    </a>
                                </td>
                                <td style="text-align: left !important;">
                                    <div class="flex items-center justify-center flex-col comment"
                                        style="width:250px; border-radius:3px">
                                        <div class="border border-1 d-flex flex-column align-items-end">
                                            <p class="text-fs-3 p-3" style="float: left;">
                                                {{ @$value->vehicle->notes_user }}
                                            </p>
                                            <button class="btn btn-sm btn-primary comment-btn fs-6 border-0"
                                                data-bs-toggle="modal" data-bs-target="#fullNoteModel_{{ $key }}">
                                                Full Note
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="fullNoteModel_{{ $key }}" tabindex="-1"
                                                aria-labelledby="fullNoteModelLabel" aria-hidden="true">
                                                <div class="modal-dialog rounded-5">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-header border-0">
                                                            <h1 class="modal-title fw-bold" id="fullNoteModelLabel" style="font-size: 28px">
                                                                Note</h1>
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
                                    <div class="rounded-circle bg-primary p-1 user-icon" data-bs-toggle="modal"
                                        data-bs-target="#sendUserModel_{{ $key }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
                                @endif
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

                @if(\Auth::user()->role == "2")
                <div class="mt-5 row">
                    <div class="col-md  mb-4 mb-md-0">

                        <!-- Due payment limit -->
                        <div class="chart">
                            <div class="d-flex justify-content-between mb-3 ">
                                <h3 class="fw-bold fs-md-13 fs-lg-25">
                                    Due Payments Limit
                                </h3>
                                <a href="{{ url('user/financial') }}" class="vehicle-icon fw-bold fs-md-13 fs-lg-25">Financial
                                    Section
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3.5" stroke="currentColor" class="w-3 h-3 fs-md-13 ">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>

                            <div class="p-3 row shadow-lg d-flex due-payment-chart">
                                <div class="col-md d-flex justify-content-center flex-column">
                                    <h4 class="fw-bold text-fs-4">
                                        Due Payments Limit
                                    </h4>
                                    <p class="text-fs-3 mt-4">Spend: ${{ number_format(@$spend) }} / ${{ number_format(@$user->user_level->due_payment_limit) }}</p>
                                </div>
                                <div class="col-md">
                                    <canvas style="width: 100%; max-width: 213px" id="myChart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md mb-4 mb-md-0">
                        <!-- Pick Up Request -->
                        <div class="request-chart ml-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h3 class="fw-bold fs-md-13 fs-lg-25">
                                    Pickup Requests
                                </h3>
                                <a href="{{ url('user/vehicles') }}"
                                    class="vehicle-icon fw-bold fs-md-13 fs-lg-25">Vehicles
                                    list
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3.5" stroke="currentColor" class="w-3 h-3 fs-md-13">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>

                            <div class="shadow-lg overflow-hidden request-pickup-chart">
                                <form method="POST" action="{{ url("user/add-pickup-request") }}" class="form d-flex justify-content-between flex-column flex-md-row">
                                    <div class="m-3">
                                        <h4 class="fw-bold text-fs-4 mt-4">Vehicle</h4>
                                        <div class="rounded-2 shadow-lg w-100 mb-2">
                                            <select class="selectjs form-select" aria-label="Default select example" name="vehicle_id">
                                                <option value="0" selected>Choose Vehicles</option>
                                                @if(count(@$vehicles) > 0)
                                                @foreach(@$vehicles as $key => $value)
                                                    <option value="{{ @$value->vehicle_id }}">{{ @$value->vehicle->modal." ".@$value->vehicle->company_name." ".@$value->vehicle->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <h4 class="fw-bold text-fs-4">Comment</h4>
                                        <input type="text" class="border border-1 mb-4 p-2 rounded-2 shadow w-100 text-fs-3" name="comments" placeholder="Your Comment Here" />
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <label for="file-upload">
                                            <img style="cursor: pointer" src="{{ asset('assets/file_img.png') }}"
                                                alt="icon" />
                                            <input type="file" id="file-upload" name="file" style="display: none;">
                                        </label>
                                    </div>
                                    <button class="bg-primary absolute p-3 border-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </button>

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
                                                            <h5 class="card-title fw-bold fs-2">Pick up
                                                                Requested <span>Successfully</span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
        // chart js
        var xValues = ["Due", "Limit"];
        var yValues = [{{ @$spend }}, {{ (int)@$user->user_level->due_payment_limit - (int)@$spend }}];
        var barColors = ["#F9D46C", "#F3F3F3"];

        new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                },],
            },
            options: {
                title: {
                    display: true,
                    text: "due",
                },
            },
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');

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
        $(".alert").show().delay(5000).queue(function (n) {
            $(this).hide(); n();
        });
    </script>

@endsection