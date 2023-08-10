@extends('layouts.admin')

@section('content')
    
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Add a new vehicle
                </h4>
                <div class="d-flex justify-content-between">
                    <div class="financial-btn">
                        <button class="btn btn-primary border border-1 fs-5" disabled>
                            Send to Buyer
                        </button>
                    </div>
                    <div class="financial-btn">
                        <button class="btn btn-primary border border-1 fs-5 submit-form" type="button">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ @$action }}" class="add-vehicle make_ajax" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Vehicle information</h3>
                        <div class="mt-4">
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Status</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="status_id">
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
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Terminal</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="terminal_id">
                                        @if(count(@$all_terminal) > 0)
                                        @foreach(@$all_terminal as $key => $value)
                                            @if($value['id'] == @$terminal)
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
                                <label for="" class="col-md-3 col-form-label fw-semibold">Buyer</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="buyer_id">
                                        @if(count(@$all_buyer) > 0)
                                        @foreach(@$all_buyer as $key => $value)
                                            @if($value['id'] == @$buyer)
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
                                <label for="" class="col-md-3 col-form-label fw-semibold">VIN</label>
                                <div class="col-md-9">
                                    <input type="text" name="vin" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Description</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="company">
                                        <option value="Mercedes" selected>Mercedes</option>
                                        <option value="option1">Option1</option>
                                        <option value="option2">Option2</option>
                                        <option value="option3">Option3</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <select class="selectjs form-select" name="name">
                                                <option value="C200" selected>C200</option>
                                                <option value="option1">Option1</option>
                                                <option value="option2">Option2</option>
                                                <option value="option3">Option3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="selectjs form-select" name="model">
                                                <option value="2019" selected>2019</option>
                                                <option value="option1">Option1</option>
                                                <option value="option2">Option2</option>
                                                <option value="option3">Option3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Client name</label>
                                <div class="col-md-9">
                                    <input type="text" name="client_name" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Title</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio1" type="radio" name="title" class="form-check-input" value="1" 
                                            checked />
                                        <label for="radio1" class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio2" type="radio" name="title" value="2" class="form-check-input" />
                                        <label for="radio2" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio3" type="radio" name="title" value="3" class="form-check-input" />
                                        <label for="radio3" class="form-check-label">BOS</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio4" type="radio" name="title" value="4" class="form-check-input" />
                                        <label for="radio4" class="form-check-label">TBO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Keys</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio5" type="radio" name="keys"
                                            class="form-check-input" value="0" checked />
                                        <label for="radio5" class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio6" type="radio" name="keys"
                                            class="form-check-input" value="1" />
                                        <label for="radio6" class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Operable</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio7" type="radio" name="operable"
                                            class="form-check-input" value="0" checked />
                                        <label for="radio7" class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio8" type="radio" name="operable"
                                            class="form-check-input" value="1" />
                                        <label for="radio8" class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Fuel Type</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio9" type="radio" name="fuel_type" class="form-check-input"
                                            checked value="1" />
                                        <label for="radio9" class="form-check-label">Hybrid</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio10" type="radio" name="fuel_type" class="form-check-input" value="2" />
                                        <label for="radio10" class="form-check-label">Electric Car</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio11" type="radio" name="fuel_type" class="form-check-input" value="3" />
                                        <label for="radio11" class="form-check-label">Gas Car</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio12" type="radio" name="fuel_type" class="form-check-input" value="4" />
                                        <label for="radio12" class="form-check-label">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Additional details</h3>
                        <div class="mt-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select auction" name="auction_id">
                                        @if(count(@$all_auction) > 0)
                                        @foreach(@$all_auction as $key => $value)
                                            @if($value['id'] == @$auction)
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
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction
                                    location</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select auction_location" name="auction_location_id" disabled>
                                        @if(count(@$all_auction_location) > 0)
                                        @foreach(@$all_auction_location as $key => $value)
                                            @if($value['id'] == @$auction_location)
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
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="address" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="location" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction buyer</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="auction_buyer">
                                        @if(count(@$all_buyer) > 0)
                                        @foreach(@$all_buyer as $key => $value)
                                            @if($value['id'] == @$auction_buyer)
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
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Lot number</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="lotnumber" placeholder="Enter a number"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Purchase date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="purchase_date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Destination</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="destination_port_id">
                                        @if(count(@$all_destination_port) > 0)
                                        @foreach(@$all_destination_port as $key => $value)
                                            @if($value['id'] == @$destination_port)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label for="notes" class="fw-semibold">Notes</label>
                                <textarea name="notes_user" cols="10" rows="4" value="Title received on 12 / 18r"
                                    class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-4">
                                <label for="notes" class="fw-semibold">Admin Notes</label>
                                <textarea name="notes" cols="10" rows="4" value="Title received on 12 / 18r"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Transportation info</h3>
                        <div class="mt-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="transportation_address" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Carrier</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="carrier" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Pay date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="pdate" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Pickup address</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pickup_address" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Delivery
                                    address</label>
                                <div class="col-sm-9">
                                    <input type="text" name="delivery_address" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Due date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="due_date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Dispatch date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="dispatch_date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Pickup date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="pickup_date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Estimated del.
                                    date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="delivery_date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Actual delivery
                                    date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="delivered_on_date" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Towing price</label>
                                <div class="col-sm-9">
                                    <input type="number" name="towing_price" class="form-control" placeholder="Enter a price"
                                        inputmode="numeric" />
                                </div>

                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Trans. Fines</label>
                                <div class="col-sm-9">
                                    <div class="row trans">
                                        <div class="col-md-7 d-flex align-items-center">
                                            <select class="form-select transtype">
                                                <option value="All" selected>Payment 45$</option>
                                                <option value="Late Payment">Late Payment</option>
                                                <option value="option2">Option2</option>
                                                <option value="option3">Option3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="number" class="form-control transfine" min="0" placeholder="0" />
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                        </div>
                                        <div class="col-md-1 pt-2" style="padding-right: 0px; padding-left: 0px;">
                                            <i class="fa-circle-plus fa-solid text-success savetrans"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label for="notes" class="fw-semibold">Trans. Notes</label>
                                <textarea name="transportation_notes" cols="10" rows="4" value="Title received on 12 / 18r"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Pricing details</h3>
                        <div class="mt-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction price</label>
                                <div class="col-sm-9">
                                    <input type="number" name="auction_price" class="form-control" placeholder="Enter a price"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction Fines</label>
                                <div class="col-md-9">
                                    <div class="row auct">
                                        <div class="col-md-7 d-flex align-items-center">
                                            <select class="form-select auctiontype">
                                                <option value="All" selected>Payment 45$</option>
                                                <option value="Late Payment">Late Payment</option>
                                                <option value="option2">Option2</option>
                                                <option value="option3">Option3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="number" class="form-control auctionfine" min="0" placeholder="0" />
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                        </div>
                                        <div class="col-md-1 pt-2" style="padding-right: 0px; padding-left: 0px;">
                                            <i class="fa-circle-plus fa-solid text-success saveauction"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Draft expenses</label>
                                <div class="col-sm-9">
                                    <textarea id="numeric-textarea" name="draft_expenses" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label for="notes" class="fw-semibold">Container info</label>
                                <input name="notes" class="form-control p-4" disabled>
                            </div>
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Weight (LB)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="weight" class="form-control" placeholder="Enter a weight" />
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <button data-bs-toggle="modal" data-bs-target="#sendReminderModal" type='button'
                                    class="btn btn-primary col-md-6 float-end border border-1  fs-5">
                                    Reminder
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="sendReminderModal" tabindex="-1"
                                    aria-labelledby="sendReminderModalLabel" aria-hidden="true">
                                    <div class="modal-dialog rounded-5">
                                        <div class="modal-content p-3">
                                            <div class="modal-header border-0">
                                                <h1 class="modal-title fw-bold" id="sendReminderModalLabel"
                                                    style="font-size: 28px">
                                                    Send Reminder</h1>
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
                                                            <option selected>Choose option</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <a href="#"
                                                    class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-6">Send
                                                    reminder</a>

                                                <div class="p-3">
                                                    <div class="row shadow border rounded-5 w-100 mb-3">
                                                        <p class="col text-fs-3 fw-bold text-center">History</p>
                                                        <p class="col text-fs-3 fw-bold text-center">Most Recent
                                                        </p>
                                                    </div>
                                                    <div class="row shadow border rounded-5 w-100 mb-3">
                                                        <p class="col text-fs-3 fw-bold text-center">ID</p>
                                                        <p class="col text-fs-3 fw-bold text-center">Form</p>
                                                        <p class="col text-fs-3 fw-bold text-center">Date Send
                                                        </p>
                                                    </div>
                                                    <div class="row shadow border rounded-5 w-100 mb-3">
                                                        <p class="col text-fs-3 text-center">55427687</p>
                                                        <p class="col text-fs-3 text-center">Form No.1</p>
                                                        <p class="col text-fs-3 text-center">23, 3 ,2023</p>
                                                    </div>
                                                    <div class="row shadow border rounded-5 w-100 mb-3">
                                                        <p class="col text-fs-3 text-center">65784248</p>
                                                        <p class="col text-fs-3 text-center">Form No.1</p>
                                                        <p class="col text-fs-3 text-center">23, 3 ,2023</p>
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
            
                <div class="row mt-4 pt-5">
                    <div class="col-md-6">
                        <div class="row mb-4">
                            <label class="col-md-2 col-form-label fw-semibold">Document</label>
                            <div class="col-md-10 d-flex flex-row shadow-lg px-0">
                                <input type="file" class="fbg-white border-0 form-control" name="documents[]" id="documents" aria-label="upload" accept=".pdf, .csv, .xlsx, .doc, .docx" multiple>
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
            $(document).on("change", ".auction", function () {
                var id = $(this).find("option:selected").val();

                var settings = {
                  "url": "http://localhost/kgexport/admin/get-auction-location/"+id,
                  "method": "GET",
                };

                $.ajax(settings).done(function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        $(".auction_location").html("");
                        $(response.data).each(function (key, value) {
                            option = "<option value="+value.id+">"+value.name+"</option>";
                            $(".auction_location").append(option);
                        });
                        $(".auction_location").attr("disabled", false);
                    }
                });
            });
            $(document).on("click", ".submit-form", function () {
                $(".add-vehicle").submit();
            });

            $(document).on("click", ".upload-images", function () {
                $("#images").click();
            });

            $(document).on("click", ".upload-documents", function () {
                $("#documents").click();
            });

            $(document).on("click", ".savetrans", function () {
                var type = $(".transtype").val();
                var fine = $(".transfine").val();

                var html = `<div class="col-12 mt-2">
                    <span class="row align-items-center">
                        <input type="hidden" name="trans_type[]" value="`+type+`">
                        <input type="hidden" name="trans_fine[]" value="`+fine+`">
                        <div class="col-md-6">`+type+`</div>
                        <div class="col-md-3">$`+fine+`</div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-center items-center message-icon">
                                <i class="fa-circle-minus fa-solid text-danger delete-trans" data-bs-toggle="modal" data-bs-target="#delete_confirm_modal"></i>
                            </div>
                        </div>
                    </span>
                </div>`;

                $(".trans").append(html);
            });

            $(document).on("click", ".saveauction", function () {
                var type = $(".auctiontype").val();
                var fine = $(".auctionfine").val();

                var html = `<div class="col-12 mt-2">
                    <span class="d-flex justify-content-between align-items-center">
                        <input type="hidden" name="auction_type[]" value="`+type+`">
                        <input type="hidden" name="auction_fine[]" value="`+fine+`">
                        <div class="col-md-6">`+type+`</div>
                        <div class="col-md-3">$`+fine+`</div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-center items-center message-icon">
                                <i class="fa-circle-minus fa-solid text-danger delete-trans" data-bs-toggle="modal" data-bs-target="#delete_confirm_modal"></i>
                            </div>
                        </div>
                    </span>
                </div>`;

                $(".auct").append(html);
            });

            $(document).on("click", ".delete-trans", function () {
                $(this).parent().parent().parent().parent().remove();
            });

            // $(document).on("change", "#image", function () {
            //     $("#upload-images").submit();
            // });
       
            // $(document).on("submit", "#upload-images", function () {
            //     var formData = new FormData(this);

            //     $.ajax({
            //         type: 'POST',
            //         url: '{{ url("vehicle-images") }}',
            //         data: formData,
            //         sucess: function(data){
            //             data = JSON.parse(data);
            //             if (data.success == true) {
            //                 var html = `<li>
            //                     <img src="{{ url('storage/app/vehicle') }}`+data.image+`" class="w-100"
            //                         alt="car-image" />
            //                 </li>`;
            //                 $(".all-images").append(html);
            //             }
            //         }
            //     });
            // });
        });
    </script>
    <script>
        const numericTextarea = document.getElementById("numeric-textarea");
        numericTextarea.addEventListener("input", restrictToNumeric);
        function restrictToNumeric(event) {
            const value = event.target.value;
            const numericValue = value.replace(/\D/g, "");
            event.target.value = numericValue;
        }
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