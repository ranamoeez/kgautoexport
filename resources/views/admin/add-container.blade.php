@extends('layouts.admin')

@section('title')
    Add Container
@endsection

@section('content')
    
    <style type="text/css">
        body {
            overflow-y: hidden;
        }
        .select2-selection {
            min-height: 37px;
        }
    </style>
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Add a new container
                </h4>
                <div class="d-flex justify-content-end">
                    <div class="mt-6 px-14">
                        <div class="financial-btn">
                            <button class="btn btn-primary border border-1 fs-5" disabled>
                                Quick book
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ @$action }}" class="form">
                @csrf
                <div class="row mt-4">
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Container information</h3>
                        <div class="mt-4">
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Booking No.</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="booking_no" required="" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Shipper</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="shipper_id">
                                        <option value=""></option>
                                        @if(count(@$all_shipper) > 0)
                                        @foreach(@$all_shipper as $key => $value)
                                            @if($value['id'] == @$shipper)
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
                                <label for="" class="col-md-3 col-form-label fw-semibold">Forwarding Agent</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="fowarding_agent_id">
                                        <option value=""></option>
                                        @if(count(@$all_fowarding_agent) > 0)
                                        @foreach(@$all_fowarding_agent as $key => $value)
                                            @if($value['id'] == @$fowarding_agent)
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
                                        <option value=""></option>
                                        @if(count(@$all_shipping_line) > 0)
                                        @foreach(@$all_shipping_line as $key => $value)
                                            @if($value['id'] == @$shipping_line)
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
                                        <option value=""></option>
                                        @if(count(@$all_loading_port) > 0)
                                        @foreach(@$all_loading_port as $key => $value)
                                            @if($value['id'] == @$loading_port)
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
                                <label for="" class="col-md-3 col-form-label fw-semibold">Loading Request</label>
                                <div class="col-md-9">
                                    <input type="text" name="loading_request" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Doc Cutoff</label>
                                <div class="col-md-9">
                                    <input type="text" name="cut_off" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Port Cutoff</label>
                                <div class="col-md-9">
                                    <input type="text" name="port_cut_off" class="form-control datepicker" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-4 pt-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Container No.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="container_no" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Consignee</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="consignee_id">
                                        <option value=""></option>
                                        @if(count(@$all_consignee) > 0)
                                        @foreach(@$all_consignee as $key => $value)
                                            @if($value['id'] == @$consignee)
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
                                    <input type="text" class="form-control" name="vessel_name" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="location" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Destination
                                    Port</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select destination_port" name="destination_port_id">
                                        <option value=""></option>
                                        @if(count(@$all_destination_port) > 0)
                                        @foreach(@$all_destination_port as $key => $value)
                                            @if($value['id'] == @$destination_port)
                                            <option data-discharge="{{ $value['discharge_port'] }}" value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option data-discharge="{{ $value['discharge_port'] }}" value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="notes" class="fw-semibold">Notes</label>
                                <textarea name="notes" cols="10" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label for="notes" class="fw-semibold">Shipping Notes</label>
                                <textarea name="shipping_notes" cols="10" rows="4" class="form-control"></textarea>
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
                                            @if($value['id'] == @$status)
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
                                    <input type="number" class="form-control" name="seal_no" placeholder="Enter a number"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Notify Party</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="notify_part_id">
                                        @if(count(@$all_notify_party) > 0)
                                        @foreach(@$all_notify_party as $key => $value)
                                            @if($value['id'] == @$notify_party)
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
                                    <input type="text" name="departure" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Arrival</label>
                                <div class="col-sm-9">
                                    <input type="text" name="arrival" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <label for="" class="col-md-3 col-form-label fw-semibold pt-0">Released Status</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio1" type="radio" name="released_status"
                                            class="form-check-input" value="No" checked />
                                        <label for="radio1" class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio2" type="radio" name="released_status"
                                            class="form-check-input" value="In hand" />
                                        <label for="radio2" class="form-check-label">In hand</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label for="" class="col-md-3 col-form-label fw-semibold pt-0">Unloaded Status</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio3" type="radio" name="unloaded_status"
                                            class="form-check-input" value="No" checked />
                                        <label for="radio3" class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio4" type="radio" name="unloaded_status"
                                            class="form-check-input" value="Yes" />
                                        <label for="radio4" class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Shipper information</h3>
                        <div class="mt-4">
                            <div class="form-group row">
                                <label for="notes" class="fw-semibold">Shipper information</label>
                                <textarea name="notes" cols="10" rows="8" class="form-control shadow-lg bg-white" disabled></textarea>
                            </div>
                            <div class="form-group mt-4 row">
                                <label for="notes" class="fw-semibold">Forwarding agent information</label>
                                <textarea name="notes" cols="10" rows="8" class="form-control shadow-lg bg-white" disabled></textarea>
                            </div>
                            <div class="form-group mt-4 row">
                                <label for="notes" class="fw-semibold">Consignee information</label>
                                <textarea name="notes" cols="10" rows="10" class="form-control shadow-lg bg-white" disabled></textarea>
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
                                    <input type="text" name="export_reference" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Date for letter of
                                    intent</label>
                                <div class="col-md-9">
                                    <input type="text" name="date_for_letter" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Discharge port</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select discharge_port" name="discharge_port_id">
                                        <option value=""></option>
                                        @if(count(@$all_discharge_port) > 0)
                                        @foreach(@$all_discharge_port as $key => $value)
                                            @if($value['id'] == @$discharge_port)
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
                                        <option value=""></option>
                                        @if(count(@$all_measurement) > 0)
                                        @foreach(@$all_measurement as $key => $value)
                                            @if($value['id'] == @$measurement)
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
                                        <option value="0">Unpaid</option>
                                        <option value="1">Paid</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row mt-4 pt-5">
                    <div class="col-md-6">
                        <div class="row mb-4">
                            <label for="" class="col-md-2 col-form-label fw-semibold">Images</label>
                            <div class="col-md-10 d-flex flex-row shadow-lg px-0">
                                <!--end::Input group-->
                                <input type="file" class="fbg-white border-0 form-control" name="images[]" id="images" aria-label="upload" accept=".png, .jpg, .jpeg" multiple>
                                <button class="btn btn-primary rounded upload-images" type="button">
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
                            <div class="col-md-9">
                                <div class="container container-car-image ms-5 mx-5">
                                    <div id="thumbnail-slider" class="splide mt-2">
                                        <div class="splide__track">
                                            <ul class="splide__list d-flex list-unstyled gap-2 all-images">
                                                {{-- <li>
                                                    <img src="{{ asset('assets/carphoto.png') }}" class="w-100"
                                                        alt="car-image" />
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/carphoto.png') }}" class="w-100"
                                                        alt="car-image" />
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/carphoto.png') }}" class="w-100"
                                                        alt="car-image" />
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/carphoto.png') }}" class="w-100"
                                                        alt="car-image" />
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-4">
                            <label for="" class="col-md-2 col-form-label fw-semibold">Documents</label>
                            <div class="col-md-10 d-flex flex-row shadow-lg px-0">
                                <input type="file" class="fbg-white border-0 form-control" name="documents[]" id="documents" aria-label="upload" accept=".pdf" multiple>
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
                            {{-- <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-file-pdf fa-solid fs-4 text-danger"></i>
                                            <span class="mb-0 fs-5 fw-semibold">Third Eye</span>
                                        </div>
                                        <button class="btn btn-link p-0">
                                            <i class="fas fa-ellipsis-v text-dark"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ asset('assets/carphoto.png') }}" class="w-100 h-100" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-file-pdf fa-solid fs-4 text-danger"></i>
                                            <span class="mb-0 fs-5 fw-semibold">Third Eye</span>
                                        </div>
                                        <button class="btn btn-link p-0">
                                            <i class="fas fa-ellipsis-v text-dark"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ asset('assets/carphoto.png') }}" class="w-100 h-100" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-file-pdf fa-solid fs-4 text-danger"></i>
                                            <span class="mb-0 fs-5 fw-semibold">Third Eye</span>
                                        </div>
                                        <button class="btn btn-link p-0">
                                            <i class="fas fa-ellipsis-v text-dark"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ asset('assets/carphoto.png') }}" class="w-100 h-100" alt="" />
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-4">
                            <div class="col-md-9">
                                <div class="d-flex flex-row shadow-lg border border-0">
                                    <input type="text" name="notes_document" class="form-control text-fs-3 p-3 m-0"
                                        placeholder="Input" />
                                    {{-- <button class="btn btn-sm btn-primary float-end comment-btn fs-6 border-0" type="button">
                                        Save
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-9">
                                <button class="btn btn-primary mb-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#addNewBuyerModal" type="button" disabled>
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
                                                        <select class="form-select"
                                                            aria-label="Default select example">
                                                            <option selected>Select Buyer</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="p-3 mt-4">
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
                                                    <div class="row shadow border rounded-5 w-100 mb-3 p-2">
                                                        <div class="col text-fs-3 text-center">55427687</div>
                                                        <div class="col text-fs-3 text-center">KIA2019</div>
                                                        <div
                                                            class="col d-flex justify-content-center align-items-center">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="flexCheckChecked" checked>
                                                        </div>
                                                    </div>
                                                    <div class="row shadow border rounded-5 w-100 mb-3 p-2">
                                                        <div class="col text-fs-3 text-center">55427687</div>
                                                        <div class="col text-fs-3 text-center">KIA2019</div>
                                                        <div
                                                            class="col d-flex justify-content-center align-items-center">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="flexCheckChecked">
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="#"
                                                    class="btn w-auto btn-primary border-0 mt-2 col-md-12 rounded-3 fs-6">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mb-2 border-0" id="submit-form">
                                    Save
                                </button>
                                <a href="{{ url('admin/containers/add') }}" class="btn btn-primary mb-2 border-0">
                                    Cancel
                                </a>
                                {{-- <button class="btn btn-primary mb-2 border-0" type="button">
                                    Send release request
                                </button> --}}
                                <br>
                                <button class="btn btn-primary mb-2 border-0" type="button" disabled>
                                    Loading Order
                                </button>
                                <button class="btn btn-primary mb-2 border-0" type="button" disabled>
                                    Letter ()
                                </button>
                                <button class="btn btn-primary mb-2 border-0" type="button" disabled>
                                    Send to buyer
                                </button>
                            </div>
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
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');

            $(document).on("submit", ".form", function (event) {
                $('.center-body').css('display', 'block');
                $('#submit-form').attr('disabled', true);
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
                                window.location.href = res.url;
                            }, 2000);
                        } else {
                            toastr["error"](res.msg, "Failed!");
                        }
                        $('#submit-form').attr('disabled', false);
                        $('.center-body').css('display', 'none');
                    }
                });
            });
        });

        $(document).on("click", ".upload-documents", function () {
            $("#documents").click();
        });

        $(document).on("click", "input[type='radio']", function () {
            if ($(this).attr('checked') == "checked") {
                $(this).prop('checked', false);
                $(this).attr('checked', false);
                $(this).parent().parent().find("input[type='radio']").attr("checked", false);
            } else {
                $(this).parent().parent().find("input[type='radio']").attr("checked", false);
                $(this).prop('checked', true);
                $(this).attr('checked', true);
            }
        });

        $(document).on("click", ".upload-images", function () {
            $("#images").click();
        });

        $(document).on("change", ".destination_port", function () {
            var port = $(this).find("option:selected").attr("data-discharge");
            $(".discharge_port").val(port).trigger("change");;
        });
    </script>

@endsection