@extends('layouts.admin')

@section('title')
    Containers
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
                    My Conatiner List
                </h4>
            </div>

            <form method="GET" action="{{ url('admin/containers') }}" class="row align-items-center" id="filters-form">
                <input type="hidden" name="page" value="{{ @$page }}">
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
                    <label for="Date" class="fw-semibold">Date</label>
                    <div class="d-flex gap-4 align-items-center">
                        <div class="d-flex align-items-center">
                            <input type="date" id="fromDate" name="fromDate" value="{{ @$fromDate }}" class="form-control" style="width: 150px;">
                            <span class="mx-2">To</span>
                            <input type="date" class="form-control mx-2" name="toDate" value="{{ @$toDate }}" id="toDate" style="width: 150px;">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="unpaid" name="unpaid" id="unpaid" @if(@$unpaid == "unpaid") checked @endif>
                            <label class="form-check-label" for="unpaid">Only unpaid</label>
                        </div>
                    </div>
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
                            if (!empty(@$unpaid)) {
                                array_push($prev_params, 'unpaid='.$unpaid);
                                array_push($next_params, 'unpaid='.$unpaid);
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
                        <thead class="text-fs-4">
                            <th scope="col" class="fw-bold">Number</th>
                            <th scope="col" class="fw-bold">Details</th>
                            <th scope="col" class="fw-bold">Shipping line</th>
                            <th scope="col" class="fw-bold">Dates</th>
                            <th scope="col" class="fw-bold">Status</th>
                            <th scope="col" class="fw-bold">P. Status</th>
                            <th scope="col" class="fw-bold">Tracking</th>
                            <th scope="col" class="fw-bold"></th>
                        </thead>
                        <tbody>
                            @if(count($list) > 0)
                            @foreach($list as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td>
                                    <span class="fw-bold mb-2 text-fs-3">
                                        Booking : {{ $value->booking_no }}
                                    </span>
                                    <br>
                                    <span class="fw-bold mb-2 text-fs-3">
                                        Container : {{ $value->container_no }}
                                    </span>
                                    <br>
                                    <span class="fw-bold mb-2 text-fs-3">
                                        REF : {{ $value->export_reference }}
                                    </span>
                                </td>
                                <td>
                                    <ul class="p-0 text-fs-3">
                                        <span class="fw-bold">Buyer : Mohammad Alani</span>
                                        <li class="list-unstyled">
                                            » Toyota Land cruiser LC300
                                        </li>
                                        <li class="list-unstyled">
                                            » Toyota Land cruiser LC300
                                        </li>
                                        <span class="fw-bold">Buyer : Karam Alani</span>
                                        <li class="list-unstyled">
                                            » Toyota Land cruiser LC300
                                        </li>
                                        <li class="list-unstyled">
                                            » Toyota Land cruiser LC300
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ url('admin/containers/edit', $value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                        {{ @$value->shipping_line->name }}
                                    </a>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Departure : {{ $value->departure }}
                                    </span>
                                    <br>
                                    <span class="fw-medium text-fs-3">
                                        Arrival : {{ $value->arrival }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white status" aria-label="Default select example" data-id="{{ $value->id }}">
                                            @if(count(@$all_status) > 0)
                                            @foreach(@$all_status as $k => $v)
                                                @if($value['status_id'] == @$v['id'])
                                                <option value="{{ @$v['id'] }}" @if($v['name'] == "Delivered") data-color="success" @else data-color="danger" @endif selected>{{ $v['name'] }}</option>
                                                @else
                                                <option value="{{ @$v['id'] }}" @if($v['name'] == "Delivered") data-color="success" @else data-color="danger" @endif>{{ @$v['name'] }}</option>
                                                @endif
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white payment_status" aria-label="Default select example" data-id="{{ $value->id }}">
                                            <option value="1" data-color="success" @if(@$value->all_paid == "1") selected @endif>Paid</option>
                                            <option value="0" data-color="danger" @if(@$value->all_paid == "0") selected @endif>Unpaid</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <button class="btn btn-primary text-fs-4 border-0">
                                            Tracking
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center items-center message-icon">
                                        <i class="fa-solid fa-circle-xmark fs-3 text-danger delete" data-url="{{ url('admin/containers/delete', $value->id) }}" style="cursor: pointer;"></i>
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
                                    <form method="GET" action="" class="make_ajax delete-container">
                                    </form>
                                    <a href="#" id="delete-link" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5">Ok</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#"
                                        class="btn btn-warning border-0 mt-4 col-md-12 rounded-3 fs-5"
                                        data-bs-dismiss="modal">Cancel</a>
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
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
            $(document).on("change", "#port, #status, #search-cont, #fromDate, #toDate, #unpaid", function () {
                $("#filters-form").submit();
            });
            $(document).on("click", ".delete", function () {
                $(".delete-container").attr("action", $(this).attr('data-url'));
                $("#removeRowModal").modal("show");
            });
            $(document).on("click", "#delete-link", function () {
                $(".delete-container").submit();
                $("#removeRowModal").modal("hide");
                setTimeout(function () {
                    location.reload();
                }, 4000);
            });

            $(document).on("change", ".status", function () {
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