@extends('layouts.admin')

@section('title')
    Financial System
@endsection

@section('content')

    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Financial Summary
                </h4>
            </div>

            <form method="GET" action="{{ url('admin/financial-system') }}" class="row align-items-center" id="filters-form">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="mt-4">
                            <div class="row mb-4">
                                <label for="buyer" class="col-md-3 col-form-label fw-semibold">Buyer</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" id="buyer" name="buyer">
                                        <option value="all" selected>All</option>
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
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">VIN Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="vin" id="vin" value="{{ @$vin }}" placeholder="Enter Vehicle VIN" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-4">
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">From</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="from" value="{{ @$from }}" id="from" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-4">
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">To</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="to" value="{{ @$to }}" id="to" />
                                </div>
                            </div>
                            {{-- <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Status</label>
                                <div class="col-sm-9">
                                    <select id="status" name="status" class="selectjs form-select p-2">
                                        <option value="all" @if(@$status == "all") selected @endif>All</option>
                                        <option value="paid" @if(@$status == "paid") selected @endif>Paid</option>
                                        <option value="unpaid" @if(@$status == "unpaid") selected @endif>Unpaid</option>
                                        <option value="partly paid" @if(@$status == "partly paid") selected @endif>Partly Paid</option>
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </form>

            <!-- Financial Status part -->
            <div>
                <div class="row mt-4 financial-sub-card-header">
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle text-fs-5">Due payments</h2>
                                    <p class="card-text fw-bold mt-2">$ <span>{{ @$due_payments }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle text-fs-5">Previous payments</h2>
                                    <p class="card-text fw-bold mt-2">$ <span>{{ @$previous }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle text-fs-5">Balance</h2>
                                    <p class="card-text fw-bold mt-2">$ <span>{{ @$balance }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction history -->
                    <div class="d-flex justify-content-between mt-5">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                            Transaction history
                        </h4>
                        <div class="d-flex justify-content-end">
                            <div class="mt-6 px-14">
                                <div class="financial-btn">
                                    @if(empty($auth_user->admin_level->access) || @in_array("5.2", json_decode($auth_user->admin_level->access)))
                                    <button type="button" id="payment-modal" class="btn btn-primary border border-1 fs-6">
                                        Add Balance
                                    </button>
                                    @endif
                                    <a href="{{ url("admin/money-transfer") }}" class="btn @if(@$latest_count > 0) btn-info @else btn-primary @endif border border-1 fs-6">
                                        Money Transfer
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="addPaymentModal"
                                        aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog rounded-5">
                                            <div class="modal-content p-3">
                                                <div class="modal-header border-0">
                                                    <h1 class="modal-title fw-bold" id="addPaymentModalLabel"
                                                        style="font-size: 28px">
                                                        Add Balance</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form" method="POST" action="{{ url('admin/add-balance') }}">
                                                        <input type="hidden" name="type" value="all">
                                                        <input type="hidden" name="status" value="paid">
                                                        <div class="row mt-4">
                                                            <label for="username" class="col-md-4 fs-5 fw-bold">Buyer</label>
                                                            <div class="col-md-8">
                                                                <select class="select2js form-select p-2 border border-gray-200 rounded-lg buyer" name="user_id" aria-label="Default select example">
                                                                    <option value="0">All</option>
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
                                                        </div>
                                                        {{-- <div class="row mt-4">
                                                            <label for="vin-number" class="col-md-4 fs-5 fw-bold">VIN Number</label>
                                                            <div class="col-md-8">
                                                                <select class="select2js form-select p-2 border border-gray-200 rounded-lg vin" name="vehicle_id" aria-label="Default select example" disabled="">
                                                                    <option value="0">All</option>
                                                                </select>
                                                            </div>
                                                        </div> --}}
                                                        {{-- <a href="javascript:void;" class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Check</a> --}}

                                                        <div class="row mt-4">
                                                            <label for="amount" class="col-md-4 fs-5 fw-bold">Amount
                                                                to Add</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="amount" id="pay_amount" class="form-control shadow-lg" disabled="" />
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-12 px-3">
                                                    <div class="d-flex mt-4">
                                                        <label for="username" class="col-md-4 fs-5 fw-bold">Account Status</label>
                                                        <div class="col-md-7 text-center">
                                                            <div class="card bg-primary p-2 py-3 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-5">Balance</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">$ <span id="before_bal">{{ @$balance }}</span></p>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6 m-2">
                                                            <div
                                                                class="card bg-primary p-2 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-6">Due payments</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">
                                                                    <span id="before_dp">{{ @$due_payments }}</span> $</p>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <div class="d-flex mt-4">
                                                        <label for="username"
                                                            class="col-md-4 fs-5 fw-bold">Account Status will
                                                            be</label>
                                                        <div class="col-md-7 text-center">
                                                            <div class="card bg-primary p-2 py-3 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-5">Balance</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">$ <span id="after_bal">{{ @$balance }}</span></p>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6 m-2">
                                                            <div
                                                                class="card bg-primary p-2 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-6">Due payments</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">
                                                                    <span id="after_dp">{{ @$due_payments }}</span> $</p>
                                                            </div>
                                                        </div> --}}
                                                    </div>

                                                </div>
                                                <button type="button" class="btn w-auto btn-primary border-0 mt-4 col-md-6 rounded-3 fs-6 save">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="d-flex justify-content-between mt-3 align-items-center">
                    <h4 class="fw-bold fs-md-13 text-fs-5">
                        Transactions
                    </h4>
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
                            if (!empty(@$from)) {
                                array_push($prev_params, 'from='.$from);
                                array_push($next_params, 'from='.$from);
                            }
                            if (!empty(@$vin)) {
                                array_push($prev_params, 'vin='.$vin);
                                array_push($next_params, 'vin='.$vin);
                            }
                            if (!empty(@$to)) {
                                array_push($prev_params, 'to='.$to);
                                array_push($next_params, 'to='.$to);
                            }
                            // if (!empty(@$status)) {
                            //     array_push($prev_params, 'status='.$status);
                            //     array_push($next_params, 'status='.$status);
                            // }
                            $pre = join("&", $prev_params);
                            $nex = join("&", $next_params);
                        @endphp
                        <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/financial-system?'.$pre) }}" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </a>
                        <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                        <a class="btn" @if(count($transaction_history) < 10) href="javascript:void();" @else href="{{ url('admin/financial-system?'.$nex) }}" @endif>
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
                            @if(empty($auth_user->admin_level->access) || @in_array("5.2", json_decode($auth_user->admin_level->access)))
                            <th scope="col"></th>
                            @endif
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Buyer</th>
                            <th scope="col" class="fw-bold">Total Paid</th>
                            <th scope="col" class="fw-bold">Total Unpaid</th>
                            <th scope="col" class="fw-bold">Payment Status</th>
                            @if(empty($auth_user->admin_level->access) || @in_array("5.2", json_decode($auth_user->admin_level->access)))
                            <th scope="col"></th>
                            @endif
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @if(count(@$transaction_history) > 0)
                            @foreach(@$transaction_history as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                @if(empty($auth_user->admin_level->access) || @in_array("5.2", json_decode($auth_user->admin_level->access)))
                                <td>
                                    <button class="btn border-0 open" data-id="{{ @$value->vehicle_id }}" data-user-id="{{ @$value->user_id }}">
                                        <i class="fa fa-edit text-success"></i>
                                    </button>
                                </td>
                                @endif
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
                                @if(empty($auth_user->admin_level->access) || @in_array("5.2", json_decode($auth_user->admin_level->access)))
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
                                @endif
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
            </div>
            <!-- Modal -->
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
                            <form class="comment-form" method="POST" action="{{ url('admin/add-comment') }}">
                                <input type="hidden" name="vehicle_id" id="add_com_vehicle" value="0">
                                <div class="row mt-4">
                                    <label for="admin_notes" class="col-md-4 fs-5 fw-bold">Admin Comment
                                    </label>
                                    <div class="col-md-8">
                                        <input type="text" name="admin_notes" id="admin_notes" class="form-control text-fs-4 rounded pb-4" required />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="user_notes" class="col-md-4 fs-5 fw-bold">User Comment
                                    </label>
                                    <div class="col-md-8">
                                        <div class="d-flex flex-column align-items-end">
                                            <input type="text" id="user_notes" class="form-control text-fs-4 rounded pb-4" disabled />
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
            <!-- Modal -->
            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h3 class="modal-title fw-bold" id="addPaymentModalLabel" style="font-size: 26px">Submit Payment</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-fs-4">
                                        <tr>
                                            <th>Type</th>
                                            <th>Paid</th>
                                            <th>Unpaid</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Auction Price</td>
                                            <td>$<span id="paid_ap">0</span></td>
                                            <td>$<span id="unpaid_ap">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="auction_price">
                                                    <input type="hidden" name="amount" id="auc_price" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="ap_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Towing Price</td>
                                            <td>$<span id="paid_tp">0</span></td>
                                            <td>$<span id="unpaid_tp">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="towing_price">
                                                    <input type="hidden" name="amount" id="tow_price" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="tp_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Occean Freight</td>
                                            <td>$<span id="paid_of">0</span></td>
                                            <td>$<span id="unpaid_of">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="occean_freight">
                                                    <input type="hidden" name="amount" id="occ_freight" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="of_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Company Fee</td>
                                            <td>$<span id="paid_cf">0</span></td>
                                            <td>$<span id="unpaid_cf">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="company_fee">
                                                    <input type="hidden" name="amount" id="comp_price" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="cf_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Unloading Fee</td>
                                            <td>$<span id="paid_uf">0</span></td>
                                            <td>$<span id="unpaid_uf">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="unloading_fee">
                                                    <input type="hidden" name="amount" id="unload_price" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="uf_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Auction Fines</td>
                                            <td>$<span id="paid_af">0</span></td>
                                            <td>$<span id="unpaid_af">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="auction_fines">
                                                    <input type="hidden" name="amount" id="auc_fine_price" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="af_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trans. Fines</td>
                                            <td>$<span id="paid_tf">0</span></td>
                                            <td>$<span id="unpaid_tf">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="trans_fines">
                                                    <input type="hidden" name="amount" id="trans_price" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="tf_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Draft Expenses</td>
                                            <td>$<span id="paid_de">0</span></td>
                                            <td>$<span id="unpaid_de">0</span></td>
                                            <td>
                                                <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="draft_expenses">
                                                    <input type="hidden" name="amount" id="draft_price" value="0">
                                                    <input type="hidden" name="user_id" class="buyer_id" value="1">
                                                    <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                                    <input type="hidden" name="status" value="partly paid">
                                                    <button class="btn btn-primary mb-2 border-0" id="de_pay">Pay</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <button class="btn btn-success" type="button" id="pay_all">Pay All</button>
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
        $(document).ready(() => {
            $('.details-button').click((e) => {
                $($(e.target).closest('.details-button').attr('data-target')).toggleClass('show')
                if (
                    $(e.target).closest('.details-button').css('transform') == 'none'
                ) $(e.target).closest('.details-button').css('transform', 'rotate(360deg)')
                else {
                    $(e.target).closest('.details-button').css('transform', 'none')
                }
            })
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

            $(document).on("click", ".comment_modal", function () {
                var id = $(this).attr("data-id");
                $("#add_com_vehicle").val(id);

                var settings = {
                  "url": "{{ url('admin/get-vehicle-notes') }}"+"/"+id,
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

            $(document).on("click", "#pay_all", function () {
                var type = [];
                var amount = [];
                var user_id = [];
                var vehicle_id = [];
                var flag = 0;
                $(".pay-form").each(function (key, value) {
                    if ($(value).css("display") !== "none") {
                        type.push($(value).find("input[name='type']").val());
                        amount.push($(value).find("input[name='amount']").val());
                        user_id.push($(value).find("input[name='user_id']").val());
                        vehicle_id.push($(value).find("input[name='vehicle_id']").val());
                        flag = 1;
                    }
                });

                if (flag == 1) {
                    var form = new FormData();
                    form.append("type", type);
                    form.append("amount", amount);
                    form.append("user_id", user_id);
                    form.append("vehicle_id", vehicle_id);

                    $.ajax({
                        type: 'POST',
                        url: '{{ url("admin/pay-all") }}',
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
                                toastr["success"](data.msg, "Completed!");
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr["error"](data.msg, "Failed!");
                            }
                        }
                    });
                } else {
                    toastr["error"]("Already paid!", "Failed!");
                }
            });

            $(document).on("click", ".open", function () {
                var id = $(this).attr("data-id");
                var buyer_id = $(this).attr("data-user-id");
                $(".vehicle_id").val(id);
                $(".buyer_id").val(buyer_id);

                var settings = {
                  "url": "{{ url('admin/get-vehicle-detail') }}"+"/"+id,
                  "method": "GET",
                };

                $.ajax(settings).done(function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        $("#paid_ap").text(response.data.paid_ap);
                        $("#unpaid_ap").text(response.data.unpaid_ap);
                        $("#auc_price").val(response.data.unpaid_ap);
                        if (response.data.unpaid_ap > 0) {
                            $("#ap_pay").parent().css("display", "block");
                        } else {
                            $("#ap_pay").parent().css("display", "none");
                        }
                        $("#paid_tp").text(response.data.paid_tp);
                        $("#unpaid_tp").text(response.data.unpaid_tp);
                        $("#tow_price").val(response.data.unpaid_tp);
                        if (response.data.unpaid_tp > 0) {
                            $("#tp_pay").parent().css("display", "block");
                        } else {
                            $("#tp_pay").parent().css("display", "none");
                        }
                        $("#paid_of").text(response.data.paid_of);
                        $("#unpaid_of").text(response.data.unpaid_of);
                        $("#occ_freight").val(response.data.unpaid_of);
                        if (response.data.unpaid_of > 0) {
                            $("#of_pay").parent().css("display", "block");
                        } else {
                            $("#of_pay").parent().css("display", "none");
                        }
                        $("#paid_cf").text(response.data.paid_cf);
                        $("#unpaid_cf").text(response.data.unpaid_cf);
                        $("#comp_price").val(response.data.unpaid_cf);
                        if (response.data.unpaid_cf > 0) {
                            $("#cf_pay").parent().css("display", "block");
                        } else {
                            $("#cf_pay").parent().css("display", "none");
                        }
                        $("#paid_uf").text(response.data.paid_uf);
                        $("#unpaid_uf").text(response.data.unpaid_uf);
                        $("#unload_price").val(response.data.unpaid_uf);
                        if (response.data.unpaid_uf > 0) {
                            $("#uf_pay").parent().css("display", "block");
                        } else {
                            $("#uf_pay").parent().css("display", "none");
                        }
                        $("#paid_af").text(response.data.paid_af);
                        $("#unpaid_af").text(response.data.unpaid_af);
                        $("#auc_fine_price").val(response.data.unpaid_af);
                        if (response.data.unpaid_af > 0) {
                            $("#af_pay").parent().css("display", "block");
                        } else {
                            $("#af_pay").parent().css("display", "none");
                        }
                        $("#paid_tf").text(response.data.paid_tf);
                        $("#unpaid_tf").text(response.data.unpaid_tf);
                        $("#trans_price").val(response.data.unpaid_tf);
                        if (response.data.unpaid_tf > 0) {
                            $("#tf_pay").parent().css("display", "block");
                        } else {
                            $("#tf_pay").parent().css("display", "none");
                        }
                        $("#paid_de").text(response.data.paid_de);
                        $("#unpaid_de").text(response.data.unpaid_de);
                        $("#draft_price").val(response.data.unpaid_de);
                        if (response.data.unpaid_de > 0) {
                            $("#de_pay").parent().css("display", "block");
                        } else {
                            $("#de_pay").parent().css("display", "none");
                        }

                        $("#detailModal").modal("show");
                    }
                });
            });

            $(document).on("click", "#payment-modal", function () {
                $('.select2js').select2({
                    dropdownParent: $('#addPaymentModal')
                });
                $("#addPaymentModal").modal('show');
                $("#addPaymentModal .select2.select2-container").css("width", "100%");
                $("#addPaymentModal .select2-selection").css("height", "40px");
                $("#addPaymentModal .select2-selection__arrow").css("display", "none");
            });

            $(document).on("click", ".save", function () {
                $(".form").submit();
            });

            $(document).on("submit", ".form", function (event) {
                event.preventDefault();

                if ($(".buyer option:selected").val() == "") {
                    toastr["error"]("Buyer is required!", "Completed!");
                } else if ($("#pay_amount").val() == "") {
                    toastr["error"]("Amount to pay is required!", "Completed!");
                } else {
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
                }
            });

            $(document).on("submit", ".pay-form", function (event) {
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

            $(document).on("submit", ".comment-form", function (event) {
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

            $(document).on("change", "#pay_amount", function () {
                var value = $(this).val();
                var before_bal = $("#before_bal").text();
                var before_dp = $("#before_dp").text();
                if (value !== '') {
                    var after_dp = parseInt(before_dp) - parseInt(value);
                    var after_bal = 0;
                    if (after_dp < 0) {
                        after_bal = after_dp - (2 * after_dp);
                        after_dp = 0;
                    }
                    $("#after_bal").text(parseInt(before_bal) + parseInt(value));
                    $("#after_dp").text(after_dp);
                } else {
                    $("#after_bal").text(before_bal);
                    $("#after_dp").text(before_dp);
                }
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

            $(document).on("change", ".buyer", function () {
                var id = $(this).find("option:selected").val();

                if (id !== "0") {
                    $("#pay_amount").attr("disabled", false);
                } else {
                    $("#pay_amount").attr("disabled", true);
                }

                var settings = {
                  "url": "{{ url('admin/get-vehicle-vin') }}"+"/"+id,
                  "method": "GET",
                };

                $.ajax(settings).done(function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        // $(".vin").html("");
                        // $(".vin").append("<option value='0'>All</option>");
                        // $(response.data.data).each(function (key, value) {
                        //     option = "<option value="+value.id+">"+value.vin+"</option>";
                        //     $(".vin").append(option);
                        // });
                        $("#before_dp").text(response.data.due_payments);
                        $("#before_bal").text(response.data.balance);
                        $("#after_dp").text(response.data.due_payments);
                        $("#after_bal").text(response.data.balance);
                        // $(".vin").attr("disabled", false);
                    }
                });
            });

            $(document).on("change", ".vin", function () {
                var id = $(this).find("option:selected").val();
                var buyer_id = $(".buyer").find("option:selected").val();

                var settings = {
                  "url": "{{ url('admin/get-vehicle-financial') }}"+"/"+id+"/"+buyer_id,
                  "method": "GET",
                };

                $.ajax(settings).done(function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        $("#before_dp").text(response.data.due_payments);
                        $("#before_bal").text(response.data.balance);
                        $("#after_dp").text(response.data.due_payments);
                        $("#after_bal").text(response.data.balance);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
            $(document).on("change", "#buyer, #vin, #from, #to, #status", function () {
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