@extends('layouts.admin')

@section('title')
    Edit Vehicle
@endsection

@section('content')
    
    <style type="text/css">
        .select2-selection {
            min-height: 37px;
        }
        .phone_number .iti--separate-dial-code {
            width: 100%;
        }
    </style>
    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Edit vehicle
                </h4>
                <div class="d-flex justify-content-between">
                    <div class="financial-btn">
                        @if(empty($auth_user->admin_level->access) || @in_array("1.40", json_decode($auth_user->admin_level->access)))
                        <button class="btn btn-primary border border-1 fs-5" id="send-buyer">
                            Send to Buyer
                        </button>
                        @endif
                    </div>
                    <div class="financial-btn">
                        <button class="btn btn-primary border border-1 fs-5 submit-form" type="button">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ @$action }}" class="add-vehicle form" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Vehicle information</h3>
                        <div class="mt-4">
                            @if(empty($auth_user->admin_level->access) || @in_array("1.1", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Status</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="status_id">
                                        <option value=""></option>
                                        @if(count(@$all_status) > 0)
                                        @foreach(@$all_status as $key => $value)
                                            @if($value['id'] == @$list->vehicle->status_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.2", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Terminal</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select" name="terminal_id">
                                        <option value=""></option>
                                        @if(count(@$all_terminal) > 0)
                                        @foreach(@$all_terminal as $key => $value)
                                            @if($value['id'] == @$list->vehicle->terminal_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.3", json_decode($auth_user->admin_level->access)))
                            @if(@$list->vehicle->buyer_id !== "1")
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Buyer</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select buyer" disabled>
                                        {{-- <option value="1"></option> --}}
                                        @if(count(@$all_buyer) > 0)
                                        @foreach(@$all_buyer as $key => $value)
                                            @if($value['id'] == @$list->vehicle->buyer_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ @$value['name'].' ('.@$value['surname'].')' }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'].' ('.@$value['surname'].')' }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.4", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">VIN</label>
                                <div class="col-md-9">
                                    <input type="text" name="vin" value="{{ $list->vehicle->vin }}" class="form-control" placeholder="John Sabestin" required />
                                </div>
                            </div>
                            @endif
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Description</label>
                                <div class="col-md-9">
                                    <select class="selectjs form-select company_name" name="company_name" required="">
                                        <option value=""></option>
                                        @if(count(@$all_vehicle_brand) > 0)
                                        @foreach(@$all_vehicle_brand as $key => $value)
                                            @if($value['name'] == @$list->vehicle->company_name)
                                            <option value="{{ @$value['name'] }}" data-id="{{ @$value['id'] }}" selected>{{ @$value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['name'] }}" data-id="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <select class="selectjs form-select name" name="name" required="" disabled="">
                                                <option value=""></option>
                                                @if(count(@$all_vehicle_modal) > 0)
                                                @foreach(@$all_vehicle_modal as $key => $value)
                                                    @if($value['name'] == @$list->vehicle->name)
                                                        <option value="{{ @$value['name'] }}" data-weight="{{ @$value['weight'] }}" data-fuel="{{ @$value['fuel_type'] }}" selected>{{ @$value['name'] }}</option>
                                                        @else
                                                        <option value="{{ @$value['name'] }}" data-weight="{{ @$value['weight'] }}" data-fuel="{{ @$value['fuel_type'] }}">{{ @$value['name'] }}</option>
                                                        @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="selectjs form-select" name="modal">
                                                <option value=""></option>
                                                @php
                                                    $current_date = date("Y-m-d");
                                                    $year = (int)explode("-", $current_date)[0] + 1;
                                                @endphp
                                                @for($i=$year; $i>=1900; $i--)
                                                <option value="{{ $i }}" @if($list->vehicle->modal == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(empty($auth_user->admin_level->access) || @in_array("1.5", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Client name</label>
                                <div class="col-md-9">
                                    <input type="text" name="client_name" value="{{ $list->vehicle->client_name }}" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.6", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Title</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio1" type="radio" name="title" class="form-check-input" value="NO" @if($list->vehicle->title == 'NO') checked @endif 
                                            checked />
                                        <label for="radio1" class="form-check-label">NO</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio2" type="radio" name="title" value="YES" @if($list->vehicle->title == 'YES') checked @endif class="form-check-input" />
                                        <label for="radio2" class="form-check-label">YES</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio3" type="radio" name="title" value="BOS" @if($list->vehicle->title == 'BOS') checked @endif class="form-check-input" />
                                        <label for="radio3" class="form-check-label">BOS</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio4" type="radio" name="title" value="TBO" @if($list->vehicle->title == 'TBO') checked @endif class="form-check-input" />
                                        <label for="radio4" class="form-check-label">TBO</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.7", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Keys</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio5" type="radio" name="keys"
                                            class="form-check-input" value="NO" @if($list->vehicle->keys == 'NO') checked @endif />
                                        <label for="radio5" class="form-check-label">NO</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio6" type="radio" name="keys"
                                            class="form-check-input" value="YES" @if($list->vehicle->keys == 'YES') checked @endif />
                                        <label for="radio6" class="form-check-label">YES</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.8", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Operable</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio7" type="radio" name="operable"
                                            class="form-check-input" value="NO" @if($list->vehicle->operable == 'NO') checked @endif />
                                        <label for="radio7" class="form-check-label">NO</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio8" type="radio" name="operable"
                                            class="form-check-input" value="YES" @if($list->vehicle->operable == 'YES') checked @endif />
                                        <label for="radio8" class="form-check-label">YES</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.9", json_decode($auth_user->admin_level->access)))
                            <div class="row mb-4">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Fuel Type</label>
                                <div class="col-md-9 d-flex flex-row gap-2">
                                    <div class="form-check">
                                        <input id="radio11" type="radio" name="fuel_type" @if($list->vehicle->fuel_type == 'GAS') checked @endif class="form-check-input fuel_type" value="GAS" />
                                        <label for="radio11" class="form-check-label">GAS</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio9" type="radio" name="fuel_type" class="form-check-input fuel_type"
                                            @if($list->vehicle->fuel_type == 'HYB') checked @endif value="HYB" />
                                        <label for="radio9" class="form-check-label">HYB</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio10" type="radio" name="fuel_type" @if($list->vehicle->fuel_type == 'EV') checked @endif class="form-check-input fuel_type" value="EV" />
                                        <label for="radio10" class="form-check-label">EV</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="radio12" type="radio" name="fuel_type" @if($list->vehicle->fuel_type == 'Other') checked @endif class="form-check-input fuel_type" value="Other" />
                                        <label for="radio12" class="form-check-label">Other</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Auction details</h3>
                        <div class="mt-4">
                            @if(empty($auth_user->admin_level->access) || @in_array("1.10", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select auction" name="auction_id">
                                        <option value=""></option>
                                        @if(count(@$all_auction) > 0)
                                        @foreach(@$all_auction as $key => $value)
                                            @if($value['id'] == @$list->vehicle->auction_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.11", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Branch</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select auction_location" name="auction_location_id">
                                        <option value=""></option>
                                        @if(count(@$all_auction_location) > 0)
                                        @foreach(@$all_auction_location as $key => $value)
                                            @if($value['id'] == @$list->vehicle->auction_location_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.12", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="address" id="auction_address" value="{{ $list->vehicle->address }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.13", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Phone #</label>
                                <div class="col-sm-9 phone_number">
                                    @php
                                        $dial_code = "";
                                        $phone_number = "";
                                        $phone = explode(" ", $list->vehicle->phone);
                                        if (!empty(@$phone[0])) {
                                            $dial_code = $phone[0];
                                        }
                                        if (!empty(@$phone[1])) {
                                            $phone_number = $phone[1];
                                        }
                                    @endphp
                                    <input type="hidden" name="dial_code" id="buyer_dial_code" value="+962">
                                    <input type="text" class="form-control" name="phone" id="buyer-phone" value="{{ $phone_number }}" placeholder="XXXXXXXXX" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.14", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Buyer #</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="auction_buyer" value="{{ $list->vehicle->auction_buyer }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.15", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Lot #</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="lotnumber" value="{{ $list->vehicle->lotnumber }}" placeholder="Enter a number"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.17", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Destination</label>
                                <div class="col-sm-9">
                                    <select class="selectjs form-select" name="destination_port_id">
                                        <option value=""></option>
                                        @if(count(@$all_destination_port) > 0)
                                        @foreach(@$all_destination_port as $key => $value)
                                            @if($value['id'] == @$list->vehicle->destination_port_id)
                                            <option value="{{ @$value['id'] }}" selected>{{ $value['name'] }}</option>
                                            @else
                                            <option value="{{ @$value['id'] }}">{{ @$value['name'] }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.18", json_decode($auth_user->admin_level->access)))
                            <div class="form-group mt-4">
                                <div class="d-flex justify-content-between">
                                    <label for="notes" class="fw-semibold">Notes</label>
                                    <button class="btn btn-primary mb-2" type="button" data-bs-toggle="modal" data-bs-target="#notesHistoryModal">Notes History</button>
                                </div>
                                <textarea name="notes_user" cols="10" rows="4" value="Title received on 12 / 18r"
                                    class="form-control">{{ $list->vehicle->notes_user }}</textarea>
                            </div>
                            @endif
                            <!-- Modal -->
                            <div class="modal fade" id="notesHistoryModal" tabindex="-1" aria-labelledby="notesHistoryLabel" aria-hidden="true">
                                <div class="modal-dialog rounded-5">
                                    <div class="modal-content p-3">
                                        <div class="modal-header border-0">
                                            <h3 class="modal-title fw-bold" id="notesHistoryLabel" style="font-size: 26px">Notes History</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="text-fs-4">
                                                        <tr>
                                                            <th><b>Notes</b></th>
                                                            <th><b>Added By</b></th>
                                                            <th><b>Added On</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count(@$notes_history) > 0)
                                                        @foreach(@$notes_history as $key => $value)
                                                        <tr>
                                                            <td>{{ @$value->notes }}</td>
                                                            <td>{{ @$value->user->surname }}</td>
                                                            <td>@if(@$value->created_at) {{ date("M d, Y", strtotime(@$value->created_at)) }} @endif</td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td class="text-center" colspan="3">No history found.</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(empty($auth_user->admin_level->access) || @in_array("1.19", json_decode($auth_user->admin_level->access)))
                            <div class="form-group mt-4">
                                <label for="notes" class="fw-semibold">Admin Notes</label>
                                <textarea name="notes" cols="10" rows="4" value="Title received on 12 / 18r"
                                    class="form-control">{{ $list->vehicle->notes }}</textarea>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Transportation info</h3>
                        <div class="mt-4">
                            @if(empty($auth_user->admin_level->access) || @in_array("1.20", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="transportation_address" value="{{ $list->vehicle->transportation_address }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.21", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Carrier</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="carrier" value="{{ $list->vehicle->carrier }}" placeholder="John Sabestin" />
                                </div>
                            </div>
                            @endif
                            {{-- @if(empty($auth_user->admin_level->access) || @in_array("1.23", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Pickup address</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pickup_address" value="{{ $list->vehicle->pickup_address }}" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            @endif --}}
                            @if(empty($auth_user->admin_level->access) || @in_array("1.24", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Delivery
                                    address</label>
                                <div class="col-sm-9">
                                    <input type="text" name="delivery_address" value="{{ $list->vehicle->delivery_address }}" class="form-control" placeholder="John Sabestin" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.22", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Paid date</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pdate" value="{{ str_replace(" 00:00:00", "", $list->vehicle->pdate) }}" class="form-control datepicker" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.25", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Due date</label>
                                <div class="col-sm-9">
                                    <input type="text" name="due_date" value="{{ $list->vehicle->due_date }}" class="form-control datepicker" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.26", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Dispatch</label>
                                <div class="col-sm-9">
                                    <input type="text" name="dispatch_date" value="{{ $list->vehicle->dispatch_date }}" class="form-control datepicker" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.27", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Pickup</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pickup_date" value="{{ $list->vehicle->pickup_date }}" class="form-control datepicker" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.16", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Purchase</label>
                                <div class="col-sm-9">
                                    <input type="text" name="purchase_date" value="{{ $list->vehicle->purchase_date }}" class="form-control datepicker" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.29", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Actual del.</label>
                                <div class="col-sm-9">
                                    <input type="text" name="delivered_on_date" value="{{ $list->vehicle->delivered_on_date }}" class="form-control datepicker" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.28", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Estimated delivery</label>
                                <div class="col-sm-9">
                                    <input type="text" name="delivery_date" value="{{ $list->vehicle->delivery_date }}" class="form-control datepicker" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.31", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Trans. Fines</label>
                                <div class="col-sm-9">
                                    <div class="row trans">
                                        <div class="col-md-7 d-flex align-items-center">
                                            <select class="form-select transtype">
                                                @if(count(@$all_trans_fine_type) > 0)
                                                @foreach(@$all_trans_fine_type as $key => $value)
                                                    <option value="{{ @$value['name'] }}">{{ @$value['name'] }}</option>
                                                @endforeach
                                                @endif
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
                                        @if(count(@$list->vehicle->fines) > 0)
                                        @foreach($list->vehicle->fines as $key => $value)
                                            @if($value->type == 'transaction')
                                                <div class="col-12 mt-2">
                                                    <span class="row align-items-center">
                                                        <div class="col-md-6">{{ $value->cause }}</div>
                                                        <div class="col-md-3">${{ $value->amount }}</div>
                                                        <div class="col-md-3">
                                                            <div class="d-flex justify-content-center items-center message-icon">
                                                                <i class="fa-circle-minus fa-solid text-danger delete-fines" data-url="{{ url('admin/delete-vehicle-fines', $value->id) }}" style="cursor: pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.32", json_decode($auth_user->admin_level->access)))
                            <div class="form-group mt-4">
                                <label for="notes" class="fw-semibold">Trans. Notes</label>
                                <textarea name="transportation_notes" cols="10" rows="4" value="Title received on 12 / 18r"
                                    class="form-control">{{ $list->vehicle->transportation_notes }}</textarea>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fw-bold text-fs-4">Pricing details</h3>
                        <div class="mt-4">
                            @if(empty($auth_user->admin_level->access) || @in_array("1.33", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction price</label>
                                <div class="col-sm-9">
                                    <input type="number" name="auction_price" value="{{ $list->vehicle->auction_price }}" class="form-control" placeholder="Enter a price"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.34", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Auction Fines</label>
                                <div class="col-md-9">
                                    <div class="row auct">
                                        <div class="col-md-7 d-flex align-items-center">
                                            <select class="form-select auctiontype">
                                                @if(count(@$all_fine_type) > 0)
                                                @foreach(@$all_fine_type as $key => $value)
                                                    <option value="{{ @$value['name'] }}">{{ @$value['name'] }}</option>
                                                @endforeach
                                                @endif
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
                                        @if(count(@$list->vehicle->fines) > 0)
                                        @foreach($list->vehicle->fines as $key => $value)
                                            @if($value->type == 'auction')
                                                <div class="col-12 mt-2">
                                                    <span class="row align-items-center">
                                                        <div class="col-md-6">{{ $value->cause }}</div>
                                                        <div class="col-md-3">${{ $value->amount }}</div>
                                                        <div class="col-md-3">
                                                            <div class="d-flex justify-content-center items-center message-icon">
                                                                <i class="fa-circle-minus fa-solid text-danger delete-fines" data-url="{{ url('admin/delete-vehicle-fines', $value->id) }}" style="cursor: pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.35", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Draft Expenses</label>
                                <div class="col-md-9">
                                    <div class="row expense">
                                        <div class="col-md-7 d-flex align-items-center">
                                            <input type="text" class="form-control expense_type" />
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="number" class="form-control expense_fine" min="0" placeholder="0" />
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                        </div>
                                        <div class="col-md-1 pt-2" style="padding-right: 0px; padding-left: 0px;">
                                            <i class="fa-circle-plus fa-solid text-success saveexpense"></i>
                                        </div>
                                        @if(count(@$list->vehicle->fines) > 0)
                                        @foreach($list->vehicle->fines as $key => $value)
                                            @if($value->type == 'draft_expense')
                                                <div class="col-12 mt-2">
                                                    <span class="row align-items-center">
                                                        <div class="col-md-6">{{ $value->cause }}</div>
                                                        <div class="col-md-3">${{ $value->amount }}</div>
                                                        <div class="col-md-3">
                                                            <div class="d-flex justify-content-center items-center message-icon">
                                                                <i class="fa-circle-minus fa-solid text-danger delete-fines" data-url="{{ url('admin/delete-vehicle-fines', $value->id) }}" style="cursor: pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.41", json_decode($auth_user->admin_level->access)))
                            <div class="row my-3">
                                <label for="" class="col-md-3 col-form-label fw-semibold">Towing price</label>
                                <div class="col-sm-9">
                                    <input type="number" name="towing_price" value="{{ $list->vehicle->towing_price }}" class="form-control" placeholder="Enter a price"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            @endif
                            <div class="row my-3">
                                <label for="" class="col-md-3 col-form-label fw-semibold">US Towing price</label>
                                <div class="col-sm-9">
                                    <input type="number" name="us_towing_price" value="{{ $list->vehicle->us_towing_price }}" class="form-control" placeholder="Enter a price"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            <div class="row my-3">
                                <label for="" class="col-md-3 col-form-label fw-semibold">US Trans fines</label>
                                <div class="col-sm-9">
                                    <input type="number" name="us_trans_fines" class="form-control" value="{{ $list->vehicle->us_trans_fines }}" placeholder="Enter a price"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            @if(empty($auth_user->admin_level->access) || @in_array("1.42", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Ocean Freight</label>
                                <div class="col-sm-9">
                                    <input type="number" name="occean_freight" value="{{ @$list->vehicle->occean_freight }}" class="form-control" placeholder="Enter a price"
                                        inputmode="numeric" />
                                </div>
                            </div>
                            @endif
                            <div class="form-group mt-4 px-2">
                                <label for="notes" class="fw-semibold">Container info</label>
                                <div class="container-info p-3 row mt-2" style="border: 1px solid black; border-radius: 10px;">
                                    @if(!empty(@$list->container))
                                        <div class="col-md-5">
                                            <p class="mb-1"><b>Container No:</b></p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-1"><b>{{ @$list->container->container_no }}</b></p>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="mb-1">Shipped Date:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-1">{{ @$list->container->departure }}</p>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="mb-1">Arrival Date:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-1">{{ @$list->container->arrival }}</p>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="mb-1">Shipping Line:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-1">{{ @$list->container->shipping_line->name }}</p>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="mb-1">Vessel Line:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-1">{{ @$list->container->vessel_name }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if(empty($auth_user->admin_level->access) || @in_array("1.36", json_decode($auth_user->admin_level->access)))
                            <div class="form-group row mt-4">
                                <label for="" class="col-sm-3 col-form-label fw-semibold">Weight (LB)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="weight" id="weight" value="{{ @$list->vehicle->weight }}" class="form-control" placeholder="Enter a weight" />
                                </div>
                            </div>
                            @endif
                            @if(empty($auth_user->admin_level->access) || @in_array("1.39", json_decode($auth_user->admin_level->access)))
                            <div class="form-group mt-4">
                                <button data-bs-toggle="modal" data-bs-target="#sendReminderModal" type='button'
                                    class="btn btn-primary col-md-6 float-end border border-1  fs-5">
                                    Reminder
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            
                <div class="row mt-4 pt-5">
                    <div class="col-md-6">
                        @if(empty($auth_user->admin_level->access) || @in_array("1.37", json_decode($auth_user->admin_level->access)))
                        <div class="row mb-4">
                            <label class="col-md-2 col-form-label fw-semibold">Document</label>
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
                            @if(count(@$list->vehicle->vehicle_documents) > 0)
                            @foreach($list->vehicle->vehicle_documents as $key => $value)
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:350px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-file-pdf fa-solid fs-4"></i>
                                        </div>
                                        <div>
                                            <button class="btn btn-link p-0 delete-documents" type="button" data-url="{{ url('admin/delete-vehicle-documents', $value->id) }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                            <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}" download>
                                                <i class="fas fa-download text-dark"></i>
                                            </a>
                                            <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}" target="_blank">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <object data="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}" style="width: 100%; height: 100% !important;">
                                            Alt : <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}">test.pdf</a>
                                        </object>
                                        <div class="w-100 mt-3">
                                            <select class="form-control" id="pdf-type" data-id="{{ $value->id }}">
                                                <option value="BOS" @if($value->type == "BOS") selected @endif>BOS</option>
                                                <option value="Title" @if($value->type == "Title") selected @endif>Title</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        @if(empty($auth_user->admin_level->access) || @in_array("1.38", json_decode($auth_user->admin_level->access)))
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
                        <div class="row mb-4 warehouse-images">
                            <div class="col-md-12">
                                <h3>Warehouse</h3>
                            </div>
                            @if(count(@$list->vehicle->vehicle_images) > 0)
                            @foreach($list->vehicle->vehicle_images as $key => $value)
                            @if($value->type == "warehouse")
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-image fa-solid fs-4"></i>
                                        </div>
                                        <div>
                                            <button class="btn btn-link p-0 delete-images" type="button" data-url="{{ url('admin/delete-vehicle-images', $value->id) }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                            <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}" download>
                                                <i class="fas fa-download text-dark"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}" class="w-100 rounded-4" style="height: 160px;" alt="" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                        <div class="row mb-4 unloading-images">
                            <div class="col-md-12 mt-3">
                                <h3>Unloading</h3>
                            </div>
                            @if(count(@$list->vehicle->vehicle_images) > 0)
                            @foreach($list->vehicle->vehicle_images as $key => $value)
                            @if($value->type == "unloading")
                            <div class="col-md-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:250px;">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-image fa-solid fs-4"></i>
                                        </div>
                                        <div>
                                            <button class="btn btn-link p-0 delete-images" type="button" data-url="{{ url('admin/delete-vehicle-images', $value->id) }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                            <a href="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}" download>
                                                <i class="fas fa-download text-dark"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="http://kgautoexport.s3-website.eu-north-1.amazonaws.com/{{ $value->filename }}" class="w-100 rounded-4" style="height: 160px;" alt="" />
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                        @endif
                        {{-- <div class="row mb-4">
                            <div class="col-md-9">
                                <div class="container container-car-image ms-5 mx-5">
                                    <div id="thumbnail-slider" class="splide mt-2">
                                        <div class="splide__track">
                                            <ul class="splide__list d-flex list-unstyled gap-2 all-images">
                                                @if(count(@$list->vehicle->vehicle_images) > 0)
                                                @foreach($list->vehicle->vehicle_images as $key => $value)
                                                <li>
                                                    <img src="{{ url($value->filename) }}" class="w-100"
                                                        alt="car-image" />
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </form>
            <div class="row mt-5">
                <div class="col-md-6">
                    <form method="POST" action="{{ url('user/send-email') }}" class="d-flex align-items-center shadow mb-2 send-form">
                        <input type="hidden" name="vehicle_id" value="{{ @$list->vehicle_id }}">
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
                            <form class="send-form" method="POST" action="{{ url('admin/send-reminder') }}">
                                <input type="hidden" name="vehicle_id" value="{{ @$list->vehicle->id }}">
                                <input type="hidden" name="buyer_id" value="{{ @$list->vehicle->buyer_id }}">
                                <div class="row mt-4">
                                    <label for="choose form" class="col-md-4 fs-5 fw-bold">Choose Form</label>
                                    <div class="col-md-8">
                                        <select class="form-select template" name="template_id" aria-label="Default select example">
                                            @if(count(@$templates) > 0)
                                            @foreach(@$templates as $k => $v)
                                                <option value="{{ @$v['id'] }}">{{ @$v['name'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <button class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-6">Send reminder</button>
                            </form>

                            <div class="p-3">
                                <div class="row shadow border rounded-5 w-100 mb-3 p-1">
                                    <p class="col text-fs-3 fw-bold text-center">History</p>
                                    <p class="col text-fs-3 fw-bold text-center">Most Recent
                                    </p>
                                </div>
                                <div class="row shadow border rounded-5 w-100 mb-3 p-1">
                                    <p class="col text-fs-3 fw-bold text-center">ID</p>
                                    <p class="col text-fs-3 fw-bold text-center">Form</p>
                                    <p class="col text-fs-3 fw-bold text-center">Date Send
                                    </p>
                                </div>
                                @if(count(@$history) > 0)
                                @foreach(@$history as $k => $v)
                                <div class="row shadow border rounded-5 w-100 mb-3 p-1">
                                    <p class="col text-fs-3 text-center">{{ @$v->id }}</p>
                                    <p class="col text-fs-3 text-center">{{ @$v->template->name }}</p>
                                    <p class="col text-fs-3 text-center">@if(@$v->created_at) {{ date("M d, Y", strtotime(@$v->created_at)) }} @endif</p>
                                </div>
                                @endforeach
                                @else
                                <div class="row shadow border rounded-5 w-100 mb-3 p-1">
                                    <p class="text-fs-3 text-center">No data found</p>
                                </div>
                                @endif
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
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
            $(document).on("change", ".auction", function () {
                var id = $(this).find("option:selected").val();

                var settings = {
                  "url": "{{ url('admin/get-auction-location') }}"+"/"+id,
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
                    }
                });
            });
            $(document).on("change", ".company_name", function () {
                var id = $(this).find("option:selected").attr('data-id');

                var settings = {
                  "url": "{{ url('admin/get-vehicle-modal') }}"+"/"+id,
                  "method": "GET",
                };

                $.ajax(settings).done(function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        $(".name").html("");
                        option = "<option value=''></option>";
                        $(".name").append(option);
                        $(response.data).each(function (key, value) {
                            option = "<option value="+value.name+" data-weight="+value.weight+" data-fuel="+value.fuel_type+">"+value.name+"</option>";
                            $(".name").append(option);
                        });
                        $(".name").attr("disabled", false);
                    }
                });
            });
            $(document).on("change", ".name", function () {
                var weight = $(this).find("option:selected").attr("data-weight");
                var fuel = $(this).find("option:selected").attr("data-fuel");
                $("#weight").val(weight);
                $(".fuel_type[value='"+fuel+"']").attr("checked", true);
            });

            $(document).on("click", ".submit-form", function () {
                $(".add-vehicle").submit();
            });

            $(document).on("change", "#pdf-type", function () {
                var form = new FormData();
                form.append("type", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/vehicle-pdf-type") }}',
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
                            toastr["success"]("PDF type updated successfully!", "Completed!");
                        } else {
                            toastr["error"](data.msg, "Failed!");
                        }
                    }
                });
            });

            $(document).on("click", ".phone_number .iti__country", function () {
                $("#buyer_dial_code").val($(".phone_number .iti__selected-dial-code").first().text().trim());
            });

            $(document).on("submit", ".send-form", function (event) {
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

            $(document).on("submit", ".form", function (event) {
                event.preventDefault();

                if ($(".company_name option:selected").val() == "") {
                    toastr["error"]("Description is required!", "Completed!");
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

            $(document).on("click", ".upload-images", function () {
                $("#images").click();
            });

            $(document).on("click", ".upload-documents", function () {
                $("#documents").click();
            });

            $(document).on("change", ".auction_location", function () {
                $("#auction_address").val($(this).find("option:selected").text());
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
                    <span class="row align-items-center">
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

            $(document).on("click", ".saveexpense", function () {
                var type = $(".expense_type").val();
                if (type !== "") {
                    var fine = $(".expense_fine").val();

                    var html = `<div class="col-12 mt-2">
                        <span class="row align-items-center">
                            <input type="hidden" name="expense_type[]" value="`+type+`">
                            <input type="hidden" name="expense_fine[]" value="`+fine+`">
                            <div class="col-md-6">`+type+`</div>
                            <div class="col-md-3">$`+fine+`</div>
                            <div class="col-md-3">
                                <div class="d-flex justify-content-center items-center message-icon">
                                    <i class="fa-circle-minus fa-solid text-danger delete-trans" data-bs-toggle="modal" data-bs-target="#delete_confirm_modal"></i>
                                </div>
                            </div>
                        </span>
                    </div>`;

                    $(".expense").append(html);
                } else {
                    toastr["error"]("Please provide reason of draft expense.", "Completed!");
                }
            });

            $(document).on("click", ".delete-trans", function () {
                $(this).parent().parent().parent().parent().remove();
            });

            $(document).on("click", "#send-buyer", function () {
                $('.center-body').css('display', 'block');

                $.ajax({
                    type: 'GET',
                    url: '{{ url("admin/send-to-buyer", @$list->vehicle_id) }}',
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

            $(document).on("click", ".delete-fines", function () {
                var url = $(this).attr('data-url');

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data){
                        data = JSON.parse(data);
                        if (data.success == true) {
                            toastr["success"]("Vehicle fine deleted successfully!", "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
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
                            toastr["success"]("Vehicle document deleted successfully!", "Completed!");
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
                            toastr["success"]("Vehicle image deleted successfully!", "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>

    <script src="{{ asset('js/jquery.popup.lightbox.js') }}"></script>
    <link href="{{ asset('css/popup-lightbox.css') }}" rel="stylesheet" />

    <script>
        $(document).ready(function(){

            $(".warehouse-images").popupLightbox({
                width: 800,
                height: 600
            });

            $(".unloading-images").popupLightbox({
                width: 800,
                height: 600
            });

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
        var input2 = document.querySelector("#buyer-phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
        window.intlTelInput(input2, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["jo", "iq"]
        });

        @if(!empty($dial_code))
            $(".phone_number .iti__selected-dial-code").text("{{$dial_code}}");
            $("#buyer_dial_code").val("{{$dial_code}}");
        @endif
    </script>

@endsection