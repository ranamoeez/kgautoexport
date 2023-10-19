@extends('layouts.admin')

@section('title')
    System Configuration
@endsection

@section('content')
    
    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    System Configuration
                </h4>
            </div>
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="accordion" id="accordionConfig">
                        @include('admin.system-configuration.sidebar')
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bold fs-5 mb-0">Admin Level</h3>
                            <button class="btn border-0 add" type="button">
                                <img src="{{ asset('assets/plus_green.svg') }}" alt="add" />
                            </button>
                            <div class="modal fade new buyer" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog rounded-5" style="max-width: 746px; width: 746px;">
                                    <div class="modal-content p-3">
                                        <div class="modal-header border-0">
                                            <h1 class="modal-title fw-bold" id="modalLabel" style="font-size: 28px">Add New Admin Level</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('admin/system-configuration/admin-levels/add') }}" method="POST" class="form">
                                                @csrf
                                                <div class="row mt-4">

                                                    <div class="col-md-12 mb-4">
                                                        <!-- username -->
                                                        <div class="row">
                                                            <label for="" class="col-md-3">Name</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group shadow-lg rounded-4">
                                                                    <input type="text" name="name" id="name" value=""
                                                                        class="py-2 form-control rounded-end-4"
                                                                        required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-4" id="access">
                                                        <div class="row">
                                                            <label for="" class="col-md-12">Access Levels</label>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row">
                                                                    <label for="" class="offset-md-2 col-md-3">Add New Vehicle</label>
                                                                    <div class="col-md-3">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="all" value="1" />
                                                                        <label for="all">All</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="status" value="1.1" />
                                                                        <label for="status">Status</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="terminal" value="1.2" />
                                                                        <label for="terminal">Terminal</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="buyer" value="1.3" />
                                                                        <label for="buyer">Buyer</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="vin" value="1.4" />
                                                                        <label for="vin">VIN</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="client" value="1.5" />
                                                                        <label for="client">Client Name</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="title" value="1.6" />
                                                                        <label for="title">Title</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="keys" value="1.7" />
                                                                        <label for="keys">Keys</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="operable" value="1.8" />
                                                                        <label for="operable">Operable</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="fuel" value="1.9" />
                                                                        <label for="fuel">Fuel Type</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="auction" value="1.10" />
                                                                        <label for="auction">Auction</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="auction_location" value="1.11" />
                                                                        <label for="auction_location">Branch</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="address" value="1.12" />
                                                                        <label for="address">Address</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="location" value="1.13" />
                                                                        <label for="location">Phone Number</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="auc_buyer" value="1.14" />
                                                                        <label for="auc_buyer">Buyer #</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="lot" value="1.15" />
                                                                        <label for="lot">Lot #</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="purchase" value="1.16" />
                                                                        <label for="purchase">Purchase Date</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="destination" value="1.17" />
                                                                        <label for="destination">Destination</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="notes" value="1.18" />
                                                                        <label for="notes">Notes</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="admin_notes" value="1.19" />
                                                                        <label for="admin_notes">Admin Notes</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="tr_address" value="1.20" />
                                                                        <label for="tr_address">Trans. Address</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="carrier" value="1.21" />
                                                                        <label for="carrier">Carrier</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="pay_date" value="1.22" />
                                                                        <label for="pay_date">Paid Date</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="pickup_address" value="1.23" />
                                                                        <label for="pickup_address">Pickup Address</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="del_address" value="1.24" />
                                                                        <label for="del_address">Delivery Address</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="due_date" value="1.25" />
                                                                        <label for="due_date">Due Date</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="dispatch" value="1.26" />
                                                                        <label for="dispatch">Dispatch Date</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="pick_date" value="1.27" />
                                                                        <label for="pick_date">Pickup Date</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="est_del_date" value="1.28" />
                                                                        <label for="est_del_date">Estimated Del. Date</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="act_del_date" value="1.29" />
                                                                        <label for="act_del_date">Actual Del. Date</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="towing" value="1.41" />
                                                                        <label for="towing">Towing Price</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="trans_fines" value="1.31" />
                                                                        <label for="trans_fines">Trans. Fines</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="trans_notes" value="1.32" />
                                                                        <label for="trans_notes">Trans. Notes</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="auction_price" value="1.33" />
                                                                        <label for="auction_price">Auction Price</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="auc_fines" value="1.34" />
                                                                        <label for="auc_fines">Auction Fines</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="draft" value="1.35" />
                                                                        <label for="draft">Draft Expenses</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="occean_freight" value="1.42" />
                                                                        <label for="occean_freight">Occean Freight</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="weight" value="1.36" />
                                                                        <label for="weight">Weight</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="document" value="1.37" />
                                                                        <label for="document">Documents</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="image" value="1.38" />
                                                                        <label for="image">Images</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="reminder" value="1.39" />
                                                                        <label for="reminder">Reminder</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access add-vehicle" id="send_buyers" value="1.40" />
                                                                        <label for="send_buyers">Send to Buyers</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row">
                                                                    <label for="" class="offset-md-2 col-md-3">Vehicles List</label>
                                                                    <div class="col-md-7">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="list-vehicle" value="2" />
                                                                        <label for="list-vehicle">Enable</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row">
                                                                    <label for="" class="offset-md-2 col-md-3">Containers List</label>
                                                                    <div class="col-md-7">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="list-container" value="3" />
                                                                        <label for="list-container">Enable</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row">
                                                                    <label for="" class="offset-md-2 col-md-3">Add New Container</label>
                                                                    <div class="col-md-7">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="add-container" value="4" />
                                                                        <label for="add-container">Enable</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row">
                                                                    <label for="" class="offset-md-2 col-md-3">Financial System</label>
                                                                    <div class="col-md-7">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="view-financial" value="5.1" />
                                                                        <label for="view-financial">View only</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="edit-financial" value="5.2" />
                                                                        <label for="edit-financial">View and Edit</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row">
                                                                    <label for="" class="offset-md-2 col-md-3">Pickup History</label>
                                                                    <div class="col-md-7">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="view-pickup" value="6.1" />
                                                                        <label for="view-pickup">View only</label><br>
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="edit-pickup" value="6.2" />
                                                                        <label for="edit-pickup">View and Edit</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row">
                                                                    <label for="" class="offset-md-2 col-md-3">System Configurations</label>
                                                                    <div class="col-md-7">
                                                                        <input type="checkbox" name="access[]" class="py-2 rounded-end-4 access" id="system-configuration" value="7" />
                                                                        <label for="system-configuration">Enable</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="d-flex justify-content-center mt-4">
                                                    <button class="btn btn-primary px-5" type="submit">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">
                            <div class="d-flex gap-2 align-items-center page-icon">
                                @php
                                    $prev = (int)$page - 1;
                                    $next = (int)$page + 1;
                                    $pre = 'page='.$prev;
                                    $nex = 'page='.$next;
                                @endphp
                                <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/system-configuration/admin-levels?'.$pre) }}" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </a>
                                <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                                <a class="btn" @if(count($levels) < 10) href="javascript:void();" @else href="{{ url('admin/system-configuration/admin-levels?'.$nex) }}" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col" class="fw-bold">Name</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$levels) > 0)
                                    @foreach(@$levels as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <p class=" text-fs-3">
                                                {{ @$value->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center float-end">
                                                <p class="fs-5 text-primary me-3">
                                                    <i class="fa-solid fa-edit edit" data-id="{{ @$value->id }}" data-access='{{ @$value->access }}' style="cursor: pointer;"></i>
                                                </p>
                                                <p class="fs-5 text-danger">
                                                    <i class="fa-solid fa-circle-xmark delete" data-url="{{ url('admin/system-configuration/admin-levels/delete', @$value->id) }}" style="cursor: pointer;"></i>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                        <td class="text-center" colspan="3">
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
                                            <button id="delete-link" type="button" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5">Ok</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-warning border-0 mt-4 col-md-12 rounded-3 fs-5"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
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
        $(document).ready(function () {
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

            $(document).on("click", "#all", function () {
                if ($(this).is(":checked")) {
                    $(".add-vehicle").attr("disabled", true);
                    $(".add-vehicle").removeAttr("name");
                } else {
                    $(".add-vehicle").attr("disabled", false);
                    $(".add-vehicle").attr("name", "access[]");
                }
            });

            $(document).on("click", ".add", function () {
                
                $("#modalLabel").text("Add New Admin Level");
                $("#name").val('');
                $(".access").attr("checked", false);

                $("#modal").modal("show");
                $(".form").attr("action", "{{ url('admin/system-configuration/admin-levels/add') }}");
                        
            });

            $(document).on("click", ".edit", function () {
                var id = $(this).attr("data-id");
                var access = $(this).attr("data-access");
                if (access !== "all") {
                    access = JSON.parse(access);
                }

                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/system-configuration/admin-levels/edit') }}/"+id,
                    success: function (res) {
                        res = JSON.parse(res);
                        console.log(res);
                        if (res.success == true) {
                            $("#modalLabel").text("Edit Admin Level");
                            $("#name").val(res.data.name);
                            if (access == "all") {
                                $("#access").css("display", "none");
                            } else {
                                $("#access").css("display", "block");
                                $(access).each(function (key, value) {
                                    $('.access').each(function (k, v) {
                                        if (v.value == value) {
                                            $(v).attr("checked", true);
                                        }
                                    });
                                });
                                if ($("#all").is(":checked")) {
                                    $(".add-vehicle").attr('disabled', true);
                                    $(".add-vehicle").removeAttr("name");
                                }    
                            }

                            $("#modal").modal("show");
                            $(".form").attr("action", "{{ url('admin/system-configuration/admin-levels/edit') }}/"+id);
                        }
                    }
                });
            });

            $(document).on("click", ".delete", function () {
                $("#delete-link").attr("data-url", $(this).attr('data-url'));
                $("#removeRowModal").modal("show");
            });
            $(document).on("click", "#delete-link", function () {
                $.ajax({
                    type: "GET",
                    url: $(this).attr("data-url"),
                    success: function (res) {
                        res = JSON.parse(res);
                        $("#removeRowModal").modal("hide");
                        if (res.success == true) {
                            toastr["success"](res.msg, "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>

@endsection