@extends('layouts.admin')

@section('title')
    Containers
@endsection

@section('content')
    
    <style type="text/css">
        a:hover {
            color: #023e8a !important;
        }
        .select2.select2-container {
            width: 100% !important;
        }
    </style>
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    My Conatiner List
                </h4>
            </div>

            <form method="GET" action="{{ url('admin/containers') }}" class="row align-items-center" id="filters-form">
                <input type="hidden" name="page" value="{{ @$page }}">
                <div class="col-md-3 mb-2">
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

                <div class="col-md-3 mb-2">
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

                <div class="col-md-3 mb-2">
                    <label for="Date" class="fw-semibold">Date</label>
                    <div class="d-flex gap-4 align-items-center">
                        <div class="d-flex align-items-center">
                            <input type="date" id="fromDate" name="fromDate" value="{{ @$fromDate }}" class="form-control" style="width: 150px;">
                            <span class="mx-2">To</span>
                            <input type="date" class="form-control mx-2" name="toDate" value="{{ @$toDate }}" id="toDate" style="width: 150px;">
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="pay_status" class="fw-semibold">Payment Status</label>
                    <select id="pay_status" name="pay_status" class="selectjs form-select p-2">
                        <option value="all" @if(@$pay_status == "all") selected @endif>All</option>
                        <option value="1" @if(@$pay_status == "1") selected @endif>Paid</option>
                        <option value="0" @if(@$pay_status == "0") selected @endif>Unpaid</option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="released_status" class="fw-semibold">Released Status</label>
                    <select id="released_status" name="released_status" class="selectjs form-select p-2">
                        <option value="all" @if(@$released_status == "all") selected @endif>All</option>
                        <option value="No" @if(@$released_status == "No") selected @endif>No</option>
                        <option value="In hand" @if(@$released_status == "In hand") selected @endif>In hand</option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="unloaded_status" class="fw-semibold">Unloaded Status</label>
                    <select id="unloaded_status" name="unloaded_status" class="selectjs form-select p-2">
                        <option value="all" @if(@$unloaded_status == "all") selected @endif>All</option>
                        <option value="No" @if(@$unloaded_status == "No") selected @endif>No</option>
                        <option value="Yes" @if(@$unloaded_status == "Yes") selected @endif>Yes</option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="search" class="fw-semibold">Search</label>
                    <input type="text" class="form-control p-2" placeholder="Search" name="search" value="{{ @$search }}" id="search-cont">
                </div>
            </form>


            <div class="">
                <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">

                    <div class="d-flex gap-2 align-items-center page-icon">
                        @php
                            $prev = (int)$page - 1;
                            $next = (int)$page + 1;
                            $prev_params = ['page='.$prev];
                            $next_params = ['page='.$next];
                            if (!empty(@$port)) {
                                array_push($prev_params, 'port='.$port);
                                array_push($next_params, 'port='.$port);
                            }
                            if (!empty(@$status)) {
                                array_push($prev_params, 'status='.$status);
                                array_push($next_params, 'status='.$status);
                            }
                            if (!empty(@$search)) {
                                array_push($prev_params, 'search='.$search);
                                array_push($next_params, 'search='.$search);
                            }
                            if (!empty(@$toDate)) {
                                array_push($prev_params, 'toDate='.$toDate);
                                array_push($next_params, 'toDate='.$toDate);
                            }
                            if (!empty(@$fromDate)) {
                                array_push($prev_params, 'fromDate='.$fromDate);
                                array_push($next_params, 'fromDate='.$fromDate);
                            }
                            if (!empty(@$pay_status)) {
                                array_push($prev_params, 'pay_status='.$pay_status);
                                array_push($next_params, 'pay_status='.$pay_status);
                            }
                            if (!empty(@$released_status)) {
                                array_push($prev_params, 'released_status='.$released_status);
                                array_push($next_params, 'released_status='.$released_status);
                            }
                            if (!empty(@$unloaded_status)) {
                                array_push($prev_params, 'unloaded_status='.$unloaded_status);
                                array_push($next_params, 'unloaded_status='.$unloaded_status);
                            }
                            $pre = join("&", $prev_params);
                            $nex = join("&", $next_params);
                        @endphp
                        <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/containers?'.$pre) }}" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </a>
                        <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                        <a class="btn" @if(count($list) < 20) href="javascript:void();" @else href="{{ url('admin/containers?'.$nex) }}" @endif>
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
                        <thead class="text-fs-4" style="font-size: 16px;">
                            <th scope="col" class="fw-bold">Number</th>
                            <th scope="col" class="fw-bold">Details</th>
                            <th scope="col" class="fw-bold">Shipping line</th>
                            <th scope="col" class="fw-bold">Dates</th>
                            <th scope="col" class="fw-bold">Status</th>
                            <th scope="col" class="fw-bold">P. Status</th>
                            <th scope="col" class="fw-bold">Released Status</th>
                            <th scope="col" class="fw-bold">Unloaded Status</th>
                            <th scope="col" class="fw-bold">Tracking</th>
                            <th scope="col" class="fw-bold"></th>
                        </thead>
                        <tbody>
                            @if(count($list) > 0)
                            @foreach($list as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <a @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.2", json_decode(\Auth::user()->access))) href="{{ url('admin/containers/edit', $value->id) }}" @else href="javascript:void;" @endif style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-bold mb-2 text-fs-3">
                                        Booking : {{ $value->booking_no }}
                                    </a>
                                    <br>
                                    <a @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.2", json_decode(\Auth::user()->access))) href="{{ url('admin/containers/edit', $value->id) }}" @else href="javascript:void;" @endif style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-bold mb-2 text-fs-3">
                                        Container : {{ $value->container_no }}
                                    </a>
                                    <br>
                                    <a @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.2", json_decode(\Auth::user()->access))) href="{{ url('admin/containers/edit', $value->id) }}" @else href="javascript:void;" @endif style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-bold mb-2 text-fs-3">
                                        REF : {{ $value->export_reference }}
                                    </a>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <ul class="p-0 text-fs-3" style="font-size: 14px;">
                                        @if(count(@$value->buyers) > 0)
                                        @foreach(@$value->buyers as $k => $v)
                                        <span class="fw-bold">Buyer : {{ @$v->user->name }}</span>
                                        @foreach($v->vehicles as $ke => $val)
                                        <li class="list-unstyled">
                                            » <a @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.2", json_decode(\Auth::user()->access))) href="{{ url('admin/containers/edit', $value->id) }}" @else href="javascript:void;" @endif style="text-decoration: none; color: #000000;">{{ @$val->vehicle->modal.' '.@$val->vehicle->company_name.' '.@$val->vehicle->name.', VIN: '.@$val->vehicle->vin }}</a>
                                        </li>
                                        @endforeach
                                        @endforeach
                                        @endif
                                    </ul>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <a @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.2", json_decode(\Auth::user()->access))) href="{{ url('admin/containers/edit', $value->id) }}" @else href="javascript:void;" @endif style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        {{ @$value->shipping_line->name }}
                                    </a>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <a @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.2", json_decode(\Auth::user()->access))) href="{{ url('admin/containers/edit', $value->id) }}" @else href="javascript:void;" @endif style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        Departure : @if(@$value->departure && @$value->departure !== "0000-00-00") {{ date("M d, Y", strtotime(@$value->departure)) }} @endif
                                    </a>
                                    <br>
                                    <a @if(empty(\Auth::user()->access) || \Auth::user()->access == 'all' || @in_array("2.2", json_decode(\Auth::user()->access))) href="{{ url('admin/containers/edit', $value->id) }}" @else href="javascript:void;" @endif style="text-decoration: none; color: #000000; font-size: 14px;" class="fw-medium text-fs-3">
                                        Arrival : @if(@$value->arrival && @$value->arrival !== "0000-00-00") {{ date("M d, Y", strtotime(@$value->arrival)) }} @endif
                                    </a>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <select class="form-select status" aria-label="Default select example" data-id="{{ @$value->id }}" @if($value->status_id == "2") style="background-color: #edd4e4;" @elseif($value->status_id == "4") style="background-color: #70e790;" @elseif($value->status_id == "3") style="background-color: #89ceff;" @else style="background-color: #ffa6a6;" @endif>
                                            @if(count(@$all_status) > 0)
                                            @foreach(@$all_status as $k => $v)
                                                @if($value->status_id == @$v['id'])
                                                <option value="{{ @$v['id'] }}" selected>{{ $v['name'] }}</option>
                                                @else
                                                <option value="{{ @$v['id'] }}">{{ @$v['name'] }}</option>
                                                @endif
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <select class="form-select payment_status" aria-label="Default select example" data-id="{{ $value->id }}" @if(@$value->all_paid == "1") style="width: 100px; border-radius: 5px; background-color: #70e790;" @else style="width: 100px; border-radius: 5px; background-color: #ffa6a6;" @endif>
                                            <option value="1" @if(@$value->all_paid == "1") selected @endif>Paid</option>
                                            <option value="0" @if(@$value->all_paid == "0") selected @endif>Unpaid</option>
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-fs-4" style="font-size: 14px;">
                                        <select class="form-select released_status" aria-label="Default select example" data-id="{{ $value->id }}" @if(@$value->released_status == "No") style="width: 100px; background-color: #ffa6a6;" @else style="width: 100px; background-color: #70e790;" @endif>
                                            <option value="No" @if(@$value->released_status == "No") selected @endif>No</option>
                                            <option value="In hand" @if(@$value->released_status == "In hand") selected @endif>In hand</option>
                                        </select>
                                        @if(!empty(@$value->in_hand_date))
                                        <span class="text-fs-4 d-flex justify-content-start" style="font-size: 14px;">{{ date("M d, Y", strtotime(@$value->in_hand_date)) }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <select class="form-select unloaded_status" aria-label="Default select example" data-id="{{ $value->id }}" @if(@$value->unloaded_status == "Yes") style="width: 100px; background-color: #70e790;" @else style="width: 100px; background-color: #ffa6a6;" @endif>
                                            <option value="No" @if(@$value->unloaded_status == "No") selected @endif>No</option>
                                            <option value="Yes" @if(@$value->unloaded_status == "Yes") selected @endif>Yes</option>
                                        </select>
                                    </div>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="text-center text-fs-4" style="font-size: 14px;">
                                        <button class="btn btn-primary text-fs-4 border-0 tracking" style="font-size: 14px;" type="button" data-text="{{ @$value->shipping_line->name }}" data-id="{{ @$value->container_no }}">
                                            Tracking
                                        </button>
                                    </div>
                                </td>
                                <td @if(@$value->status_id == '4') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="d-flex justify-content-center items-center message-icon">
                                        <i class="fa-solid fa-circle-xmark fs-3 text-danger delete" data-url="{{ url('admin/containers/delete', $value->id) }}" style="cursor: pointer;"></i>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                <td class="text-center" colspan="10">
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
                            <h1 class="modal-title fw-bold" id="removeRowModalLabel"
                                style="font-size: 28px">
                                Delete this Record?</h1>
                            <button type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <button id="delete-link" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5" type="button">Ok</button>
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
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
            $(document).on("change", "#port, #status, #search-cont, #fromDate, #toDate, #pay_status, #released_status, #unloaded_status", function () {
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
                            toastr["success"]("Container deleted successfully!", "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        }
                    }
                });
            });

            $(document).on("change", ".status", function () {
                if ($(this).find("option:selected").val() == "1") {
                    $(this).css("background-color", "#ffa6a6");
                } else if ($(this).find("option:selected").val() == "4") {
                    $(this).css("background-color", "#70e790");
                } else if ($(this).find("option:selected").val() == "3") {
                    $(this).css("background-color", "#89ceff");
                } else if ($(this).find("option:selected").val() == "2") {
                    $(this).css("background-color", "#edd4e4");
                }
                var form = new FormData();
                form.append("status", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-container-data") }}',
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
                            toastr["success"]("Container data updated successfully!", "Completed!");
                        }
                    }
                });
            });

            $(document).on("change", ".payment_status", function () {
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
                    url: '{{ url("admin/update-container-data") }}',
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
                            toastr["success"]("Container data updated successfully!", "Completed!");
                        }
                    }
                });
            });

            $(document).on("change", ".released_status", function () {
                if ($(this).find("option:selected").val() == "No") {
                    $(this).css("background-color", "#ffa6a6");
                } else if ($(this).find("option:selected").val() == "In hand") {
                    $(this).css("background-color", "#70e790");
                }
                var form = new FormData();
                form.append("released_status", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-container-data") }}',
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
                            toastr["success"]("Container data updated successfully!", "Completed!");
                        }
                    }
                });
            });

            $(document).on("change", ".unloaded_status", function () {
                if ($(this).find("option:selected").val() == "No") {
                    $(this).css("background-color", "#ffa6a6");
                } else if ($(this).find("option:selected").val() == "Yes") {
                    $(this).css("background-color", "#70e790");
                }
                var form = new FormData();
                form.append("unloaded_status", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-container-data") }}',
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
                            toastr["success"]("Container data updated successfully!", "Completed!");
                        }
                    }
                });
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

@endsection