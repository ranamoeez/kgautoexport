@extends('layouts.admin')

@section('title')
    Vehicles
@endsection

@section('content')

    <style type="text/css">
        a:hover {
            color: #023e8a !important;
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
                <div class="col-md-2">
                    <label for="buyer" class="fw-semibold">Buyer</label>
                    <select id="buyer" name="buyer" class="selectjs form-select p-2 border border-gray-200 rounded-lg">
                        <option value="all">All</option>
                        @if(count(@$all_buyer) > 0)
                        @foreach(@$all_buyer as $key => $value)
                            @if($value->id == @$buyer)
                            <option value="{{ @$value->id }}" selected>{{ $value->surname }}</option>
                            @else
                            <option value="{{ @$value->id }}">{{ @$value->surname }}</option>
                            @endif
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="terminal" class="fw-semibold">Terminal</label>
                    <select id="terminal" name="terminal" class="selectjs form-select p-2">
                        <option value="all">All</option>
                        @if(count(@$all_terminal) > 0)
                        @foreach(@$all_terminal as $key => $value)
                            @if($value['id'] == @$terminal)
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

                <div class="col-md-2">
                    <label for="search" class="fw-semibold">Search</label>
                    <input type="text" class="form-control p-2" name="search" value="{{ @$search }}" id="search-veh" placeholder="Search">
                </div>

                <div class="col-md-2">
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

                <div class="col-md-2">
                    <label for="pay_status" class="fw-semibold">Payment Status</label>
                    <select id="pay_status" name="pay_status" class="selectjs form-select p-2">
                        <option value="all" @if(@$paystatus == "all") selected @endif>All</option>
                        <option value="1" @if(@$pay_status == "1") selected @endif>Paid</option>
                        <option value="0" @if(@$pay_status == "0") selected @endif>Unpaid</option>
                    </select>
                </div>
            </form>

            <div>
                <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">

                    <div class="d-flex gap-2 align-items-center page-icon">
                        @php
                            $prev = (int)$page - 1;
                            $next = (int)$page + 1;
                            $prev_params = ['page='.$prev];
                            $next_params = ['page='.$next];
                            if (!empty(@$buyer)) {
                                array_push($prev_params, 'buyer='.$buyer);
                                array_push($next_params, 'buyer='.$buyer);
                            }
                            if (!empty(@$terminal)) {
                                array_push($prev_params, 'terminal='.$terminal);
                                array_push($next_params, 'terminal='.$terminal);
                            }
                            if (!empty(@$status)) {
                                array_push($prev_params, 'status='.$status);
                                array_push($next_params, 'status='.$status);
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
                        <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/vehicles?'.$pre) }}" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </a>
                        <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                        <a class="btn" @if(count($list) < 20) href="javascript:void();" @else href="{{ url('admin/vehicles?'.$nex) }}" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-fs-4">
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
                            <th scope="col" class="fw-bold">Price</th>
                            <th scope="col" class="fw-bold">Status</th>
                            <th scope="col" class="fw-bold">Terminal</th>
                            <th scope="col" class="fw-bold">Notes</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @if(count($list) > 0)
                            @foreach($list as $key => $value)
                            <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="d-flex flex-column justify-content-center">
                                        @if(!empty(@$value->vehicle->vehicle_documents))
                                            @if(count(@$value->vehicle->vehicle_documents) > 0)
                                            <a href="javascript:void();" class="text-link text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->vehicle->delivery_date }}
                                    </a>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->vehicle->company_name.' '.@$value->vehicle->name.' '.@$value->vehicle->modal }}
                                    </a>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->vehicle->vin }}
                                    </a>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->vehicle->buyer->surname }}
                                    </a>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->vehicle->client_name }}
                                    </a>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4 p-1 rounded-pill shadow">
                                        <span class="text-fs-4 ms-1" style="font-size: 14px;">{{ @$value->vehicle->destination_port->name }}</span>
                                    </div>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1 title" style="background-position: right; min-width: 50px;" aria-label="Default select example" data-id="{{ @$value->vehicle->id }}">
                                            <option value="1" data-color="danger" @if(@$value->vehicle->title == "1") selected @endif>No</option>
                                            <option value="2" data-color="info" @if(@$value->vehicle->title == "2") selected @endif>Yes</option>
                                            <option value="3" data-color="success" @if(@$value->vehicle->title == "3") selected @endif>BOS</option>
                                            <option value="4" data-color="warning" @if(@$value->vehicle->title == "4") selected @endif>TBO</option>
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1 keys" style="background-position: right; min-width: 50px" aria-label="Default select example" data-id="{{ @$value->vehicle->id }}">
                                            <option value="1" data-color="danger" @if(@$value->vehicle->keys == "1") selected @endif>No</option>
                                            <option value="2" data-color="info" @if(@$value->vehicle->keys == "2") selected @endif>Yes</option>
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4">
                                        <span style="font-size: 16px;">{{ (!empty(@$value->vehicle->auction_price)) ? @$value->vehicle->auction_price : '0.00' }}$</span>
                                    </div>
                                </td>

                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4">
                                        <select id="selectOption" class="form-select status" aria-label="Default select example" data-id="{{ @$value->vehicle->id }}">
                                            @if(count(@$all_status) > 0)
                                            @foreach(@$all_status as $k => $v)
                                                @if(@$v['id'] == @$value->vehicle->status_id)
                                                <option value="{{ @$v['id'] }}" selected>{{ @$v['name'] }}</option>
                                                @else
                                                <option value="{{ @$v['id'] }}">{{ @$v['name'] }}</option>
                                                @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <a href="{{ url('admin/vehicles/edit', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->vehicle->terminal->name }}
                                    </a>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="border border-1 p-2 rounded-3">
                                        <p class="text-fs-3 m-0">
                                            {{ @$value->vehicle->notes }}
                                        </p>
                                    </div>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="d-flex justify-content-center items-center message-icon">
                                        <i class="fa-circle-minus fa-solid fs-3 text-danger delete" data-url="{{ url('admin/vehicles/delete', @$value->vehicle->id) }}" style="cursor: pointer;"></i>
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

            $(document).on("change", ".title", function () {
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
            $(document).on("change", "#buyer, #terminal, #status, #destination, #search-veh, #pay_status", function () {
                $("#filters-form").submit();
            });
            $(document).on("click", ".delete", function () {
                $("#delete-link").attr("data-url", $(this).attr('data-url'));
                $("#removeRowModal").modal("show");
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
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
    </script>

@endsection