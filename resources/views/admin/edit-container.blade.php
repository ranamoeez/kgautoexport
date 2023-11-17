@extends('layouts.admin')

@section('title')
    Edit Container
@endsection

@section('content')
    
    <style type="text/css">
        body {
            overflow-y: hidden;
        }
        .select2-selection {
            min-height: 37px;
        }
        .img-show img {
            height: 550px !important;
        }
    </style>
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Edit container
                </h4>
                <div class="d-flex justify-content-end">
                    <div class="mt-6 px-14">
                        <div class="financial-btn">
                            <button class="btn btn-primary border border-1 fs-5 quickbook" type="button" data-url="{{ url('admin/create-invoice', $container->id) }}">
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
                                    <input type="text" class="form-control" name="booking_no" value="{{ $container->booking_no }}" required="" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Shipper</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="shipper_id">
                                        <option value=""></option>
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
                                <label for="" class="col-md-3 col-form-label fw-semibold">Forwarding Agent</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="fowarding_agent_id">
                                        <option value=""></option>
                                        @if(count(@$all_fowarding_agent) > 0)
                                        @foreach(@$all_fowarding_agent as $key => $value)
                                            @if($value['id'] == @$container->fowarding_agent_id)
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
                                        <option value=""></option>
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
                                <label for="" class="col-md-3 col-form-label fw-semibold">Loading Request</label>
                                <div class="col-md-9">
                                    <input type="text" name="loading_request" value="{{ $container->loading_request }}" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Doc Cutoff</label>
                                <div class="col-md-9">
                                    <input type="text" name="cut_off" value="{{ $container->cut_off }}" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Port Cutoff</label>
                                <div class="col-md-9">
                                    <input type="text" name="port_cut_off" value="{{ $container->port_cut_off }}" class="form-control datepicker" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-4 pt-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Container No.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="container_no" value="{{ $container->container_no }}" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Consignee</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="consignee_id">
                                        <option value=""></option>
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
                                    <input type="text" class="form-control" name="vessel_name" value="{{ $container->vessel_name }}" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="location" value="{{ $container->location }}" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Destination
                                    Port</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="destination_port_id">
                                        <option value=""></option>
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
                            <div class="form-group mt-2">
                                <label for="notes" class="fw-semibold">Notes</label>
                                <textarea name="notes" cols="10" rows="4" class="form-control">{{ @$container->notes }}</textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label for="notes" class="fw-semibold">Shipping Notes</label>
                                <textarea name="shipping_notes" cols="10" rows="4" class="form-control">{{ @$container->shipping_notes }}</textarea>
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
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Departure</label>
                                <div class="col-sm-9">
                                    <input type="text" name="departure" value="{{ $container->departure }}" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Arrival</label>
                                <div class="col-sm-9">
                                    <input type="text" name="arrival" value="{{ $container->arrival }}" class="form-control datepicker" />
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <label for="" class="col-md-3 col-form-label fw-semibold pt-0">Released Status</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio1" type="radio" name="released_status"
                                            class="form-check-input" value="No" @if($container->released_status == "No") checked @endif />
                                        <label for="radio1" class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio2" type="radio" name="released_status"
                                            class="form-check-input" value="In hand" @if($container->released_status == "In hand") checked @endif />
                                        <label for="radio2" class="form-check-label">In hand</label>
                                    </div>
                                </div>
                                @if(!empty(@$container->in_hand_date))
                                <label for="" class="col-md-3 col-form-label fw-semibold pt-0">Released Date</label>
                                <span class="text-fs-4 col-md-9" style="font-size: 14px;">{{ date("M d, Y", strtotime(@$container->in_hand_date)) }}</span>
                                @endif
                            </div>
                            <div class="form-group row mt-3">
                                <label for="" class="col-md-3 col-form-label fw-semibold pt-0">Unloaded Status</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio3" type="radio" name="unloaded_status"
                                            class="form-check-input" value="No" @if($container->unloaded_status == "No") checked @endif />
                                        <label for="radio3" class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio4" type="radio" name="unloaded_status"
                                            class="form-check-input" value="Yes" @if($container->unloaded_status == "Yes") checked @endif />
                                        <label for="radio4" class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Shipper information</h3>
                        <div class="mt-4">
                            <div class="form-group row px-4">
                                <label for="notes" class="fw-semibold">Shipper information</label>
                                <div class="shipper-info p-3 row mt-2" style="border: 1px solid black; border-radius: 10px;">
                                @if(!empty(@$container->shipper))
                                    <div class="col-md-4">
                                        <p class="mb-1">Company Name:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->shipper->company_name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Address:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->shipper->address }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Phone Number:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->shipper->phone_number }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Fax:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->shipper->fax }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">E-mail:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->shipper->email }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0">Contact Person:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-0">{{ $container->shipper->contact_person }}</p>
                                    </div>
                                @endif
                                </div>
                            </div>
                            <div class="form-group mt-4 row px-4">
                                <label for="notes" class="fw-semibold">Forwarding agent information</label>
                                <div class="forwarding-agent-info p-3 row mt-2" style="border: 1px solid black; border-radius: 10px;">
                                @if(!empty(@$container->forwarding_agent))
                                    <div class="col-md-4">
                                        <p class="mb-1">Company Name:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->forwarding_agent->company_name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Address:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->forwarding_agent->address }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Phone Number:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->forwarding_agent->phone_number }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Fax:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->forwarding_agent->fax }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">E-mail:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->forwarding_agent->email }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0">Contact Person:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-0">{{ $container->forwarding_agent->contact_person }}</p>
                                    </div>
                                @endif
                                </div>
                            </div>
                            <div class="form-group mt-4 row px-4">
                                <label for="notes" class="fw-semibold">Consignee information</label>
                                <div class="consignee-info p-3 row mt-2" style="border: 1px solid black; border-radius: 10px;">
                                @if(!empty(@$container->consignee))
                                    <div class="col-md-4">
                                        <p class="mb-1">Company Name:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->consignee->company_name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Address:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->consignee->address }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Phone Number:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->consignee->phone_number }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Fax:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->consignee->fax }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">E-mail:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-1">{{ $container->consignee->email }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0">Contact Person:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-0">{{ $container->consignee->contact_person }}</p>
                                    </div>
                                @endif
                                </div>
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
                                    <input type="text" name="export_reference" value="{{ $container->export_reference }}" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Date for letter of
                                    intent</label>
                                <div class="col-md-9">
                                    <input type="text" name="date_for_letter" value="{{ $container->date_for_letter }}" class="form-control datepicker" />
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
                            <label for="" class="col-md-2 col-form-label fw-semibold">Image</label>
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
                        <div class="row mb-4 container-images">
                            @if(count(@$container->container_documents) > 0)
                            @foreach(@$container->container_documents as $key => $value)
                            @if($value->title == "images")
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-image fa-solid fs-4"></i>
                                        </div>
                                        <div>
                                            <button class="btn btn-link p-0 delete-images" type="button" data-url="{{ url('admin/delete-container-documents', $value->id) }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                            <a href="javascript:void();" data-src="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filepath.$value->filename }}" class="download-files">
                                                <i class="fas fa-download text-dark"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filepath.$value->filename }}" class="w-100 rounded-4 veh_img" style="height: 160px;" alt="" data-code="{{ $value->id }}" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif
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
                            @if(count(@$container->container_documents) > 0)
                            @foreach($container->container_documents as $key => $value)
                            @if($value->title !== "images")
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-file-pdf fa-solid fs-4"></i>
                                        </div>
                                        <div>
                                            <button class="btn btn-link p-0 delete-documents" type="button" data-url="{{ url('admin/delete-container-documents', $value->id) }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                            <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filepath.$value->filename }}" target="_blank" download>
                                                <i class="fas fa-download text-dark"></i>
                                            </a>
                                            <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filepath.$value->filename }}" target="_blank">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <object data="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filepath.$value->filename }}" style="width: 100%; height: 100% !important;">
                                            Alt : <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filepath.$value->filename }}">test.pdf</a>
                                        </object>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-4">
                            <div class="col-md-9">
                                <div class="d-flex flex-row shadow-lg border border-0">
                                    <input type="text" name="notes_document" value="{{ $container->notes_document }}" class="form-control text-fs-3 p-3 m-0"
                                        placeholder="Input" />
                                    {{-- <button class="btn btn-sm btn-primary float-end comment-btn fs-6 border-0" type="button">
                                        Save
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-9">
                                <button class="btn btn-primary mb-2 border-0 add-new-buyer" type="button">
                                    Add new buyer
                                </button>

                                <!-- Modal -->
                                <div class="modal fade new buyer" id="addNewBuyerModal" tabindex="-1"
                                    aria-labelledby="addNewBuyerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog rounded-5">
                                        <div class="modal-content p-3" style="min-width: 700px;">
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
                                                        <select class="select2js form-select buyers" aria-label="Default select example">
                                                            <option value="0" selected>Select Buyer</option>
                                                            @if(count(@$all_buyer) > 0)
                                                            @foreach(@$all_buyer as $key => $value)
                                                                <option value="{{ @$value['id'] }}">{{ @$value['name'].' ('.@$value['surname'].')' }}</option>
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
                                                        <p class="col-lg-6 text-fs-3 fw-bold">Description</p>
                                                        <p class="col-lg-4 text-fs-3 fw-bold">VIN</p>
                                                        <p class="col-lg-2 text-fs-3 fw-bold text-center">Select</p>
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
                                {{-- <button class="btn btn-primary mb-2 border-0" type="button">
                                    Send release request
                                </button> --}}
                                <br>
                                <a href="{{ url('admin/loading-order', $container->id) }}" class="btn btn-primary mb-2 border-0">
                                    Loading Order
                                </a>
                                <a href="{{ url('admin/letter', $container->id) }}" class="btn btn-primary mb-2 border-0">
                                    Letter ()
                                </a>
                                <button class="btn btn-primary mb-2 border-0" type="button" id="send-buyer">
                                    Send to buyer
                                </button>
                            </div>
                        </div>
                    </div>

                    @if(count(@$buyers) > 0)
                    @foreach($buyers as $key => $value)
                        <div class="col-md-6 card mt-3 px-0 mx-1">
                            <div class="card-header d-flex justify-content-between pt-3">
                                <p style="font-size: 18px;"><b>{{ @$value->user->name }}</b></p>
                                <i class="fa-solid fa-circle-minus text-danger fs-3 delete-buyer" data-url="{{ url('admin/delete-buyer/'.$container->id.'/'.@$value->user->id) }}" style="cursor: pointer;"></i>
                            </div>
                            <div class="card-body pt-3">
                                <div class="row shadow border rounded-5 w-100 mb-3 p-2 mx-1">
                                    <div class="col text-fs-3 fw-bold text-center">Description</div>
                                    <div class="col text-fs-3 fw-bold text-center">VIN</div>
                                    <div class="col text-fs-3 fw-bold text-center">Select</div>
                                </div>
                                @foreach($value->vehicles as $k => $v)
                                <div class="row shadow border rounded-5 w-100 mb-3 p-2 mx-1">
                                    <div class="col text-fs-3 text-center">{{ @$v->vehicle->modal.' '.@$v->vehicle->company_name.' '.@$v->vehicle->name }}</div>
                                    <div class="col text-fs-3 text-center">{{ $v->vehicle->vin }}</div>
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <i class="fa-solid fa-circle-minus text-danger fs-3 delete-buyer" data-url="{{ url('admin/delete-buyer-vehicle/'.@$container->id.'/'.@$value->user->id.'/'.@$v->vehicle->id) }}" style="cursor: pointer;"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @endif

                </div>
            </form>
            <div class="row mt-5">
                <div class="col-md-6">
                    <form method="POST" action="{{ url('admin/send-email') }}" class="d-flex align-items-center shadow mb-2 email-form">
                        <input type="hidden" name="container_id" value="{{ @$container->id }}">
                        <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
                        <div class="flex-grow-1">
                            <input type="email" id="default-search" class="form-control border border-1 rounded-2 p-2" placeholder="Enter Email to get details" name="sent_to" required />
                        </div>
                        <button type="submit" class="btn btn-primary border border-0 p-2 text-white">Send</button>
                    </form>
                    <h5 class="text-fs-4 fw-bold">Sent emails History</h5>
                    <div class="container-search p-3">
                        <div class="row shadow border rounded-5 w-100 mb-3 py-2">
                            <span class="col text-fs-3 fw-bold text-center">Email</span>
                            <span class="col text-fs-3 fw-bold text-center">Date</span>
                        </div>
                        @if(count(@$email_history) > 0)
                        @foreach(@$email_history as $key => $value)
                        <div class="row shadow border rounded-5 w-100 mb-3 py-2">
                            <span class="col text-fs-3 text-center">{{ @$value->sent_to }}</span>
                            <span class="col text-fs-3 text-center">{{ date("d-m-Y", strtotime(@$value->created_at)) }}</span>
                        </div>
                        @endforeach
                        @else
                        <div class="row shadow border rounded-5 w-100 mb-3 py-2">
                            <span class="col text-fs-3 text-center">No history found.</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade remove" id="removeRowModal" tabindex="-1"
                aria-labelledby="removeRowModalLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fw-bold" id="removeRowModalLabel"
                                style="font-size: 28px">
                                Delete this Record?</h1>
                            <button type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <button id="delete-link" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5" type="button">Ok</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-warning border-0 mt-4 col-md-12 rounded-3 fs-5" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="imageSliderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-end">
                            {{-- <div>
                                <button type="button" class="btn btn-secondary" id="zoomIn">+</button>
                                <button type="button" class="btn btn-secondary" id="zoomOut">-</button>
                            </div> --}}
                            <div class="close" style="cursor: pointer;">
                                <span aria-hidden="true" style="font-size: 20px;">&times;</span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <!-- Image slider container -->
                            <div id="imageSlider" class="carousel slide" data-ride="carousel">
                                <!-- Images will be dynamically loaded here -->
                                <div class="carousel-inner">
                                    <!-- Add your images here -->
                                    @if(count(@$container->container_documents) > 0)
                                    @foreach(@$container->container_documents as $key => $value)
                                    @if($value->title == "images")
                                    <div @if($key == "0") class="carousel-item active" @else class="carousel-item" @endif data-code="{{ $value->id }}">
                                        <img src="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filepath.$value->filename }}" alt="Image {{ $key+1 }}" style="width: 100%; height: 100%;">
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                    <!-- Add more images as needed -->
                                </div>
                                <!-- Left and right arrows for navigation -->
                                <a class="carousel-control-prev" href="#imageSlider" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#imageSlider" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
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
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
        });

        $(document).on("click", ".upload-documents", function () {
            $("#documents").click();
        });

        $(document).on("click", ".upload-images", function () {
            $("#images").click();
        });

        $(document).on("click", ".add-new-buyer", function () {
            $('.select2js').select2({
                dropdownParent: $('#addNewBuyerModal')
            });
            $("#addNewBuyerModal").modal('show');
            $("#addNewBuyerModal .select2.select2-container").css("width", "100%");
            $("#addNewBuyerModal .select2-selection").css("height", "40px");
            $("#addNewBuyerModal .select2-selection__arrow").css("display", "none");
        });

        $(document).on("click", ".quickbook", function () {
            $('.center-body').css('display', 'block');
            var url = $(this).attr('data-url');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data){
                    data = JSON.parse(data);
                    if (data.flag == true) {
                        toastr["success"](data.msg, "Completed!");
                    } else {
                        toastr["error"](data.msg, "Failed!");
                    }
                    $('.center-body').css('display', 'none');
                }
            });
        });

        $(document).on("click", ".veh_img", function () {
            var data_code = $(this).attr("data-code");
            console.log(data_code);
            $(".carousel-item").removeClass("active");
            $(".carousel-item[data-code='"+data_code+"']").addClass("active");
            $("#imageSliderModal").modal("show");
        });

        $(document).on("click", ".close", function () {
            $("#imageSliderModal").modal("hide");
        });

        $(document).on("click", ".download-files", function () {
            var imageUrl = $(this).attr("data-src");
            var name = imageUrl;
            var filename = "";
            if (name !== undefined && name !== "") {
                name = name.split('/');
                filename = name[$(name).length - 1];
            }

            fetch(imageUrl, {
                method: 'GET',
                mode: 'cors',
                cache: 'no-cache',
                headers: {
                    Origin: window.location.origin,
                },
            })
            .then(response => response.blob())
            .then(blob => {
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = filename;

                a.click();

                URL.revokeObjectURL(a.href);
            })
            .catch(error => {
                console.error('Image download failed:', error);
            });
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
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        $(document).on("click", ".delete-images", function () {
            var url = $(this).attr('data-url');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data){
                    data = JSON.parse(data);
                    if (data.success == true) {
                        $("#addNewBuyerModal").modal('hide');
                        toastr["success"]("Container image deleted successfully!", "Completed!");
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                }
            });
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

        $(document).on("click", "#send-buyer", function () {
            $('.center-body').css('display', 'block');
            $.ajax({
                type: 'GET',
                url: '{{ url("admin/send-to-cont-buyer", @$container->id) }}',
                success: function(data){
                    data = JSON.parse(data);
                    if (data.success == true) {
                        toastr["success"](data.msg, "Completed!");
                    } else {
                        toastr["error"](data.msg, "Failed!");
                    }
                    $('.center-body').css('display', 'none');
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
                        if (data.msg !== undefined) {
                            alert(data.msg);
                            toastr["success"]("New buyer is added successfully!", "Completed!");
                        } else {
                            toastr["success"]("New buyer is added successfully!", "Completed!");
                        }
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr["error"](data.msg, "Failed!");
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
                            var html = `<div class="row shadow w-100 mb-3 p-2 vehicle-data">
                                <input type="text" id="search-inp" class="form-control w-75" placeholder="Search vehicles">
                                <button type="button" class="btn btn-primary w-25" id="search-btn">Search</button>
                            </div>`;
                            $(".vehicles").append(html);
                            $(data.vehicles).each(function (key, value) {
                                var description = value.vehicle.modal;
                                if (value.vehicle.name !== null) {
                                    description += " "+value.vehicle.company_name;
                                }
                                if (value.vehicle.modal !== null) {
                                    description += " "+value.vehicle.name;
                                }
                                var html = `<div class="row shadow border rounded-5 w-100 mb-3 p-2 vehicle-data">
                                    <div class="col-lg-6 text-fs-3">${description}</div>
                                    <div class="col-lg-4 text-fs-3">${value.vehicle.vin}</div>
                                    <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                        <input class="form-check-input vehicle_id" id="vehicle_id" name="vehicle_id" type="checkbox"
                                            value="${value.vehicle.id}">
                                    </div>
                                </div>`;
                                $(".vehicles").append(html);
                            });
                        }
                    }
                    $(document).on("click", "#search-btn", function (event) {
                        var search = $("#search-inp").val();
                        
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('admin/get-vehicles') }}"+"/"+id+"?search="+search,
                            success: function(data){
                                data = JSON.parse(data);
                                $(".vehicle-data").remove();
                                if (data.success == true) {
                                    if (data.vehicles.length == 0) {
                                        var html = `<div class="row shadow w-100 mb-3 p-2 vehicle-data">
                                            <input type="text" id="search-inp" class="form-control w-75" placeholder="Search vehicles" value="${search}">
                                            <button type="button" class="btn btn-primary w-25" id="search-btn">Search</button>
                                        </div>
                                        <div class="row shadow border rounded-5 w-100 mb-3 p-2 vehicle-data">
                                            <div class="text-fs-3 text-center">No vehicle found</div>
                                        </div>`;
                                        $(".vehicles").append(html);
                                    } else {
                                        var html = `<div class="row shadow w-100 mb-3 p-2 vehicle-data">
                                            <input type="text" id="search-inp" class="form-control w-75" placeholder="Search vehicles" value="${search}">
                                            <button type="button" class="btn btn-primary w-25" id="search-btn">Search</button>
                                        </div>`;
                                        $(".vehicles").append(html);
                                        $(data.vehicles).each(function (key, value) {
                                            var description = value.vehicle.modal;
                                            if (value.vehicle.name !== null) {
                                                description += " "+value.vehicle.company_name;
                                            }
                                            if (value.vehicle.modal !== null) {
                                                description += " "+value.vehicle.name;
                                            }
                                            var html = `<div class="row shadow border rounded-5 w-100 mb-3 p-2 vehicle-data">
                                                <div class="col-lg-6 text-fs-3">${description}</div>
                                                <div class="col-lg-4 text-fs-3">${value.vehicle.vin}</div>
                                                <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                                    <input class="form-check-input vehicle_id" id="vehicle_id" name="vehicle_id" type="checkbox"
                                                        value="${value.vehicle.id}">
                                                </div>
                                            </div>`;
                                            $(".vehicles").append(html);
                                        });
                                    }
                                }
                            }
                        });
                    });
                }
            });
        });

        $(document).on("submit", ".email-form", function (event) {
            event.preventDefault();
            $('.center-body').css('display', 'block');
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
                        toastr["success"](res.msg, "Complete!");

                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr["error"](res.msg, "Failed!");
                    }
                    $('.center-body').css('display', 'none');
                }
            });
        });

        $(document).on("submit", ".form", function (event) {
            $('.center-body').css('display', 'block');
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
                    $('.center-body').css('display', 'none');
                }
            });
        });

        $(document).on("click", ".delete-buyer", function () {
            $("#delete-link").attr("data-url", $(this).attr('data-url'));
            $("#removeRowModal").modal("show");
        });
        $(document).on("click", "#delete-link", function () {
            $.ajax({
                type: 'GET',
                url: $(this).attr('data-url'),
                success: function(data){
                    data = JSON.parse(data);
                    if (data.success == true) {
                        $("#removeRowModal").modal("hide");
                        toastr["success"]("Deleted successfully!", "Completed!");
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                }
            });
        });
    </script>

    {{-- <script src="{{ asset('js/jquery.popup.lightbox.js') }}"></script>
    <link href="{{ asset('css/popup-lightbox.css') }}" rel="stylesheet" />

    <script>
        $(document).ready(function(){

            $(".container-images").popupLightbox({
                width: 1300,
                height: 900
            });

        });
    </script> --}}

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            var currentZoom = 1.0; // Initial zoom level
            var zoomIncrement = 0.1; // Zoom level change on each click

            // Initialize the modal with the image slider
            $('#imageSliderModal').on('show.bs.modal', function () {
                $('#imageSlider').carousel({
                    interval: false, // Prevent auto sliding
                    autoPlay: false
                });
            });

            // Zoom In button click event
            $('#zoomIn').click(function () {
                currentZoom += zoomIncrement;
                updateZoom();
            });

            // Zoom Out button click event
            $('#zoomOut').click(function () {
                currentZoom -= zoomIncrement;
                updateZoom();
            });

            // Function to update the zoom level
            function updateZoom() {
                var image = $('.carousel-item.active img');
                image.css('transform', 'scale(' + currentZoom + ')');
                image.css('transform-origin', '0 0'); // Set the transform origin to the top-left corner
            }
        });
    </script>

@endsection