@extends('layouts.user')

@section('content')

    <style type="text/css">
        table th {
            font-weight: bold !important;
        }
    </style>

    <div class="below-header-height outer-container">
        <div class="inner-container">

            <!-- Modal -->
            <div class="modal fade  show" id="financialSheetPasswordModal" tabindex="-1"
                data-bs-backdrop="static" aria-labelledby="financialSheetPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fw-bold" id="financialSheetPasswordModalLabel"
                                style="font-size: 28px">
                                Financial Sheet Password</h1>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-4">
                                <label for="password" class="col-md-4 fs-5 fw-bold">Password</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control shadow-lg" placeholder="Password" />
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5"
                                data-bs-dismiss="modal">Proceed</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Status part -->

            <div class="card financial-card-header border border-0">
                <div class="card-body" style="margin-bottom: 100px">
                    <h3 class="text-white fw-bold fs-2">Great Job, {{ \Auth::user()->surname }}!</h3>
                    <h4 class="text-white px-5 text-fs-5 fw-bold">
                        Your Account Health is
                        <span class="text-exceed">exceeding 80%</span>
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
                            <button data-bs-toggle="modal" data-bs-target="#moneyTransferModal"
                                class="btn btn-primary border border-1 fs-6">
                                Money Transfer
                            </button>

                            <!-- Modal -->
                            <div class="modal fade  " id="moneyTransferModal" tabindex="-1"
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
                                            <div class="row mt-4">
                                                <label for="password"
                                                    class="col-md-4 fs-5 fw-bold">Amount</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control shadow" />
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <label for="password"
                                                    class="col-md-4 fs-5 fw-bold">Vehicle</label>
                                                <div class="col-md-8">
                                                    <select class="form-select shadow"
                                                        aria-label="Default select example">
                                                        <option selected>Choose option</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <label for="password" class="col-md-4 fs-5 fw-bold">Exchange
                                                    Company</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control shadow" />
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <label for="password" class="col-md-4 fs-5 fw-bold">Transfer
                                                    No.</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control shadow" />
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <label for="password"
                                                    class="col-md-4 fs-5 fw-bold">Comment</label>
                                                <div class="col-md-8">
                                                    <input type="text"
                                                        class="form-control shadow text-fs-4 rounded pb-4" />
                                                </div>
                                            </div>

                                            <a href="#"
                                                class="btn btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5 w-auto"
                                                data-bs-dismiss="modal">Submit</a>
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
                            <a class="btn" @if(count($transaction_history) < 10) href="javascript:void();" @else href="{{ url('user/financial?'.$nex) }}" @endif>
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
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Vehicle</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Transaction amount</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$transaction_history) > 0)
                                    @foreach(@$transaction_history as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ @$value->id }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ @$value->vehicle->company_name.' '.@$value->vehicle->name.' '.@$value->vehicle->modal }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ @$value->vehicle->vin }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                {{ date("d M, Y", strtotime(@$value->created_at)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="col d-flex align-items-center justify-content-center">
                                                <button class="@if(@$value->status == "paid") btn btn-success @elseif(@$value->status == "partly paid") btn btn-warning @else btn btn-danger @endif rounded-1 text-white text-fs-3 border border-0">
                                                    {{ ucfirst(@$value->status) }}
                                                </button>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-bold text-fs-3 text-center">
                                                {{ @$value->amount }} $
                                            </span>
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-center items-center message-icon">
                                                <button class="btn border-0" data-bs-toggle="modal"
                                                    data-bs-target="#commentModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-6 h-6">
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
                                                                <h1 class="modal-title fw-bold"
                                                                    id="commentModalLabel"
                                                                    style="font-size: 28px">
                                                                    Add Comment</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mt-4">
                                                                    <label for="password"
                                                                        class="col-md-4 fs-5 fw-bold">Admin
                                                                        Comment </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text"
                                                                            class="form-control text-fs-4 rounded pb-4"
                                                                            disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <label for="password"
                                                                        class="col-md-4 fs-5 fw-bold">User
                                                                        Comment </label>
                                                                    <div class="col-md-8">
                                                                        <div
                                                                            class="d-flex flex-column align-items-end">
                                                                            <input type="text"
                                                                                class="form-control text-fs-4 rounded pb-4" />
                                                                            <button
                                                                                class="btn btn-sm btn-primary comment-btn fs-6 border-0"
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
                                                                <h1 class="modal-title fw-bold"
                                                                    id="fullNoteModelLabel"
                                                                    style="font-size: 28px">
                                                                    Note</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card-body">
                                                                    <input type="text"
                                                                        class="form-control text-fs-5 rounded pb-4" />
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
                        <div class="table-responsive tab-pane fade" data-bs-toggle="tab" id="transportation">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Vehicle</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Transaction amount</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                123ES12123DSF
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                Hyundai Sonata 2019
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                1GYKPCRS3LZ238722
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                31 Mar, 2021
                                            </span>
                                        </td>

                                        <td>
                                            <div class="col d-flex align-items-center justify-content-center">
                                                <button
                                                    class="btn btn-danger rounded-1 text-white text-fs-3 border border-0">
                                                    Unpaid
                                                </button>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-bold text-fs-3 text-center">
                                                35,452 $
                                            </span>
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-center items-center message-icon">
                                                <button class="btn border-0" data-bs-toggle="modal"
                                                    data-bs-target="#commentModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                    </svg>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade  " id="commentModal" tabindex="-1"
                                                    aria-labelledby="commentModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog rounded-5">
                                                        <div class="modal-content p-3">
                                                            <div class="modal-header border-0">
                                                                <h1 class="modal-title fw-bold"
                                                                    id="commentModalLabel"
                                                                    style="font-size: 28px">
                                                                    Add Comment</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mt-4">
                                                                    <label for="password"
                                                                        class="col-md-4 fs-5 fw-bold">Admin
                                                                        Comment </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text"
                                                                            class="form-control text-fs-4 rounded pb-4"
                                                                            disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <label for="password"
                                                                        class="col-md-4 fs-5 fw-bold">User
                                                                        Comment </label>
                                                                    <div class="col-md-8">
                                                                        <div
                                                                            class="d-flex flex-column align-items-end">
                                                                            <input type="text"
                                                                                class="form-control text-fs-4 rounded pb-4" />
                                                                            <button
                                                                                class="btn btn-sm btn-primary comment-btn fs-6 border-0"
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
                                                <div class="modal fade  " id="fullNoteModel" tabindex="-1"
                                                    aria-labelledby="fullNoteModelLabel" aria-hidden="true">
                                                    <div class="modal-dialog rounded-5">
                                                        <div class="modal-content p-3">
                                                            <div class="modal-header border-0">
                                                                <h1 class="modal-title fw-bold"
                                                                    id="fullNoteModelLabel"
                                                                    style="font-size: 28px">
                                                                    Note</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card-body">
                                                                    <input type="text"
                                                                        class="form-control text-fs-5 rounded pb-4" />
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
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                123ES12123DSF
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                Hyundai Sonata 2019
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                1GYKPCRS3LZ238722
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-fs-3">
                                                31 Mar, 2021
                                            </span>
                                        </td>

                                        <td>
                                            <div class="col d-flex align-items-center justify-content-center">
                                                <button
                                                    class="btn btn-success rounded-1 text-white text-fs-3 border border-0">
                                                    Paid
                                                </button>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-bold text-fs-3 text-center">
                                                35,452 $
                                            </span>
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-center items-center message-icon">
                                                <button class="btn border-0" data-bs-toggle="modal"
                                                    data-bs-target="#commentModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                    </svg>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade  " id="commentModal" tabindex="-1"
                                                    aria-labelledby="commentModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog rounded-5">
                                                        <div class="modal-content p-3">
                                                            <div class="modal-header border-0">
                                                                <h1 class="modal-title fw-bold"
                                                                    id="commentModalLabel"
                                                                    style="font-size: 28px">
                                                                    Add Comment</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mt-4">
                                                                    <label for="password"
                                                                        class="col-md-4 fs-5 fw-bold">Admin
                                                                        Comment </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text"
                                                                            class="form-control text-fs-4 rounded pb-4"
                                                                            disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <label for="password"
                                                                        class="col-md-4 fs-5 fw-bold">User
                                                                        Comment </label>
                                                                    <div class="col-md-8">
                                                                        <div
                                                                            class="d-flex flex-column align-items-end">
                                                                            <input type="text"
                                                                                class="form-control text-fs-4 rounded pb-4" />
                                                                            <button
                                                                                class="btn btn-sm btn-primary comment-btn fs-6 border-0"
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
                                                <div class="modal fade  " id="fullNoteModel" tabindex="-1"
                                                    aria-labelledby="fullNoteModelLabel" aria-hidden="true">
                                                    <div class="modal-dialog rounded-5">
                                                        <div class="modal-content p-3">
                                                            <div class="modal-header border-0">
                                                                <h1 class="modal-title fw-bold"
                                                                    id="fullNoteModelLabel"
                                                                    style="font-size: 28px">
                                                                    Note</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card-body">
                                                                    <input type="text"
                                                                        class="form-control text-fs-5 rounded pb-4" />
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
                                </tbody>
                            </table>
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