@extends('layouts.user')

@section('content')

    <style type="text/css">
        table th {
            font-weight: bold !important;
        }
    </style>

    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div class="mt-5">
                <!-- Assigned By -->
                <div class="d-flex justify-content-end">
                    <div class="mt-6 px-14">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">Assigned By:</h4>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fs-5 fw-bold" id="admin-tab" data-bs-toggle="tab"
                                    data-bs-target="#admin" type="button">
                                    Admin
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fs-5 fw-bold btn" id="super-admin-tab"
                                    data-bs-toggle="tab" data-bs-target="#super-admin" type="button">
                                    Super Admin
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="d-flex justify-content-between mt-3">
                        <h4 class="fw-bold fs-md-13 fs-lg-25">
                            List of Vehicles
                        </h4>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="table-responsive tab-pane fade show active" data-bs-toggle="tab" id="admin">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col"></th>
                                    <th scope="col">Description</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Keys</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Fuel</th>
                                    <th scope="col">Terminal</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$admin) > 0)
                                    @foreach(@$admin as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td @if(@$value->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex flex-column justify-content-center">
                                                @if(!empty(@$value->vehicle->vehicle_documents))
                                                    @if(count(@$value->vehicle->vehicle_documents) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                                @if(!empty(@$value->vehicle->vehicle_images))
                                                    @if(count(@$value->vehicle->vehicle_images) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->company_name.' '.@$value->vehicle->name.' '.@$value->vehicle->modal }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->vin }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->delivery_date }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->destination_port->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->title == '1')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @else
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->keys == '1')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @else
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex px-3 p-1 rounded-pill align-items-center shadow">
                                                <i class="fa-solid fa-ship" style="font-size: 20px;"></i>
                                                <span class="fs-5 ms-1">{{ @$value->vehicle->status->name }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center" @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <i class="text-fs-5 fa-solid fa-charging-station"></i>
                                            <span class="fs-5 ms-1">{{ @$value->vehicle->fuel_type }}</span>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold text-fs-4">
                                                {{ @$value->vehicle->terminal->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="flex items-center justify-center flex-col comment"
                                                style="width:250px; border-radius:3px">
                                                <div class="border border-1 d-flex flex-column align-items-end">
                                                    <p class="text-fs-3">
                                                        {{ @$value->vehicle->notes_user }}
                                                    </p>
                                                    <button
                                                        class="btn btn-sm btn-primary comment-btn fs-6 border-0"
                                                        data-bs-toggle="modal" data-bs-target="#fullNoteModel">
                                                        full note
                                                    </button>

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
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="rounded-circle bg-primary p-1 user-icon"
                                                data-bs-toggle="modal" data-bs-target="#sendUserModel">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                </svg>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade  " id="sendUserModel" tabindex="-1"
                                                aria-labelledby="sendUserModelLabel" aria-hidden="true">
                                                <div class="modal-dialog rounded-5">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-body">
                                                            <div class="">
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5 rounded"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-primary ded"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-info"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-primary"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-primary"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form class="d-flex shadow p-1 bg-white"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-info"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
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
                                        <td class="text-center" colspan="12">
                                            <p>No record found</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive tab-pane fade" data-bs-toggle="tab" id="super-admin">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col"></th>
                                    <th scope="col">Description</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Keys</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Fuel</th>
                                    <th scope="col">Terminal</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$super_admin) > 0)
                                    @foreach(@$super_admin as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td @if(@$value->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex flex-column justify-content-center">
                                                @if(!empty(@$value->vehicle->vehicle_documents))
                                                    @if(count(@$value->vehicle->vehicle_documents) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                                @if(!empty(@$value->vehicle->vehicle_images))
                                                    @if(count(@$value->vehicle->vehicle_images) > 0)
                                                    <a href="javascript:void();" class="text-link text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->company_name.' '.@$value->vehicle->name.' '.@$value->vehicle->modal }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->vin }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->delivery_date }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-medium text-fs-3">
                                                {{ @$value->vehicle->destination_port->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->title == '1')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @else
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="items-center justify-center font-semibold flex-col">
                                                @if(@$value->vehicle->keys == '1')
                                                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 20px;"></i>
                                                @else
                                                <i class="fa-solid fa-circle-check text-success" style="font-size: 20px;"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="d-flex px-3 p-1 rounded-pill align-items-center shadow">
                                                <i class="fa-solid fa-ship" style="font-size: 20px;"></i>
                                                <span class="fs-5 ms-1">{{ @$value->vehicle->status->name }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center" @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <i class="text-fs-5 fa-solid fa-charging-station"></i>
                                            <span class="fs-5 ms-1">{{ @$value->vehicle->fuel_type }}</span>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold text-fs-4">
                                                {{ @$value->vehicle->terminal->name }}
                                            </a>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="flex items-center justify-center flex-col comment"
                                                style="width:250px; border-radius:3px">
                                                <div class="border border-1 d-flex flex-column align-items-end">
                                                    <p class="text-fs-3">
                                                        {{ @$value->vehicle->notes_user }}
                                                    </p>
                                                    <button
                                                        class="btn btn-sm btn-primary comment-btn fs-6 border-0"
                                                        data-bs-toggle="modal" data-bs-target="#fullNoteModel">
                                                        full note
                                                    </button>

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
                                            </div>
                                        </td>
                                        <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                            <div class="rounded-circle bg-primary p-1 user-icon"
                                                data-bs-toggle="modal" data-bs-target="#sendUserModel">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                </svg>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade  " id="sendUserModel" tabindex="-1"
                                                aria-labelledby="sendUserModelLabel" aria-hidden="true">
                                                <div class="modal-dialog rounded-5">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-body">
                                                            <div class="">
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5 rounded"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-primary ded"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-info"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-primary"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form
                                                                        class="d-flex shadow bg-white rounded-5"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-primary"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <form class="d-flex shadow p-1 bg-white"
                                                                        role="upload">
                                                                        <input
                                                                            class="form-control me-2 bg-white border-0 fs-5"
                                                                            placeholder="Khaled Ibrahim"
                                                                            disabled aria-label="upload">
                                                                        <button class="btn btn-info"
                                                                            type="submit">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <span class="ms-2">Send</span>
                                                                            </div>
                                                                        </button>
                                                                    </form>
                                                                </div>
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
                                        <td class="text-center" colspan="11">
                                            <p>No record found</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <button data-bs-toggle="modal" data-bs-target="#requestPickupModal"
                class="rounded-circle bg-primary p-4 border border-0 floating-button">
                <img src="{{ asset('/assets/request_car.png') }}" alt="request" />
            </button>

            <!-- Modal -->
            <div class="modal fade modal-lg " id="requestPickupModal" tabindex="-1"
                aria-labelledby="requestPickupModalLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fw-bold" id="requestPickupModalLabel"
                                style="font-size: 28px">
                                Request Pick up</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="border-0">
                                <img src="{{ asset('/assets/pickup-car.png') }}" alt="Like" />
                            </div>
                            <div class="row mt-4">
                                <label for="password" class="col-md-4 fs-5 fw-bold">Amount</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control shadow-lg" />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="password" class="col-md-4 fs-5 fw-bold">Vehicle</label>
                                <div class="col-md-8">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Choose option</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="password" class="col-md-4 fs-5 fw-bold">Exchange Company</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control shadow-lg" />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="password" class="col-md-4 fs-5 fw-bold">Upload</label>
                                <div class="col-md-8">
                                    <form class="d-flex shadow bg-white rounded" role="upload">
                                        <input class="form-control me-2 bg-white border-0 rounded fs-5"
                                            aria-label="upload">
                                        <button class="btn btn-primary rounded" type="file">
                                            <div class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="22"
                                                    viewBox="0 0 19 22" fill="none">
                                                    <path
                                                        d="M13.0253 0.170898H6.05884C5.10095 0.170898 4.31722 0.954626 4.31722 1.91252V15.8455C4.31722 16.8033 5.10095 17.5871 6.05884 17.5871H16.5085C17.4664 17.5871 18.2502 16.8033 18.2502 15.8455V5.39575L13.0253 0.170898ZM16.5085 15.8455H6.05884V1.91252H12.1545V6.26656H16.5085V15.8455ZM2.5756 3.65413V19.3287H16.5085V21.0703H2.5756C1.61771 21.0703 0.833984 20.2866 0.833984 19.3287V3.65413H2.5756ZM7.80046 8.87899V10.6206H14.7669V8.87899H7.80046ZM7.80046 12.3622V14.1038H12.1545V12.3622H7.80046Z"
                                                        fill="white" />
                                                </svg>
                                                <span class="ms-2">Upload</span>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#requestPickupConfirmModel"
                                class="btn w-auto btn-primary border-0 mt-4 col-md-12 rounded-3 fs-5">Request
                                Pickup</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade  " id="requestPickupConfirmModel" tabindex="-1"
                aria-labelledby="requestPickupConfirmModelLabel" aria-hidden="true">
                <div class="modal-dialog rounded-5">
                    <div class="modal-content p-3">
                        <div class="modal-body">
                            <div class="border-0">
                                <img src="/assets/like.png" alt="Like" />
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