@extends('layouts.user')

@section('content')

    <style type="text/css">
        table th {
            font-weight: bold !important;
        }
    </style>

    <!-- Modal -->
    @if(!\Session::has("success"))
    <div class="modal fade show" id="financialSheetPasswordModal" tabindex="-1"
        data-bs-backdrop="static" aria-labelledby="financialSheetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog rounded-5">
            <div class="modal-content p-3">
                <div class="modal-header border-0">
                    <h1 class="modal-title fw-bold" id="financialSheetPasswordModalLabel"
                        style="font-size: 28px">
                        Financial Sheet Password</h1>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url("user/check-password") }}" class="form">
                        <div class="row mt-4">
                            <label for="password" class="col-md-4 fs-5 fw-bold">Password</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control shadow-lg" placeholder="Password" name="sheet_password" required />
                            </div>
                        </div>
                        <button class="btn btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Proceed</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="below-header-height outer-container" @if(!\Session::has("success")) style="filter: blur(15px);" @endif>
        <div class="inner-container">

            <!-- Financial Status part -->

            <div class="card financial-card-header border border-0">
                <div class="card-body" style="margin-bottom: 100px">
                    <h3 class="text-white fw-bold fs-2">Great Job, {{ \Auth::user()->surname }}!</h3>
                    @php
                        $whole = $user->user_level->due_payment_limit;
                        $given = $due_payments;
                        $percentage = ($given / $whole) * 100;
                    @endphp
                    <h4 class="text-white px-5 text-fs-5 fw-bold">
                        Your Account Health is
                        @if($percentage < 20)
                        <span class="text-exceed">exceeding 80%</span>
                        @elseif($percentage >= 50 && $percentage < 80)
                        <span style="color: orange;">50%</span>
                        @elseif($percentage < 50)
                        <span class="text-danger">less than 40%</span>
                        @endif
                    </h4>
                    <h5 class="text-white px-5 text-fs-3">
                        To maintain a healthy account Status, ensure timely payment of
                        your bills.
                    </h5>
                </div>
            </div>

            <div style="margin-top: -100px">
                <div class="row financial-sub-card-header">
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle fs-3">Due payments</h2>
                                    <p class="card-text fw-bold mt-2 fs-2"><span>{{ number_format(@$due_payments) }}</span> $</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle fs-3">Previous payments</h2>
                                    <p class="card-text fw-bold mt-2 fs-2"><span>{{ number_format(@$previous) }}</span> $</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle fs-3">Balance</h2>
                                    <p class="card-text fw-bold mt-2 fs-2"><span>{{ number_format(@$balance) }}</span> $</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction history -->
                <div class="mt-5 d-flex justify-content-between">
                    <div class="">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                            Transaction history
                        </h4>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="financial-btn">
                            <button type="button" id="money" class="btn btn-primary border border-1 fs-6">
                                Money Transfer
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="moneyTransferModal" tabindex="-1"
                                aria-labelledby="moneyTransferModalLabel" aria-hidden="true">
                                <div class="modal-dialog rounded-5">
                                    <div class="modal-content p-3">
                                        <div class="modal-header border-0">
                                            <h1 class="modal-title fw-bold" id="moneyTransferModalLabel"
                                                style="font-size: 28px">
                                                Add Money Transfer</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ url("user/money-transfer") }}" class="form">
                                                <div class="row mt-4">
                                                    <label for="amount" class="col-md-4 fs-5 fw-bold">Amount</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="amount" class="form-control shadow" />
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <label for="vehicle_id" class="col-md-4 fs-5 fw-bold">Vehicle</label>
                                                    <div class="col-md-8">
                                                        <select class="form-select shadow select2js" aria-label="Default select example" name="vehicle_id">
                                                            <option selected>Choose vehicle</option>
                                                            @if(count(@$vehicles) > 0)
                                                            @foreach(@$vehicles as $key => $value)
                                                                <option value="{{ @$value->vehicle_id }}">{{ @$value->vehicle->company_name." ".@$value->vehicle->name." ".@$value->vehicle->modal }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <label for="exchange_company" class="col-md-4 fs-5 fw-bold">Exchange
                                                        Company</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="exchange_company" class="form-control shadow" />
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <label for="transfer_no" class="col-md-4 fs-5 fw-bold">Transfer
                                                        No.</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="transfer_no" class="form-control shadow" />
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <label for="comment" class="col-md-4 fs-5 fw-bold">Comment</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="comment" class="form-control shadow text-fs-4 rounded pb-4" />
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5 w-auto">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Assigned By -->
                <div class="d-flex justify-content-end">
                    <div class="mt-5 px-14">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">Assigned By:</h4>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fs-5 fw-bold" id="admin-tab" data-bs-toggle="tab"
                                    data-bs-target="#vehicle-cost" type="button">
                                    Vehicle Cost
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fs-5 fw-bold btn" id="super-admin-tab"
                                    data-bs-toggle="tab" data-bs-target="#transportation" type="button">
                                    Transportation
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="d-flex justify-content-between mt-3 align-items-center">
                        <h4 class="fw-bold fs-md-13 text-fs-5">
                            Transactions
                        </h4>
                        <div class="d-flex gap-2 align-items-center page-icon">
                            @php
                                $prev = (int)$page - 1;
                                $next = (int)$page + 1;
                                $pre = 'page='.$prev;
                                $nex = 'page='.$next;
                            @endphp
                            <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('user/financial?'.$pre) }}" @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </a>
                            <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                            <a class="btn" @if(count($vehicle_cost) < 10) href="javascript:void();" @else href="{{ url('user/financial?'.$nex) }}" @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="table-responsive tab-pane fade show active" data-bs-toggle="tab"
                            id="vehicle-cost">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col">VIN</th>
                                    <th scope="col">Buyer</th>
                                    <th scope="col">Total Paid</th>
                                    <th scope="col">Total Unpaid</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$vehicle_cost) > 0)
                                    @foreach(@$vehicle_cost as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ @$value->vehicle->vin }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ @$value->vehicle->buyer->surname }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3 text-success">
                                                ${{ @$value->total_paid }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3 text-danger">
                                                ${{ @$value->total_unpaid }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="@if(@$value->payment_status == "paid") btn btn-success @elseif(@$value->payment_status == "partly paid") btn btn-warning @else btn btn-danger @endif rounded-1 text-white text-fs-3 border border-0">
                                                {{ ucfirst(@$value->payment_status) }}
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center items-center message-icon">
                                                <button class="btn border-0 comment_modal" data-id="{{ @$value->vehicle_id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
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
                                        <td colspan="7">
                                            <div class="container">
                                                <div class="rounded row shadow header-shipment">
                                                    <div class="col-lg-4 text-center fw-bold py-2">Type</div>
                                                    <div class="col-lg-4 text-center fw-bold py-2">Amount</div>
                                                    <div class="col-lg-4 text-center fw-bold py-2">Date</div>
                                                </div>
                                                <div class="row">
                                                    @foreach(@$value->all as $k => $val)
                                                    <div class="col-lg-4 mt-3 text-fs-3 shipment-details">
                                                        {{ @$val->type }}
                                                    </div>

                                                    <div class="col-lg-4 d-flex align-items-center justify-content-center">
                                                        <b>${{ @$val->amount }}</b>
                                                    </div>

                                                    <div class="col-lg-4 d-flex align-items-center justify-content-center">
                                                        {{ date("d M, Y", strtotime(@$val->created_at)) }}
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                        <td class="text-center" colspan="7">
                                            <p>No record found</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive tab-pane fade" data-bs-toggle="tab" id="transportation">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col">VIN</th>
                                    <th scope="col">Buyer</th>
                                    <th scope="col">Total Paid</th>
                                    <th scope="col">Total Unpaid</th>
                                    <th scope="col">Payment Status</th>
                                </thead>
                                <tbody>
                                    @if(count(@$transportation) > 0)
                                    @foreach(@$transportation as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ @$value->vehicle->vin }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ @$value->vehicle->buyer->surname }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3 text-success">
                                                ${{ @$value->total_paid }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3 text-danger">
                                                ${{ @$value->total_unpaid }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="@if(@$value->payment_status == "paid") btn btn-success @elseif(@$value->payment_status == "partly paid") btn btn-warning @else btn btn-danger @endif rounded-1 text-white text-fs-3 border border-0">
                                                {{ ucfirst(@$value->payment_status) }}
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                        <td class="text-center" colspan="4">
                                            <p>No record found</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal fade" id="commentModal" tabindex="-1"
                        aria-labelledby="commentModalLabel" aria-hidden="true">
                        <div class="modal-dialog rounded-5">
                            <div class="modal-content p-3">
                                <div class="modal-header border-0">
                                    <h1 class="modal-title fw-bold" id="commentModalLabel"
                                        style="font-size: 28px">
                                        Add Comment</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="form" method="POST" action="{{ url('user/add-comment') }}">
                                        <input type="hidden" name="vehicle_id" id="add_com_vehicle" value="0">
                                        <div class="row mt-4">
                                            <label for="admin_notes" class="col-md-4 fs-5 fw-bold">Admin Comment
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" id="admin_notes" class="form-control text-fs-4 rounded pb-4" disabled />
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label for="user_notes" class="col-md-4 fs-5 fw-bold">User Comment
                                            </label>
                                            <div class="col-md-8">
                                                <div class="d-flex flex-column align-items-end">
                                                    <input type="text" id="user_notes" name="user_notes" class="form-control text-fs-4 rounded pb-4" required />
                                                    <button class="btn btn-sm btn-primary mt-3 comment-btn fs-6 border-0">
                                                        Update Comment
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void;" class="btn btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5 w-auto" data-bs-dismiss="modal">Close</a>
                                    </form>
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

            $(document).on("click", "#money", function () {
                $(".select2js").select2({
                    dropdownParent: $('#moneyTransferModal')
                });
                $("#moneyTransferModal").modal("show");
                $("#moneyTransferModal .select2.select2-container").css("width", "100%");
                $("#moneyTransferModal .select2-selection").css("height", "40px");
                $("#moneyTransferModal .select2-selection__arrow").css("display", "none");
            });

            $(document).on("click", ".comment_modal", function () {
                var id = $(this).attr("data-id");
                $("#add_com_vehicle").val(id);

                var settings = {
                  "url": "{{ url('user/get-vehicle-notes') }}"+"/"+id,
                  "method": "GET",
                };

                $.ajax(settings).done(function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        $("#admin_notes").val(response.data.notes_financial);
                        $("#user_notes").val(response.data.notes_user_financial);
                    }
                });

                $("#commentModal").modal("show");
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
        })
    </script>
    <script type="text/javascript">
        $(window).on('load', function () {
            $('#financialSheetPasswordModal').modal('show');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
    </script>

@endsection