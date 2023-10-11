@extends('layouts.admin')

@section('title')
    Pickup History
@endsection

@section('content')

    <style type="text/css">
        a:hover {
            color: #023e8a !important;
        }
        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {  
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)} 
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)} 
            to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }
    </style>
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Pickup History
                </h4>
            </div>

            <form method="GET" action="{{ url('admin/pickup-history') }}" class="row align-items-center" id="filters-form">
                <input type="hidden" name="page" value="{{ @$page }}">
                <div class="col-md-2">
                    <label for="buyer" class="fw-semibold">Buyer</label>
                    <select id="buyer" name="buyer" class="selectjs form-select p-2 border border-gray-200 rounded-lg">
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
                            @if($value['id'] == @$destination)
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
                        <option value="all" @if(@$status == "all") selected @endif>All</option>
                        <option value="waiting" @if(@$status == "waiting") selected @endif>Waiting</option>
                        <option value="approved" @if(@$status == "approved") selected @endif>Approved</option>
                        <option value="rejected" @if(@$status == "rejected") selected @endif>Rejected</option>
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
                            if (!empty(@$search)) {
                                array_push($prev_params, 'search='.$search);
                                array_push($next_params, 'search='.$search);
                            }
                            if (!empty(@$destination)) {
                                array_push($prev_params, 'destination='.$destination);
                                array_push($next_params, 'destination='.$destination);
                            }
                            if (!empty(@$status)) {
                                array_push($prev_params, 'status='.$status);
                                array_push($next_params, 'status='.$status);
                            }
                            $pre = join("&", $prev_params);
                            $nex = join("&", $next_params);
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
                            <th scope="col" class="fw-bold">Image</th>
                            <th scope="col" class="fw-bold">Picker Name</th>
                            <th scope="col" class="fw-bold">Buyer</th>
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Destination</th>
                            <th scope="col" class="fw-bold">Date</th>
                            <th scope="col" class="fw-bold">Due Payments</th>
                            <th scope="col" class="fw-bold">Balance</th>
                            @if(empty($auth_user->admin_level->access) || @in_array("6.2", json_decode($auth_user->admin_level->access)))
                            <th scope="col" class="fw-bold">Updated By</th>
                            <th scope="col" class="fw-bold">Status</th>
                            @endif
                        </thead>
                        <tbody>
                            @if(count(@$list) > 0)
                            @foreach(@$list as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td>
                                    <p class="text-fs-3">
                                        {{ @$value->id }}
                                    </p>
                                </td>
                                <td>
                                    @if(!empty(@$value->file))
                                        <img src="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ @$value->file }}" style="width: 100px; height: 100px; cursor: pointer;" class="rounded-4 myImg">
                                    @else
                                    <p class="text-fs-3">
                                        N / A
                                    </p>
                                    @endif
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->comments }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->vehicle->buyer->surname }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->vehicle->vin }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->vehicle->destination_port->name }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        @if(@$value->created_at) {{ date("M d, Y", strtotime(@$value->created_at)) }} @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="text-fs-3">
                                        ${{ @$value->due_payments }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-fs-3">
                                        ${{ @$value->balance }}
                                    </p>
                                </td>
                                @if(empty($auth_user->admin_level->access) || @in_array("6.2", json_decode($auth_user->admin_level->access)))
                                <td>
                                    <p class="text-fs-3">
                                        {{ @$value->admin->surname }}
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
            </div>
            <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
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
            // Get the modal
            var modal = document.getElementById("myModal");

            $(".myImg").click(function () {
                $("#myModal").css("display", "block");
                $("#img01").attr("src", $(this).attr("src"));
            });

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() { 
                modal.style.display = "none";
            }

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

            $(document).on("change", "#buyer, #destination, #search-veh, #pay_status", function () {
                $("#filters-form").submit();
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
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
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