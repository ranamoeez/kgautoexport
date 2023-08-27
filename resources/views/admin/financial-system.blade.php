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
                                            <option value="{{ @$value->id }}" selected>{{ $value->surname }}</option>
                                            @else
                                            <option value="{{ @$value->id }}">{{ @$value->surname }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
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
                                <label for="" class="col-sm-3 col-form-label fw-semibold">VIN Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="vin" id="vin" value="{{ @$vin }}" placeholder="Enter Vehicle VIN" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">To</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="to" value="{{ @$to }}" id="to" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-4">
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Status</label>
                                <div class="col-sm-9">
                                    <select id="status" name="status" class="selectjs form-select p-2">
                                        <option value="all" @if(@$status == "all") selected @endif>All</option>
                                        <option value="paid" @if(@$status == "paid") selected @endif>Paid</option>
                                        <option value="unpaid" @if(@$status == "unpaid") selected @endif>Unpaid</option>
                                        <option value="partly paid" @if(@$status == "partly paid") selected @endif>Partly Paid</option>
                                    </select>
                                </div>
                            </div>
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
                                    <p class="card-text fw-bold mt-2"><span>{{ @$due_payments }}</span> $</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle text-fs-5">Previous payments</h2>
                                    <p class="card-text fw-bold mt-2"><span>{{ @$previous }}</span> $</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="card border-0 shadow-lg h-100 financial-sub-card">
                            <div class="card-body d-flex flex-row p-5">
                                <div class="align-self-center">
                                    <h2 class="card-subtitle text-fs-5">Balance</h2>
                                    <p class="card-text fw-bold mt-2"><span>{{ @$balance }}</span> $</p>
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
                                    <button type="button" id="payment-modal" class="btn btn-primary border border-1 fs-6">
                                        Add Payment
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="addPaymentModal"
                                        aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog rounded-5">
                                            <div class="modal-content p-3">
                                                <div class="modal-header border-0">
                                                    <h1 class="modal-title fw-bold" id="addPaymentModalLabel"
                                                        style="font-size: 28px">
                                                        Submit Payment</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form" method="POST" action="{{ url('admin/transaction-history') }}">
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
                                                                        <option value="{{ @$value->id }}" selected>{{ $value->surname }}</option>
                                                                        @else
                                                                        <option value="{{ @$value->id }}">{{ @$value->surname }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <label for="vin-number" class="col-md-4 fs-5 fw-bold">VIN Number</label>
                                                            <div class="col-md-8">
                                                                <select class="select2js form-select p-2 border border-gray-200 rounded-lg vin" name="vehicle_id" aria-label="Default select example" disabled="">
                                                                    <option value="0">All</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- <a href="javascript:void;" class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Check</a> --}}

                                                        <div class="row mt-4">
                                                            <label for="amount" class="col-md-4 fs-5 fw-bold">Amount
                                                                to Pay</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="amount" id="pay_amount" class="form-control shadow-lg" />
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex mt-4">
                                                        <label for="username" class="col-md-4 fs-5 fw-bold">Account Status</label>
                                                        <div class="col-md-6 m-2">
                                                            <div
                                                                class="card bg-primary p-2 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-5">Balance</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">
                                                                    <span id="before_bal">{{ @$balance }}</span> $</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-2">
                                                            <div
                                                                class="card bg-primary p-2 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-6">Due payments</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">
                                                                    <span id="before_dp">{{ @$due_payments }}</span> $</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mt-4">
                                                        <label for="username"
                                                            class="col-md-4 fs-5 fw-bold">Account Status will
                                                            be</label>
                                                        <div class="col-md-6 m-2">
                                                            <div
                                                                class="card bg-primary p-2 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-5">Balance</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">
                                                                    <span id="after_bal">{{ @$balance }}</span> $</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-2">
                                                            <div
                                                                class="card bg-primary p-2 border-0 align-self-center">
                                                                <h2 class="card-subtitle fs-6">Due payments</h2>
                                                                <p class="card-text fw-bold fs-6 mt-2">
                                                                    <span id="after_dp">{{ @$due_payments }}</span> $</p>
                                                            </div>
                                                        </div>
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
                            if (!empty(@$status)) {
                                array_push($prev_params, 'status='.$status);
                                array_push($next_params, 'status='.$status);
                            }
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
                            <th scope="col"></th>
                            <th scope="col" class="fw-bold">Transaction ID</th>
                            <th scope="col" class="fw-bold">Buyer</th>
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Date</th>
                            <th scope="col" class="fw-bold">Transaction amount</th>
                            <th scope="col" class="fw-bold">Status</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @if(count(@$transaction_history) > 0)
                            @foreach(@$transaction_history as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td>
                                    <button class="btn border-0 open" data-id="{{ @$value->vehicle->id }}" data-user-id="{{ @$value->vehicle->buyer_id }}">
                                        <i class="fa fa-edit text-success"></i>
                                    </button>
                                </td>
                                <td>
                                    <span class="fw-bold text-fs-3">
                                        {{ @$value->id }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-fs-3">
                                        {{ @$value->vehicle->buyer->surname }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-fs-3">
                                        {{ @$value->vehicle->vin }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-fs-3">
                                        {{ @$value->created_at }}
                                    </span>
                                </td>

                                <td>
                                    <span class="fw-bold text-fs-3 text-center">
                                        {{ @$value->amount }} $
                                    </span>
                                </td>

                                <td>
                                    <button class="@if(@$value->status == "paid") btn btn-success @elseif(@$value->status == "partly paid") btn btn-warning @else btn btn-danger @endif rounded-1 text-white text-fs-3 border border-0">
                                        {{ ucfirst(@$value->status) }}
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center items-center message-icon">
                                        <button class="btn border-0" data-bs-toggle="modal"
                                            data-bs-target="#commentModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                            </svg>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="commentModal" tabindex="-1"
                                            aria-labelledby="commentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog rounded-5">
                                                <div class="modal-content p-3">
                                                    <div class="modal-header border-0">
                                                        <h1 class="modal-title fw-bold" id="commentModalLabel"
                                                            style="font-size: 28px">
                                                            Add Comment</h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mt-4">
                                                            <label for="password"
                                                                class="col-md-4 fs-5 fw-bold">Admin Comment
                                                            </label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control text-fs-4 rounded pb-4" />
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <label for="password"
                                                                class="col-md-4 fs-5 fw-bold">User Comment
                                                            </label>
                                                            <div class="col-md-8">
                                                                <div class="d-flex flex-column align-items-end">
                                                                    <input type="text" class="form-control text-fs-4 rounded pb-4" disabled />
                                                                    <button
                                                                        class="btn btn-sm btn-primary mt-3 comment-btn fs-6 border-0"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#fullNoteModel">
                                                                        Update Comment
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#"
                                                            class="btn btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5 w-auto"
                                                            data-bs-dismiss="modal">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="fullNoteModel" tabindex="-1"
                                            aria-labelledby="fullNoteModelLabel" aria-hidden="true">
                                            <div class="modal-dialog rounded-5">
                                                <div class="modal-content p-3">
                                                    <div class="modal-header border-0">
                                                        <h1 class="modal-title fw-bold" id="fullNoteModelLabel"
                                                            style="font-size: 28px">
                                                            Note</h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <input type="text" class="form-control text-fs-5 rounded pb-4" />
                                                        </div>
                                                        <a href="#" data-bs-dismiss="modal"
                                                            class="btn btn-primary border-0 mt-4 col-md-12 w-auto rounded-3 fs-5">Close</a>
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
            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="row">
                                <div class="offset-md-2 col-md-3">
                                    <p><b>Auction Price</b></p>
                                </div>
                                <div class="col-md-2">
                                    <p><b><span class="auction_price">0</span> $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="auction_price">
                                        <input type="hidden" name="amount" id="auc_price" value="0">
                                        <input type="hidden" name="user_id" class="buyer_id" value="1">
                                        <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                        <input type="hidden" name="status" value="partly paid">
                                        <button class="btn btn-primary mb-2 border-0">Pay</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-md-2 col-md-3">
                                    <p><b>Towing Price</b></p>
                                </div>
                                <div class="col-md-2">
                                    <p><b><span class="towing_price">0</span> $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="towing_price">
                                        <input type="hidden" name="amount" id="tow_price" value="0">
                                        <input type="hidden" name="user_id" class="buyer_id" value="1">
                                        <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                        <input type="hidden" name="status" value="partly paid">
                                        <button class="btn btn-primary mb-2 border-0">Pay</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-md-2 col-md-3">
                                    <p><b>Company Fee</b></p>
                                </div>
                                <div class="col-md-2">
                                    <p><b><span class="company_fee">0</span> $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="company_fee">
                                        <input type="hidden" name="amount" id="comp_price" value="0">
                                        <input type="hidden" name="user_id" class="buyer_id" value="1">
                                        <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                        <input type="hidden" name="status" value="partly paid">
                                        <button class="btn btn-primary mb-2 border-0">Pay</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-md-2 col-md-3">
                                    <p><b>Unloading Fee</b></p>
                                </div>
                                <div class="col-md-2">
                                    <p><b><span class="unloading_fee">0</span> $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="unloading_fee">
                                        <input type="hidden" name="amount" id="unload_price" value="0">
                                        <input type="hidden" name="user_id" class="buyer_id" value="1">
                                        <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                        <input type="hidden" name="status" value="partly paid">
                                        <button class="btn btn-primary mb-2 border-0">Pay</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-md-2 col-md-3">
                                    <p><b>Auction Fines</b></p>
                                </div>
                                <div class="col-md-2">
                                    <p><b><span class="total_auction_fines">0</span> $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="auction_fines">
                                        <input type="hidden" name="amount" id="auc_fine_price" value="0">
                                        <input type="hidden" name="user_id" class="buyer_id" value="1">
                                        <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                        <input type="hidden" name="status" value="partly paid">
                                        <button class="btn btn-primary mb-2 border-0">Pay</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row auction_fines pt-2 mb-2" style="border: 1px solid #aaa; border-radius: 10px;">
                            </div>
                            <div class="row">
                                <div class="offset-md-2 col-md-3">
                                    <p><b>Trans. Fines</b></p>
                                </div>
                                <div class="col-md-2">
                                    <p><b><span class="total_trans_fines">0</span> $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="trans_fines">
                                        <input type="hidden" name="amount" id="trans_price" value="0">
                                        <input type="hidden" name="user_id" class="buyer_id" value="1">
                                        <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                        <input type="hidden" name="status" value="partly paid">
                                        <button class="btn btn-primary mb-2 border-0">Pay</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row trans_fines pt-2 mb-2" style="border: 1px solid #aaa; border-radius: 10px;">
                            </div>
                            <div class="row">
                                <div class="offset-md-2 col-md-3">
                                    <p><b>Draft Expenses</b></p>
                                </div>
                                <div class="col-md-2">
                                    <p><b><span class="total_draft_expenses">0</span> $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <form class="pay-form" method="POST" action="{{ url('admin/transaction-history') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="draft_expenses">
                                        <input type="hidden" name="amount" id="draft_price" value="0">
                                        <input type="hidden" name="user_id" class="buyer_id" value="1">
                                        <input type="hidden" name="vehicle_id" class="vehicle_id" value="1">
                                        <input type="hidden" name="status" value="partly paid">
                                        <button class="btn btn-primary mb-2 border-0">Pay</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row draft_expenses pt-2 mb-2" style="border: 1px solid #aaa; border-radius: 10px;">
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
                        $(".auction_price").text(response.data.auction_price);
                        if (response.data.auction_price == "0.00") {
                            $("#auc_price").parent().css("display", "none");
                        } else {
                            if (response.data.transaction_history.length > 0) {
                                var flag = 0;
                                $(response.data.transaction_history).each(function (key, value) {
                                    if (value.type == "auction_price") {
                                        flag = 1;
                                    }
                                });
                                if (flag == 1) {
                                    $("#auc_price").parent().css("display", "none");
                                } else {
                                    $("#auc_price").parent().css("display", "block");
                                    $("#auc_price").val(response.data.auction_price);
                                }
                            } else {
                                $("#auc_price").parent().css("display", "block");
                                $("#auc_price").val(response.data.auction_price);
                            }
                        }
                        $(".towing_price").text(response.data.towing_price);
                        if (response.data.towing_price == "0") {
                            $("#tow_price").parent().css("display", "none");
                        } else {
                            if (response.data.transaction_history.length > 0) {
                                var flag = 0;
                                $(response.data.transaction_history).each(function (key, value) {
                                    if (value.type == "towing_price") {
                                        flag = 1;
                                    }
                                });
                                if (flag == 1) {
                                    $("#tow_price").parent().css("display", "none");
                                } else {
                                    $("#tow_price").parent().css("display", "block");
                                    $("#tow_price").val(response.data.towing_price);
                                }
                            } else {
                                $("#tow_price").parent().css("display", "block");
                                $("#tow_price").val(response.data.towing_price);
                            }
                        }
                        $(".total_auction_fines").text(response.data.total_auction_fines);
                        if (response.data.total_auction_fines == "0") {
                            $("#auc_fine_price").parent().css("display", "none");
                        } else {
                            if (response.data.transaction_history.length > 0) {
                                var flag = 0;
                                $(response.data.transaction_history).each(function (key, value) {
                                    if (value.type == "auction_fines") {
                                        flag = 1;
                                    }
                                });
                                if (flag == 1) {
                                    $("#auc_fine_price").parent().css("display", "none");
                                } else {
                                    $("#auc_fine_price").parent().css("display", "block");
                                    $("#auc_fine_price").val(response.data.total_auction_fines);
                                }
                            } else {
                                $("#auc_fine_price").parent().css("display", "block");
                                $("#auc_fine_price").val(response.data.total_auction_fines);
                            }
                        }
                        $(".total_trans_fines").text(response.data.total_trans_fines);
                        if (response.data.total_trans_fines == "0") {
                            $("#trans_price").parent().css("display", "none");
                        } else {
                            if (response.data.transaction_history.length > 0) {
                                var flag = 0;
                                $(response.data.transaction_history).each(function (key, value) {
                                    if (value.type == "trans_fines") {
                                        flag = 1;
                                    }
                                });
                                if (flag == 1) {
                                    $("#trans_price").parent().css("display", "none");
                                } else {
                                    $("#trans_price").parent().css("display", "block");
                                    $("#trans_price").val(response.data.total_trans_fines);
                                }
                            } else {
                                $("#trans_price").parent().css("display", "block");
                                $("#trans_price").val(response.data.total_trans_fines);
                            }
                        }
                        $(".total_draft_expenses").text(response.data.total_draft_expenses);
                        if (response.data.total_draft_expenses == "0") {
                            $("#draft_price").parent().css("display", "none");
                        } else {
                            if (response.data.transaction_history.length > 0) {
                                var flag = 0;
                                $(response.data.transaction_history).each(function (key, value) {
                                    if (value.type == "draft_expenses") {
                                        flag = 1;
                                    }
                                });
                                if (flag == 1) {
                                    $("#draft_price").parent().css("display", "none");
                                } else {
                                    $("#draft_price").parent().css("display", "block");
                                    $("#draft_price").val(response.data.total_draft_expenses);
                                }
                            } else {
                                $("#draft_price").parent().css("display", "block");
                                $("#draft_price").val(response.data.total_draft_expenses);
                            }
                        }
                        $(".company_fee").text(response.data.company_fee);
                        if (response.data.company_fee == "0") {
                            $("#comp_price").parent().css("display", "none");
                        } else {
                            if (response.data.transaction_history.length > 0) {
                                var flag = 0;
                                $(response.data.transaction_history).each(function (key, value) {
                                    if (value.type == "company_fee") {
                                        flag = 1;
                                    }
                                });
                                if (flag == 1) {
                                    $("#comp_price").parent().css("display", "none");
                                } else {
                                    $("#comp_price").parent().css("display", "block");
                                    $("#comp_price").val(response.data.company_fee);
                                }
                            } else {
                                $("#comp_price").parent().css("display", "block");
                                $("#comp_price").val(response.data.company_fee);
                            }
                        }
                        $(".unloading_fee").text(response.data.unloading_fee);
                        if (response.data.unloading_fee == "0") {
                            $("#unload_price").parent().css("display", "none");
                        } else {
                            if (response.data.transaction_history.length > 0) {
                                var flag = 0;
                                $(response.data.transaction_history).each(function (key, value) {
                                    if (value.type == "unloading_fee") {
                                        flag = 1;
                                    }
                                });
                                if (flag == 1) {
                                    $("#unload_price").parent().css("display", "none");
                                } else {
                                    $("#unload_price").parent().css("display", "block");
                                    $("#unload_price").val(response.data.unloading_fee);
                                }
                            } else {
                                $("#unload_price").parent().css("display", "block");
                                $("#unload_price").val(response.data.unloading_fee);
                            }
                        }
                        $(".auction_fines").html("");
                        $(".trans_fines").html("");
                        $(".draft_expenses").html("");
                        $(response.data.fines).each(function (key, value) {
                            var date = value.created_at.split('T');
                            date = date[0] + " " + date[1].replace(".000000Z", ""); 
                            if (value.type == "auction") {
                                var auction_fines = `<div class="offset-md-2 col-md-3">
                                    <p>`+value.cause+`</p>
                                </div>
                                <div class="col-md-2">
                                    <p><b>`+value.amount+` $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <p>`+date+`</p>
                                </div>`;
                                $(".auction_fines").append(auction_fines);
                            } else if (value.type == "transaction") {
                                var trans_fines = `<div class="offset-md-2 col-md-3">
                                    <p>`+value.cause+`</p>
                                </div>
                                <div class="col-md-2">
                                    <p><b>`+value.amount+` $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <p>`+date+`</p>
                                </div>`;
                                $(".trans_fines").append(trans_fines);
                            } else if (value.type == "draft_expense") {
                                var draft_expenses = `<div class="offset-md-2 col-md-3">
                                    <p>`+value.cause+`</p>
                                </div>
                                <div class="col-md-2">
                                    <p><b>`+value.amount+` $</b></p>
                                </div>
                                <div class="col-md-4">
                                    <p>`+date+`</p>
                                </div>`;
                                $(".draft_expenses").append(draft_expenses);
                            }
                        });

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
                    $("#after_bal").text(after_bal);
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

                var settings = {
                  "url": "{{ url('admin/get-vehicle-vin') }}"+"/"+id,
                  "method": "GET",
                };

                $.ajax(settings).done(function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        $(".vin").html("");
                        $(".vin").append("<option value='0'>All</option>");
                        $(response.data.data).each(function (key, value) {
                            option = "<option value="+value.id+">"+value.vin+"</option>";
                            $(".vin").append(option);
                        });
                        $("#before_dp").text(response.data.due_payments);
                        $("#before_bal").text(response.data.balance);
                        $("#after_dp").text(response.data.due_payments);
                        $("#after_bal").text(response.data.balance);
                        $(".vin").attr("disabled", false);
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