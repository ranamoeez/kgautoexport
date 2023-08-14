@extends('layouts.admin')

@section('title')
    Edit Container
@endsection

@section('content')
    
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Edit container
                </h4>
                <div class="d-flex justify-content-end">
                    <div class="mt-6 px-14">
                        <div class="financial-btn">
                            <button class="btn btn-primary border border-1 fs-5">
                                Quick book
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ @$action }}" class="make_ajax">
                @csrf
                <div class="row mt-4">
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Container information</h3>
                        <div class="mt-4">
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Booking No.</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="booking_no" value="{{ $container->booking_no }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Shipper</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="shipper_id">
                                        @if(count(@$all_shipper) > 0)
                                        @foreach(@$all_shipper as $key => $value)
                                            @if($value['id'] == @$container->shipper_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['company_name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['company_name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Shipping Line</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="shipping_line_id">
                                        @if(count(@$all_shipping_line) > 0)
                                        @foreach(@$all_shipping_line as $key => $value)
                                            @if($value['id'] == @$container->shipping_line_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Loading Port</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="loading_port_id">
                                        @if(count(@$all_loading_port) > 0)
                                        @foreach(@$all_loading_port as $key => $value)
                                            @if($value['id'] == @$container->loading_port_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Cut off</label>
                                <div class="col-md-9">
                                    <input type="date" name="cut_off" value="{{ $container->cut_off }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-4 pt-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Container No.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="container_no" value="{{ $container->container_no }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Consignee</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="consignee_id">
                                        @if(count(@$all_consignee) > 0)
                                        @foreach(@$all_consignee as $key => $value)
                                            @if($value['id'] == @$container->consignee_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['company_name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['company_name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Vessel Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="vessel_name" value="{{ $container->vessel_name }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="location" value="{{ $container->location }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Destination
                                    Port</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="destination_port_id">
                                        @if(count(@$all_destination_port) > 0)
                                        @foreach(@$all_destination_port as $key => $value)
                                            @if($value['id'] == @$container->destination_port_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Departure</label>
                                <div class="col-sm-9">
                                    <input type="date" name="departure" value="{{ $container->departure }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Additional info</h3>
                        <div class="mt-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="status_id">
                                        @if(count(@$all_status) > 0)
                                        @foreach(@$all_status as $key => $value)
                                            @if($value['id'] == @$container->status_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Seal No.</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="seal_no" value="{{ $container->seal_no }}" placeholder="Enter a number"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Notify Party</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="notify_part_id">
                                        @if(count(@$all_notify_party) > 0)
                                        @foreach(@$all_notify_party as $key => $value)
                                            @if($value['id'] == @$container->notify_part_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Arrival</label>
                                <div class="col-sm-9">
                                    <input type="date" name="arrival" value="{{ $container->arrival }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Shipper information</h3>
                        <div class="mt-4">
                            <div class="form-group row">
                                <label for="notes" class="fw-semibold">Shipper information</label>
                                <textarea name="notes" cols="10" rows="8"
                                    class="form-control shadow-lg bg-white"
                                    placeholder="Company name: K&G Auto Export Inc Address: 3361 W Vine Street STE# 208 Kissimmee, FL 34741 Phone number: 912-921-4443 Fax: 912-216-0011E-mail: info@kgautoexport.com Contact person: Anna MedvedevaAES Number XTN:"
                                    disabled></textarea>
                            </div>
                            <div class="form-group mt-4 row">
                                <label for="notes" class="fw-semibold">Consignee information</label>
                                <textarea name="notes" cols="10" rows="10"
                                    class="form-control shadow-lg bg-white"
                                    placeholder="Company name: KARAM AL SHARQ FOR STORING AND CARS TRADE Address: SAMI AL BAROUDI STREET, KHELDA MALL, 3RD FLOOR, OFF# 12 AMMAN, JORDA Phone number: 96265338818 Fax: 96265339400 E-mail: hamdoon@karamalsharq.com Contact person: Hamdoon Al Ani"
                                    disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row mt-4 pt-5">
                    <div class="col-md-4">
                        <div class="mt-4">
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Export
                                    reference</label>
                                <div class="col-md-9">
                                    <input type="text" name="export_reference" value="{{ $container->export_reference }}" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Date for letter of
                                    intent</label>
                                <div class="col-md-9">
                                    <input type="date" name="date_for_letter" value="{{ $container->date_for_letter }}" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Discharge port</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="discharge_port_id">
                                        @if(count(@$all_discharge_port) > 0)
                                        @foreach(@$all_discharge_port as $key => $value)
                                            @if($value['id'] == @$container->discharge_port_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mt-4">
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Measurement</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="measurement_id">
                                        @if(count(@$all_measurement) > 0)
                                        @foreach(@$all_measurement as $key => $value)
                                            @if($value['id'] == @$container->measurement_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Payment status</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="all_paid">
                                        <option value="0" @if($container->all_paid == '0') selected @endif>Unpaid</option>
                                        <option value="1" @if($container->all_paid == '1') selected @endif>Paid</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row mt-4 pt-5">
                    <div class="col-md-6">
                        <div class="row mb-4">
                            <div class="col-md-9">
                                <div class="d-flex flex-row shadow-lg border border-0">
                                    <input type="text" name="notes_document" value="{{ $container->notes_document }}" class="form-control text-fs-3 p-3 m-0"
                                        placeholder="Input" />
                                    <button class="btn btn-sm btn-primary float-end comment-btn fs-6 border-0" type="button">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-9">
                                <button class="btn btn-primary mb-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#addNewBuyerModal" type="button">
                                    Add new buyer
                                </button>

                                <!-- Modal -->
                                <div class="modal fade new buyer" id="addNewBuyerModal" tabindex="-1"
                                    aria-labelledby="addNewBuyerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog rounded-5">
                                        <div class="modal-content p-3">
                                            <div class="modal-header border-0">
                                                <h1 class="modal-title fw-bold" id="addNewBuyerModalLabel"
                                                    style="font-size: 28px">
                                                    Add New Buyer</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mt-4">
                                                    <label for="choose form"
                                                        class="col-md-4 fs-5 fw-bold">Choose Form</label>
                                                    <div class="col-md-8">
                                                        <select class="form-select buyers" aria-label="Default select example">
                                                            <option value="0" selected>Select Buyer</option>
                                                            @if(count(@$all_buyer) > 0)
                                                            @foreach(@$all_buyer as $key => $value)
                                                                <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="p-3 mt-4 vehicles">
                                                    <div class="row shadow border rounded-5 w-100 mb-3">
                                                        <p class="col text-fs-3 fw-bold text-center">Buyer
                                                            Vehicles</p>
                                                        <p class="col text-fs-3 fw-bold text-center">Most Recent
                                                        </p>
                                                    </div>
                                                    <div class="row shadow border rounded-5 w-100 mb-3">
                                                        <p class="col text-fs-3 fw-bold text-center">VIN</p>
                                                        <p class="col text-fs-3 fw-bold text-center">Description
                                                        </p>
                                                        <p class="col text-fs-3 fw-bold text-center">Select</p>
                                                    </div>
                                                </div>
                                                <button class="btn w-auto btn-primary border-0 mt-2 col-md-12 rounded-3 fs-6 add-vehicles" data-id="{{ $container->id }}" type="button">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mb-2 border-0">
                                    Save
                                </button>
                                <a href="{{ url('admin/containers') }}" class="btn btn-primary mb-2 border-0">
                                    Cancel
                                </a>
                                <button class="btn btn-primary mb-2 border-0" type="button">
                                    Send release request
                                </button>
                                <button class="btn btn-primary mb-2 border-0" type="button">
                                    Loading Order
                                </button>
                                <button class="btn btn-primary mb-2 border-0" type="button">
                                    Letter ()
                                </button>
                                <button class="btn btn-primary mb-2 border-0" type="button">
                                    Send to buyer
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-4">
                            <label for="" class="col-md-2 col-form-label fw-semibold">Documents</label>
                            <div class="col-md-10 d-flex flex-row shadow-lg px-0">
                                <input type="file" class="fbg-white border-0 form-control" name="documents[]" id="documents" aria-label="upload" accept=".pdf, .csv, .xlsx, .doc, .docx, .txt" multiple>
                                <button class="btn btn-primary rounded upload-documents" type="button">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="22"
                                            viewBox="0 0 19 22" fill="none">
                                            <path
                                                d="M13.0253 0.170898H6.05884C5.10095 0.170898 4.31722 0.954626 4.31722 1.91252V15.8455C4.31722 16.8033 5.10095 17.5871 6.05884 17.5871H16.5085C17.4664 17.5871 18.2502 16.8033 18.2502 15.8455V5.39575L13.0253 0.170898ZM16.5085 15.8455H6.05884V1.91252H12.1545V6.26656H16.5085V15.8455ZM2.5756 3.65413V19.3287H16.5085V21.0703H2.5756C1.61771 21.0703 0.833984 20.2866 0.833984 19.3287V3.65413H2.5756ZM7.80046 8.87899V10.6206H14.7669V8.87899H7.80046ZM7.80046 12.3622V14.1038H12.1545V12.3622H7.80046Z"
                                                fill="white" />
                                        </svg>
                                        <span class="">Choose</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-4">
                            @if(count(@$container->container_documents) > 0)
                            @foreach($container->container_documents as $key => $value)
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-file-pdf fa-solid fs-4"></i>
                                        </div>
                                        <button class="btn btn-link p-0 delete-documents" type="button" data-url="{{ url('admin/delete-container-documents', $value->id) }}">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ asset('assets/file.png') }}" class="w-100" style="height: 140px;" alt="" />
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(() => {
            $('.selectjs').select2();
        })
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
        });

        $(document).on("click", ".upload-documents", function () {
            $("#documents").click();
        });

        $(document).on("click", ".delete-documents", function () {
            var url = $(this).attr('data-url');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data){
                    data = JSON.parse(data);
                    if (data.success == true) {
                        $("#addNewBuyerModal").modal('hide');
                        toastr["success"]("Container document deleted successfully!", "Completed!");
                    }
                }
            });
        });

        $(document).on("click", ".add-vehicles", function () {
            var checked = [];
            $(".vehicle_id:checked").each(function (key, value) {
                checked.push($(value).val());
            });

            var form = new FormData();
            form.append("vehicle_id", checked.join(','));
            form.append("user_id", $(".buyers option:selected").val());
            form.append("container_id", $(this).attr("data-id"));

            $.ajax({
                type: 'POST',
                url: "{{ url('admin/assign-vehicle') }}",
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
                        toastr["success"]("New buyer is added successfully!", "Completed!");
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        $(document).on("change", ".buyers", function () {
            var id = $(this).find('option:selected').val();

            $.ajax({
                type: 'GET',
                url: "{{ url('admin/get-vehicles') }}"+"/"+id,
                success: function(data){
                    data = JSON.parse(data);
                    $(".vehicle-data").remove();
                    if (data.success == true) {
                        if (data.vehicles.length == 0) {
                            var html = `<div class="row shadow border rounded-5 w-100 mb-3 p-2 vehicle-data">
                                <div class="text-fs-3 text-center">No vehicle found</div>
                            </div>`;
                            $(".vehicles").append(html);
                        } else {
                            $(data.vehicles).each(function (key, value) {
                                var html = `<div class="row shadow border rounded-5 w-100 mb-3 p-2 vehicle-data">
                                    <div class="col text-fs-3 text-center">`+value.vehicle.vin+`</div>
                                    <div class="col text-fs-3 text-center">`+value.vehicle.description+`</div>
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <input class="form-check-input vehicle_id" id="vehicle_id" name"vehicle_id" type="checkbox"
                                            value="`+value.vehicle.id+`">
                                    </div>
                                </div>`;
                                $(".vehicles").append(html);
                            });
                        }
                    }
                }
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