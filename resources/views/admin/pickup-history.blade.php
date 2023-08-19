@extends('layouts.admin')

@section('title')
    Pickup History
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
                    Pickup History
                </h4>
            </div>

            <div class="row align-items-center">
                <div class="col-md-2">
                    <label for="Buyer" class="fw-semibold">Buyer</label>
                    <select id="Buyer" name="Buyer"
                        class="selectjs form-select p-2 border border-gray-200 rounded-lg">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="Terminal" class="fw-semibold">Terminal</label>
                    <select id="Terminal" name="Terminal" class="selectjs form-select p-2">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="Status" class="fw-semibold">Status</label>
                    <select id="Status" name="Status" class="selectjs form-select p-2">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="search" class="fw-semibold">Search</label>
                    <input type="text" class="form-control p-2" placeholder="search">
                </div>

                <div class="col-md-2">
                    <label for="Status" class="fw-semibold">Destination</label>
                    <select id="Status" name="Status" class="selectjs form-select p-2">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">Only unpaid</label>
                    </div>
                </div>
            </div>


            <div>
                <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">

                    <div class="d-flex gap-2 align-items-center page-icon">
                        @php
                            $prev = (int)$page - 1;
                            $next = (int)$page + 1;
                            $pre = 'page='.$prev;
                            $nex = 'page='.$next;
                        @endphp
                        <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/pickup-history?'.$pre) }}" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </a>
                        <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                        <a class="btn" @if(count($list) < 10) href="javascript:void();" @else href="{{ url('admin/pickup-history?'.$nex) }}" @endif>
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
                            <th scope="col" class="fw-bold">ID</th>
                            <th scope="col" class="fw-bold">Client</th>
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Location</th>
                            <th scope="col" class="fw-bold">Date</th>
                            <th scope="col" class="fw-bold">Payment</th>
                            <th scope="col" class="fw-bold">Balance</th>
                            <th scope="col" class="fw-bold">Status</th>
                        </thead>
                        <tbody>
                            @if(count(@$list) > 0)
                            @foreach(@$list as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->id }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->vehicle->client_name }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->vehicle->vin }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->vehicle->location }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->created_at }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        
                                    </p>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1 status" style="background-position: right; min-width: 50px" aria-label="Default select example" data-id="{{ @$value->id }}">
                                            <option value="waiting" data-color="warning" @if(@$value->status == "waiting") selected @endif>Waiting</option>
                                            <option value="approved" data-color="success" @if(@$value->status == "approved") selected @endif>Approved</option>
                                            <option value="rejected" data-color="danger" @if(@$value->status == "rejected") selected @endif>Rejected</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
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
                    url: '{{ url("admin/update-pickup-data") }}',
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
                            toastr["success"]("Pickup history updated successfully!", "Completed!");
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
            $(document).on("change", "#buyer, #terminal, #status, #destination, #search-veh, #unpaid", function () {
                $("#filters-form").submit();
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