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
                    <div class="col-md-6">
                        <div class="mt-4">
                            <div class="row mb-4">
                                <label for="buyer" class="col-md-3 col-form-label fw-semibold">Buyer</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" id="buyer" name="buyer">
                                        <option value="all" selected>All</option>
                                        @if(count(@$all_buyer) > 0)
                                        @foreach(@$all_buyer as $key => $value)
                                            @if($value->id == @$buyer)
                                            <option value="{{ @$value->id }}" selected>{{ $value->name }}</option>
                                            @else
                                            <option value="{{ @$value->id }}">{{ @$value->name }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">VIN Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="vin" placeholder="Enter Vehicle VIN" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-4">
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">From</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="from" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">To</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="to" />
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
                                    <button data-bs-toggle="modal" data-bs-target="#addPaymentModal"
                                        class="btn btn-primary border border-1 fs-6">
                                        Add Payment
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade  " id="addPaymentModal" tabindex="-1"
                                        aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog rounded-5">
                                            <div class="modal-content p-3">
                                                <div class="modal-header border-0">
                                                    <h1 class="modal-title fw-bold" id="addPaymentModalLabel"
                                                        style="font-size: 28px">
                                                        Submit Payment</h1>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mt-4">
                                                        <label for="username"
                                                            class="col-md-4 fs-5 fw-bold">Username</label>
                                                        <div class="col-md-8">
                                                            <select class="form-select" name="buyer" aria-label="Default select example">
                                                                @if(count(@$all_buyer) > 0)
                                                                @foreach(@$all_buyer as $key => $value)
                                                                    @if($value->id == @$buyer)
                                                                    <option value="{{ @$value->id }}" selected>{{ $value->name }}</option>
                                                                    @else
                                                                    <option value="{{ @$value->id }}">{{ @$value->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <label for="vin-number"
                                                            class="col-md-4 fs-5 fw-bold">VIN Number</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="vin" class="form-control shadow-lg" />
                                                        </div>
                                                    </div>
                                                    <a href="#"
                                                        class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Check</a>

                                                    <div class="row mt-4">
                                                        <label for="amount" class="col-md-4 fs-5 fw-bold">Amount
                                                            to Pay</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="amount" id="pay_amount" class="form-control shadow-lg" />
                                                        </div>
                                                    </div>
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
                                                <a href="#"
                                                    class="btn w-auto btn-primary border-0 mt-4 col-md-6 rounded-3 fs-6">Submit</a>
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
                            $pre = 'page='.$prev;
                            $nex = 'page='.$next;
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
                            <th scope="col" class="fw-bold">Transaction ID</th>
                            <th scope="col" class="fw-bold">Buyer</th>
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Date</th>
                            <th scope="col" class="fw-bold">Status</th>
                            <th scope="col" class="fw-bold">Transaction amount</th>
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
                                        {{ @$value->vehicle->buyer->name }}
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
                                    <button class="@if(@$value->status == "paid") btn btn-success @else btn btn-danger @endif rounded-1 text-white text-fs-3 border border-0">
                                        {{ ucfirst(@$value->status) }}
                                    </button>
                                </td>

                                <td>
                                    <span class="fw-bold text-fs-3 text-center">
                                        {{ @$value->amount }} $
                                    </span>
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
                                        <div class="modal fade  " id="commentModal" tabindex="-1"
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
                            <tr>
                                <td colspan="6">No data found</td>
                            </tr>
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

            $(document).on("change", "#pay_amount", function () {
                var value = $(this).val();
                var before_bal = $("#before_bal").text();
                var before_dp = $("#before_dp").text();
                if (value !== "") {
                    var after_dp = parseInt(before_dp) - parseInt(value);
                    var after_bal = 0;
                    if (after_dp < 0) {
                        after_bal = after_dp - (2 * after_dp);
                        after_dp = 0;
                    }
                    $("#after_bal").text(after_bal);
                    $("#after_dp").text(after_dp);
                } else {
                    $("#before_bal").text(after_bal);
                    $("#before_dp").text(after_dp);
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