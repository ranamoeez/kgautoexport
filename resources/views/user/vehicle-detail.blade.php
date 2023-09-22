@extends('layouts.user')

@section('content')

    <style type="text/css">
        .slick-prev:before, .slick-next:before {
            color: #003791 !important;
        } 
    </style>

    <div class="below-header-height outer-container">
        <div class="inner-container">
            <!-- Money transfer -->
            <div class="mt-5 d-flex flex-column flex-md-row justify-content-between container">
                <div class="row">
                    <div class="col-md align-items-center">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                            Photos
                        </h4>
                        <div class="col-md align-items-center">
                            <div class="d-flex justify-content-end">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active fs-5 fw-bold" id="warehouse-tab"
                                            data-bs-toggle="tab" data-bs-target="#warehouse" type="button">
                                            Warehouse
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fs-5 fw-bold btn" id="unloading-tab"
                                            data-bs-toggle="tab" data-bs-target="#unloading" type="button">
                                            Unloading
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md text-md-end mb-2 mb-md-0">
                        <button class="bg-white border-0 download" type="button">
                            <img src="{{ asset("assets/photos.png") }}" alt="" />
                        </button>
                    </div>
                    <div class="col-md mb-2 mb-md-0">
                        @if(\Auth::user()->role == "2")
                        <button class="text-nowrap btn btn-primary fw-semibold text-fs-3 border-0"
                            data-bs-toggle="modal" data-bs-target="#requestPickupModal" @if(@$list->vehicle->status_id !== 11) disabled @endif>
                            Request Pickup
                        </button>
                        @endif

                        <!-- Modal -->
                        <div class="modal fade" id="requestPickupModal" tabindex="-1"
                            aria-labelledby="requestPickupModalLabel" aria-hidden="true">
                            <div class="modal-dialog rounded-5">
                                <div class="modal-content p-3">
                                    <div class="modal-header border-0">
                                        <h1 class="modal-title fw-bold" id="requestPickupModalLabel"
                                            style="font-size: 28px">
                                            Request Pickup</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ url("user/add-pickup-request") }}" id="pickup-form">
                                            <div class="mt-4">
                                                <input type="text" name="comments" class="form-control text-fs-3 rounded pb-4"
                                                    placeholder="Add Comment" required />
                                            </div>
                                            <div class="mt-4">
                                                <div class="d-flex shadow p-1 bg-white rounded" role="upload">
                                                    <input type="hidden" name="vehicle_id" value="{{ @$list->vehicle_id }}">
                                                    <input type="file" class="form-control me-2 bg-white border-0 rounded fs-5" placeholder="Upload" name="file" aria-label="upload" id="images">
                                                    <button class="btn btn-primary rounded upload-images" type="button">
                                                        <div class="d-flex align-items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="19"
                                                                height="22" viewBox="0 0 19 22" fill="none">
                                                                <path
                                                                    d="M13.0253 0.170898H6.05884C5.10095 0.170898 4.31722 0.954626 4.31722 1.91252V15.8455C4.31722 16.8033 5.10095 17.5871 6.05884 17.5871H16.5085C17.4664 17.5871 18.2502 16.8033 18.2502 15.8455V5.39575L13.0253 0.170898ZM16.5085 15.8455H6.05884V1.91252H12.1545V6.26656H16.5085V15.8455ZM2.5756 3.65413V19.3287H16.5085V21.0703H2.5756C1.61771 21.0703 0.833984 20.2866 0.833984 19.3287V3.65413H2.5756ZM7.80046 8.87899V10.6206H14.7669V8.87899H7.80046ZM7.80046 12.3622V14.1038H12.1545V12.3622H7.80046Z"
                                                                    fill="white" />
                                                            </svg>
                                                            <span class="ms-2">Upload</span>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            <button class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Request Pickup</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="requestPickupConfirmModel" tabindex="-1"
                            aria-labelledby="requestPickupConfirmModelLabel" aria-hidden="true">
                            <div class="modal-dialog rounded-5">
                                <div class="modal-content p-3">
                                    <div class="modal-header border-0">
                                        <h1 class="modal-title fw-bold" id="requestPickupConfirmModelLabel"
                                            style="font-size: 28px">
                                            Request Pickup</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="border-0">
                                            <img src="{{ asset("assets/like.png") }}" alt="Like" />
                                        </div>
                                        <div class="card-body request-pickup-popup">
                                            <div class="mt-4">
                                                <h5 class="card-title fw-bold fs-2">Pick up Requested
                                                    <span>Successfully</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-2 mb-md-0">
                        @if(\Auth::user()->role == "2")
                        <button class="text-nowrap btn btn-primary fw-semibold text-fs-3 border-0"
                            data-bs-toggle="modal" data-bs-target="#postForSaleModel">
                            Post for Sale
                        </button>
                        @endif

                        <!-- Modal -->
                        <div class="modal fade" id="postForSaleModel" tabindex="-1"
                            aria-labelledby="postForSaleModelLabel" aria-hidden="true">
                            <div class="modal-dialog rounded-5">
                                <div class="modal-content p-3">
                                    <div class="modal-header border-0">
                                        <h1 class="modal-title fw-bold" id="postForSaleModelLabel" style="font-size: 28px">Post For Sale</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ url("user/add-post") }}" class="form">
                                            <div class="mt-4">
                                                <input type="hidden" name="user_id" value="{{ @$list->user_id }}">
                                                <input type="hidden" name="vehicle_id" value="{{ @$list->vehicle_id }}">
                                                <input type="number" class="form-control text-fs-3 rounded" name="amount" placeholder="Enter Minimum Price" required />
                                            </div>
                                            <button class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- car details -->
            <div class="mt-md-5 mt-0">
                <!-- car main photo and general note -->
                <div class="tab-content container">
                    <div class=" tab-pane fade show active" id="warehouse">
                        <div class=" m-0">

                            <div class="row flex-md-row flex-column-reverse">
                                <div class="col-md-6">
                                    @if(count(@$list->vehicle->vehicle_images) > 0)
                                    <div id="main-slider-warehouse" class="splide mt-2 mt-md-0 p-0 container-fluid">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                @foreach($list->vehicle->vehicle_images as $key => $value)
                                                @if($value->type == "warehouse")
                                                <li class="splide__slide">
                                                    <img src="{{ url($value->filepath.$value->filename) }}" class="image w-100" alt="car-image" />
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @else
                                    <p class="text-center">No image found.</p>
                                    @endif
                                </div>
                                <div class="col-md-6 general-note-card">
                                    <div class="card border-0 shadow rounded-5" style="padding:5px 10px 5px 10px;">
                                        <div class="card-body">
                                            <form method="POST" action="{{ url("user/add-notes") }}" class="form">
                                                <input type="hidden" name="vehicle_id" value="{{ @$list->vehicle_id }}">
                                                <h4 class="fw-semibold text-fs-3">General Notes</h4>
                                                <input type="text" class="border border-1 mb-4 p-2 rounded-2 shadow w-100 text-fs-3" value="{{ @$list->vehicle->notes_user }}" name="notes_user" />
                                                <h4 class="fw-semibold text-fs-3">Personal Notes</h4>
                                                <input type="text" class="border border-1 mb-4 p-2 rounded-2 shadow w-100 text-fs-3" value="{{ @$list->vehicle->notes_document }}" name="notes_document" />
                                                @if(\Auth::user()->role == "2")
                                                <button class="btn btn-primary text-white fw-semibold col-md-4">
                                                    Update
                                                </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- car other photo -->
                        <div class="container-car-image mx-0">
                            <div id="thumbnail-slider-warehouse" class="splide mt-2">
                                @if(count(@$list->vehicle->vehicle_images) > 0)
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @foreach($list->vehicle->vehicle_images as $key => $value)
                                        @if($value->type == "warehouse")
                                        <li class="splide__slide">
                                            <img src="{{ url($value->filepath.$value->filename) }}" class="image vehicle-image w-100" alt="car-image" />
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="unloading">
                        <div class="m-0">

                            <div class="row flex-md-row flex-column-reverse">
                                <div class="col-md-6">
                                    @if(count(@$list->vehicle->vehicle_images) > 0)
                                    <div id="main-slider-unloading" class="splide mt-2 mt-md-0 p-0 container-fluid">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                @foreach($list->vehicle->vehicle_images as $key => $value)
                                                @if($value->type == "unloading")
                                                <li class="splide__slide">
                                                    <img src="{{ url($value->filepath.$value->filename) }}" class="image w-100" alt="car-image" />
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @else
                                    <p class="text-center">No image found.</p>
                                    @endif
                                </div>
                                <div class="col-md-6 general-note-card">
                                    <div class="card border-0 shadow rounded-5"
                                        style="padding:5px 10px 5px 10px;">
                                        <div class="card-body">
                                            <form method="POST" action="{{ url("user/add-notes") }}" class="form">
                                                <input type="hidden" name="vehicle_id" value="{{ @$list->vehicle_id }}">
                                                <h4 class="fw-semibold text-fs-3">General Notes</h4>
                                                <input type="text" class="border border-1 mb-4 p-2 rounded-2 shadow w-100 text-fs-3" value="{{ @$list->vehicle->notes_user }}" name="notes_user" />
                                                <h4 class="fw-semibold text-fs-3">Personal Notes</h4>
                                                <input type="text" class="border border-1 mb-4 p-2 rounded-2 shadow w-100 text-fs-3" value="{{ @$list->vehicle->notes_document }}" name="notes_document" />
                                                @if(\Auth::user()->role == "2")
                                                <button class="btn btn-primary text-white fw-semibold col-md-4">
                                                    Update
                                                </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- car other photo -->
                        <div class="container-car-image  mx-0">
                            <div id="thumbnail-slider-unloading" class="splide mt-2">
                                @if(count(@$list->vehicle->vehicle_images) > 0)
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @foreach($list->vehicle->vehicle_images as $key => $value)
                                        @if($value->type == "unloading")
                                        <li class="splide__slide">
                                            <img src="{{ url($value->filepath.$value->filename) }}" class="image vehicle-image w-100" alt="car-image"/>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="postForSaleModelLabel" aria-hidden="true">
                    <div class="modal-dialog rounded-5">
                        <div class="modal-content p-4">
                            <div class="modal-header border-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="image-slider">
                                    @foreach($list->vehicle->vehicle_images as $key => $value)
                                    <img src="{{ url($value->filepath.$value->filename) }}" alt="Image 1">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- car updatable details -->
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="px-14 d-flex">
                                <h4 class="fw-bold fs-md-13 fs-lg-25">
                                    Vehicle information
                                </h4>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Status</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->status->name }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Description</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->company_name.' '.@$list->vehicle->name.' '.@$list->vehicle->modal }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">VIN</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->vin }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Title</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->title }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Keys</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->keys }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Client Name</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->client_name }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Fuel Type</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->fuel_type }}" disabled />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="px-14 d-flex">
                                <h4 class="fw-bold fs-md-13 fs-lg-25">
                                    Additional Details
                                </h4>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Terminal</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->terminal->name }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Auction</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->auction->name }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Auction Location</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->auction_location->name }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Auction buyer</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->auction_buyer }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Stock/Lot</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->lotnumber }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Purchase Date</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->purchase_date }}" disabled />
                                </div>
                            </div>
                            @if(\Auth::user()->role == "2")
                            <form method="POST" action="{{ url("user/update-destination") }}" class="form row mt-4">
                                <input type="hidden" name="vehicle_id" value="{{ @$list->vehicle_id }}">
                                <label for="" class="col-md-2 fw-bold">Destination</label>
                                <div class="col-md-10">
                                    <select class="selectjs form-select" name="destination_port_id" aria-label="Default select example">
                                        @if(count(@$destination_port) > 0)
                                        @foreach(@$destination_port as $k => $v)
                                        @if(@$v->id == @$list->vehicle->destination_port_id)
                                        <option value="{{ @$v->id }}" selected>{{ @$v->name }}</option>
                                        @else
                                        <option value="{{ @$v->id }}">{{ @$v->name }}</option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="offset-md-2 col-md-10 mt-4">
                                    <button class="btn btn-primary text-white fw-semibold col-md-12">
                                        Update
                                    </button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="px-14 d-flex">
                                <h4 class="fw-bold fs-md-13 fs-lg-25">
                                    Vehicle transportation info
                                </h4>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Dispatch Date</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->dispatch_date }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Est. Delivery Date</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->delivery_date }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Actual Delivery Date</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->delivered_on_date }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Pickup Date</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->pickup_date }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Notes</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->vehicle->notes }}" disabled />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="px-14 d-flex">
                                <h4 class="fw-bold fs-md-13 fs-lg-25">
                                    Container Info
                                </h4>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Container No.</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->container->container_no }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Booking</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->container->booking_no }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Shipping Line</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->container->shipping_line->name }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Measurement</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->container->measurement->name }}" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Sail Date</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" disabled />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="" class="col-md-2 fw-bold">Estimated Arrival</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ @$list->container->arrival }}" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container">

                                <div class="px-14 d-flex justify-content-between mb-3">
                                    <div class="">
                                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                                            Attached Documents
                                        </h4>
                                    </div>
                                    {{-- <div class="d-flex justify-content-end">
                                        <div class="mt-6 px-14">
                                            <div class="financial-btn">
                                                <button class="btn btn-primary border border-1 fs-6">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19"
                                                        height="22" viewBox="0 0 19 22" fill="none">
                                                        <path
                                                            d="M13.0253 0.170898H6.05884C5.10095 0.170898 4.31722 0.954626 4.31722 1.91252V15.8455C4.31722 16.8033 5.10095 17.5871 6.05884 17.5871H16.5085C17.4664 17.5871 18.2502 16.8033 18.2502 15.8455V5.39575L13.0253 0.170898ZM16.5085 15.8455H6.05884V1.91252H12.1545V6.26656H16.5085V15.8455ZM2.5756 3.65413V19.3287H16.5085V21.0703H2.5756C1.61771 21.0703 0.833984 20.2866 0.833984 19.3287V3.65413H2.5756ZM7.80046 8.87899V10.6206H14.7669V8.87899H7.80046ZM7.80046 12.3622V14.1038H12.1545V12.3622H7.80046Z"
                                                            fill="white" />
                                                    </svg>
                                                    Download
                                                </button>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row container-details-card mb-3" style="height: fit-content;">
                                    @if(count(@$list->vehicle->vehicle_documents) > 0)
                                    @foreach($list->vehicle->vehicle_documents as $key => $value)
                                    <div class="col-md-4">
                                        <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-file-pdf fa-solid fs-4"></i>
                                                </div>
                                                <div>
                                                    <a href="{{ url($value->filepath.$value->filename) }}" download>
                                                        <i class="fas fa-download text-dark"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <object data="{{ url($value->filepath.$value->filename) }}" style="width: 100%; height: 100% !important;">
                                                    Alt : <a href="{{ url($value->filepath.$value->filename) }}">test.pdf</a>
                                                </object>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col-lg-12 pt-5">
                                        <p class="text-center">No document found.</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="d-flex align-items-center shadow mb-2">
                                <div class="flex-grow-1">
                                    <input type="search" id="default-search"
                                        class="form-control border border-1 rounded-2 p-2"
                                        placeholder="Enter Email to get details" required />
                                </div>
                                <button type="submit"
                                    class="btn btn-primary border border-0 p-2 text-white">Send</button>
                            </div>
                            <h5 class="text-fs-4 fw-bold">Sent emails History</h5>
                            <div class="container-search p-3">
                                <div class="row shadow border rounded-5 w-100 mb-3">
                                    <span class="col text-fs-3 fw-bold text-center">Email</span>
                                    <span class="col text-fs-3 fw-bold text-center">Date</span>
                                </div>
                                <div class="row shadow border rounded-5 w-100 mb-3">
                                    <span class="col text-fs-3 text-center">moh@gmail.com</span>
                                    <span class="col text-fs-3 text-center">23.3.2023</span>
                                </div>
                                <div class="row shadow border rounded-5 w-100 mb-3">
                                    <span class="col text-fs-3 text-center">Anas@tach.com</span>
                                    <span class="col text-fs-3 text-center">3.3.2023</span>
                                </div>
                                <div class="row shadow border rounded-5 w-100 mb-3">
                                    <span class="col text-fs-3 text-center">Ahmad@tools.com</span>
                                    <span class="col text-fs-3 text-center">2.5.2023</span>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(() => {
            $('.selectjs').select2();
            $(".image-slider").slick({
                lazyLoad: 'ondemand',
                dots: true
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
                            toastr["success"](res.msg, "Complete!");

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr["error"](res.msg, "Failed!");
                        }
                    }
                });
            });

            $(document).on("click", ".download", function () {
                if($(".vehicle-image").length > 0) {
                    $(".vehicle-image").each(function (key, value) {
                        var src = $(value).attr("src");
                        var html = `<a href="`+src+`" id="download-image" download="vehicle.png"></a>`;
                        $("body").append(html);
                        triggerMouseEvent(document.querySelector("#download-image"), "click");
                        $("#download-image").remove();
                    });
                } else {
                    toastr["error"]("Images not found!", "Failed!");
                }
            });

            function triggerMouseEvent(node, eventType) {
                var clickEvent = document.createEvent('MouseEvents');
                clickEvent.initEvent(eventType, true, true);
                node.dispatchEvent(clickEvent);
            }

            $(document).on("click", ".upload-images", function () {
                $("#images").click();
            });

            $(document).on("click", ".image", function () {
                $("#imageModal").modal("show");
            });

            $(document).on("submit", "#pickup-form", function (event) {
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
                            $("#requestPickupModal").modal("hide");
                            $("#requestPickupConfirmModel").modal("show");

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr["error"](res.msg, "Failed!");
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var main = new Splide('#main-slider-warehouse', {
                // type: 'fade',
                // rewind: true,
                fixedWidth: "100%",
                fixedHeight: "100%",
                pagination: false,
                arrows: false,
            });
            var thumbnails = new Splide('#thumbnail-slider-warehouse', {
                fixedWidth: 160,
                fixedHeight: 100,
                gap: 5,
                rewind: true,
                pagination: false,
                isNavigation: true,
                cover: true,
                breakpoints: {
                    600: {
                        fixedWidth: 60,
                        fixedHeight: 44,
                    },
                },
            })

            main.sync(thumbnails);
            main.mount();
            thumbnails.mount();
            var main = new Splide('#main-slider-unloading', {
                // type: 'fade',
                // rewind: true,
                fixedWidth: "100%",
                fixedHeight: "100%",
                pagination: false,
                arrows: false,
            });
            var thumbnails = new Splide('#thumbnail-slider-unloading', {
                fixedWidth: 160,
                fixedHeight: 100,
                gap: 5,
                rewind: true,
                pagination: false,
                isNavigation: true,
                cover: true,
                breakpoints: {
                    600: {
                        fixedWidth: 60,
                        fixedHeight: 44,
                    },
                },
            })

            main.sync(thumbnails);
            main.mount();
            thumbnails.mount();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
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