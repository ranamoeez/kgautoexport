@extends('layouts.user')

@section('content')            
    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div>
                <div class="row">
                    <div class="col-md mb-2 mb-md-0">
                        <div class="card border-0 shadow-lg h-100">
                            <div class="card-body p-5 d-flex flex-row">
                                <div class="me-3 rounded-circle home-card-icons bg-primary p-3">
                                    <img src="{{ asset('assets/new-car (1).png') }}" alt="car" class="" />
                                </div>
                                <div class="align-self-center">
                                    <h2 class="card-subtitle fw-bold">{{ @$total_vehicles }}</h2>
                                    <p class="card-text">Total Vehicles</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md mb-2 mb-md-0">
                        <div class="card border-0 shadow-lg h-100">
                            <div class="card-body p-5 d-flex flex-row">
                                <div class="me-3 rounded-circle home-card-icons bg-primary p-3">
                                    <img src="{{ asset('assets/cargo-ship (2).png') }}" alt="car" class="" />
                                </div>
                                <div class="align-self-center">
                                    <h2 class="card-subtitle  fw-bold">75</h2>
                                    <p class="card-text">New vehicles</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md mb-2 mb-md-0">
                        <div class="card border-0 shadow-lg h-100">
                            <div class="card-body p-5 d-flex flex-row">
                                <div class="me-3 rounded-circle home-card-icons bg-primary p-3">
                                    <img src="{{ asset('assets/check-circle.svg') }}" alt="car" class="" />
                                </div>
                                <div class="align-self-center">
                                    <h2 class="card-subtitle  fw-bold">75</h2>
                                    <p class="card-text">New vehicles</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="px-14 mt-32">
                <div class="d-flex justify-content-between mt-3">
                    <h4 class="fw-bold fs-md-13 fs-lg-25">
                        New Vehicles added to the account
                    </h4>
                    <a href="{{ url('admin/vehicles') }}" class="vehicle-icon fw-bold fs-md-13 fs-lg-25">Vehicles list
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3.5" stroke="currentColor" class="w-3 h-3  fs-md-13">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
                <div class="table-responsive">
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
                            <th scope="col">Terminal</th>
                            <th scope="col">Comment</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @if(!empty(@$latest) > 0)
                            @foreach(@$latest as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td @if(@$value->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="d-flex flex-column justify-content-center">
                                        @if(!empty(@$value->vehicle->vehicle_documents))
                                            @if(count(@$value->vehicle->vehicle_documents) > 0)
                                            <a href="javascript:void();" class="text-link text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                                    <a href="{{ url('user/vehicles', @$value->id) }}" style="text-decoration: none; color: #000000;" class="fw-bold text-fs-4">
                                        {{ @$value->vehicle->destination_port->name }}
                                    </a>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="items-center justify-center font-semibold flex-col">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="#dc2626" stroke="#fff" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-x-circle">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </div>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="items-center justify-center font-semibold flex-col">
                                        <?xml version="1.0" encoding="iso-8859-1"?>
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <?xml version="1.0" ?><svg height="20px" version="1.1"
                                            viewBox="0 0 20 20" width="20px" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title />
                                            <desc />
                                            <defs />
                                            <g fill="none" fill-rule="evenodd" id="Page-1" stroke="none"
                                                stroke-width="1">
                                                <g fill="#16a34a" id="Core"
                                                    transform="translate(-44.000000, -86.000000)">
                                                    <g id="check-circle"
                                                        transform="translate(44.000000, 86.000000)">
                                                        <path
                                                            d="M10,0 C4.5,0 0,4.5 0,10 C0,15.5 4.5,20 10,20 C15.5,20 20,15.5 20,10 C20,4.5 15.5,0 10,0 L10,0 Z M8,15 L3,10 L4.4,8.6 L8,12.2 L15.6,4.6 L17,6 L8,15 L8,15 Z"
                                                            id="Shape" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </td>
                                <td @if(@$value->vehicle->status_id == '8' || @$value->vehicle->status_id == '10' || @$value->vehicle->status_id == '11') style="background-color: #f2f3a1 !important;" @endif>
                                    <div class="d-flex px-3 p-1 rounded-pill align-items-center shadow">
                                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path id="Vector"
                                                d="M1.32564 12.1964C1.40397 12.3933 1.5573 12.551 1.75189 12.6348C1.94649 12.7186 2.16642 12.7217 2.36329 12.6434C2.56017 12.5651 2.71787 12.4117 2.80169 12.2171C2.88552 12.0225 2.88861 11.8026 2.81028 11.6057L1.91631 9.35483L7.21631 8.18149V11.9729C7.21631 12.1846 7.30041 12.3876 7.4501 12.5373C7.59979 12.687 7.80281 12.7711 8.01451 12.7711C8.2262 12.7711 8.42923 12.687 8.57892 12.5373C8.72861 12.3876 8.8127 12.1846 8.8127 11.9729V8.18149L14.1127 9.35483L13.2187 11.6057C13.1799 11.7032 13.1606 11.8074 13.162 11.9123C13.1634 12.0173 13.1855 12.1209 13.227 12.2173C13.2686 12.3136 13.3287 12.4009 13.404 12.474C13.4792 12.5471 13.5682 12.6047 13.6657 12.6434C13.7597 12.6806 13.86 12.6995 13.9611 12.6993C14.1209 12.6994 14.2771 12.6516 14.4095 12.5619C14.5418 12.4723 14.6442 12.3449 14.7034 12.1964L15.9406 9.07547C15.983 8.96752 16.0015 8.85162 15.9946 8.73582C15.9877 8.62003 15.9556 8.50713 15.9007 8.40498C15.8473 8.30321 15.7726 8.21415 15.6817 8.1439C15.5908 8.07364 15.4858 8.02384 15.3739 7.9979L12.8037 7.43119V3.99097C12.8037 3.77928 12.7196 3.57625 12.5699 3.42656C12.4202 3.27687 12.2172 3.19278 12.0055 3.19278H10.4091V0.798194C10.4091 0.5865 10.325 0.383476 10.1753 0.233786C10.0256 0.0840952 9.82259 0 9.6109 0H6.41812C6.20643 0 6.0034 0.0840952 5.85371 0.233786C5.70402 0.383476 5.61993 0.5865 5.61993 0.798194V3.19278H4.02354C3.81184 3.19278 3.60882 3.27687 3.45913 3.42656C3.30944 3.57625 3.22534 3.77928 3.22534 3.99097V7.43119L0.65516 7.98194C0.543224 8.00788 0.438207 8.05768 0.347287 8.12793C0.256368 8.19819 0.181688 8.28725 0.128352 8.38902C0.0733794 8.49116 0.0413315 8.60406 0.034439 8.71986C0.0275465 8.83565 0.0459752 8.95156 0.0884419 9.0595L1.32564 12.1964ZM7.21631 1.59639H8.8127V3.19278H7.21631V1.59639ZM4.82173 4.78916H11.2073V7.072L8.19011 6.38555H7.83891L4.82173 7.072V4.78916ZM14.9668 13.7928C14.6867 13.8786 14.4185 13.9993 14.1686 14.152C13.9143 14.3007 13.625 14.379 13.3305 14.379C13.0359 14.379 12.7467 14.3007 12.4924 14.152C11.9394 13.84 11.3153 13.6761 10.6805 13.6761C10.0456 13.6761 9.42151 13.84 8.86858 14.152C8.61081 14.299 8.31921 14.3762 8.02249 14.3762C7.72577 14.3762 7.43417 14.299 7.1764 14.152C6.62297 13.8415 5.99906 13.6785 5.3645 13.6785C4.72995 13.6785 4.10604 13.8415 3.5526 14.152C3.29833 14.3007 3.00906 14.379 2.7145 14.379C2.41994 14.379 2.13067 14.3007 1.8764 14.152C1.62643 13.9993 1.35826 13.8786 1.0782 13.7928C0.971997 13.755 0.858997 13.7402 0.746643 13.7493C0.634289 13.7583 0.525128 13.7911 0.426346 13.8454C0.327563 13.8997 0.241401 13.9743 0.173529 14.0642C0.105657 14.1542 0.0576164 14.2576 0.0325683 14.3675C-0.0270203 14.5697 -0.00423422 14.7872 0.0959549 14.9726C0.196144 15.158 0.365604 15.2963 0.567358 15.3573C0.728085 15.4008 0.881426 15.4681 1.02233 15.5568C1.5066 15.841 2.05724 15.9924 2.61872 15.9958C3.20188 15.9959 3.77468 15.8417 4.27896 15.5488C4.59183 15.3762 4.94333 15.2857 5.30065 15.2857C5.65797 15.2857 6.00946 15.3762 6.32234 15.5488C6.82304 15.8351 7.38983 15.9857 7.96662 15.9857C8.5434 15.9857 9.11019 15.8351 9.6109 15.5488C9.92377 15.3762 10.2753 15.2857 10.6326 15.2857C10.9899 15.2857 11.3414 15.3762 11.6543 15.5488C12.149 15.8441 12.7144 16 13.2906 16C13.8667 16 14.4321 15.8441 14.9269 15.5488C15.0678 15.4601 15.2211 15.3928 15.3818 15.3493C15.4881 15.3278 15.5888 15.2849 15.6779 15.2232C15.767 15.1615 15.8426 15.0823 15.9001 14.9905C15.9576 14.8986 15.9958 14.796 16.0124 14.6889C16.029 14.5818 16.0235 14.4724 15.9964 14.3675C15.9711 14.2595 15.9235 14.1579 15.8567 14.0693C15.7898 13.9807 15.7053 13.9071 15.6084 13.853C15.5115 13.7989 15.4044 13.7656 15.2939 13.7553C15.1835 13.7449 15.072 13.7577 14.9668 13.7928Z"
                                                fill="black" />
                                        </svg>
                                        <span class="text-fs-4 ms-1">Shipped</span>
                                    </div>
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
                                            <p class="text-fs-3" style="float: left;">
                                                {{ @$value->vehicle->notes_user }}
                                            </p>
                                            <button class="btn btn-sm btn-primary comment-btn fs-6 border-0"
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
                                                                id="fullNoteModelLabel" style="font-size: 28px">
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
                                    <div class="rounded-circle bg-primary p-1 user-icon" data-bs-toggle="modal"
                                        data-bs-target="#sendUserModel">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                        </svg>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="sendUserModel" tabindex="-1"
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
                                                                    placeholder="Khaled Ibrahim" disabled
                                                                    aria-label="upload">
                                                                <button class="btn btn-primary ded"
                                                                    type="submit">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="ms-2">Send</span>
                                                                    </div>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="mt-4">
                                                            <form class="d-flex shadow bg-white rounded-5"
                                                                role="upload">
                                                                <input
                                                                    class="form-control me-2 bg-white border-0 fs-5"
                                                                    placeholder="Khaled Ibrahim" disabled
                                                                    aria-label="upload">
                                                                <button class="btn btn-info" type="submit">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="ms-2">Send</span>
                                                                    </div>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="mt-4">
                                                            <form class="d-flex shadow bg-white rounded-5"
                                                                role="upload">
                                                                <input
                                                                    class="form-control me-2 bg-white border-0 fs-5"
                                                                    placeholder="Khaled Ibrahim" disabled
                                                                    aria-label="upload">
                                                                <button class="btn btn-primary" type="submit">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="ms-2">Send</span>
                                                                    </div>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="mt-4">
                                                            <form class="d-flex shadow bg-white rounded-5"
                                                                role="upload">
                                                                <input
                                                                    class="form-control me-2 bg-white border-0 fs-5"
                                                                    placeholder="Khaled Ibrahim" disabled
                                                                    aria-label="upload">
                                                                <button class="btn btn-primary" type="submit">
                                                                    <div class="d-flex align-items-center">
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
                                                                    placeholder="Khaled Ibrahim" disabled
                                                                    aria-label="upload">
                                                                <button class="btn btn-info" type="submit">
                                                                    <div class="d-flex align-items-center">
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

                <div class="mt-5 row">
                    <div class="col-md  mb-4 mb-md-0">

                        <!-- Due payment limit -->
                        <div class="chart">
                            <div class="d-flex justify-content-between mb-3 ">
                                <h3 class="fw-bold fs-md-13 fs-lg-25">
                                    Due Payments Limit
                                </h3>
                                <a href="{{ url('user/financial') }}"
                                    class="vehicle-icon fw-bold fs-md-13 fs-lg-25">Financial
                                    Section
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3.5" stroke="currentColor" class="w-3 h-3 fs-md-13 ">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>

                            <div class="p-3 row shadow-lg d-flex due-payment-chart">
                                <div class="col-md d-flex justify-content-center flex-column">
                                    <h4 class="fw-bold text-fs-4">
                                        Due Payments Limit
                                    </h4>
                                    <p class="text-fs-3 mt-4">Spend: $3,050 / $5,000</p>
                                </div>
                                <div class="col-md">
                                    <canvas style="width: 100%; max-width: 213px" id="myChart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md mb-4 mb-md-0">
                        <!-- Pick Up Request -->
                        <div class="request-chart ml-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h3 class="fw-bold fs-md-13 fs-lg-25">
                                    Pickup Requests
                                </h3>
                                <a href="{{ url('user/vehicles') }}"
                                    class="vehicle-icon fw-bold fs-md-13 fs-lg-25">Vehicles
                                    list
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3.5" stroke="currentColor" class="w-3 h-3 fs-md-13">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>

                            <div class="shadow-lg overflow-hidden request-pickup-chart">

                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <div class="m-3">
                                        <h4 class="fw-bold text-fs-4 mt-4">Vehicle</h4>
                                        <div class="rounded-2 shadow-lg w-100 mb-2">
                                            <select class="selectjs form-select"
                                                aria-label="Default select example">
                                                <option selected>Choose Vehicles</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <h4 class="fw-bold text-fs-4">Comment</h4>
                                        <input type="text"
                                            class="border border-1 mb-4 p-2 rounded-2 shadow w-100 text-fs-3"
                                            placeholder="Your Comment Here" />
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <label for="file-upload">
                                            <img style="cursor: pointer" src="{{ asset('assets/file_img.png') }}"
                                                alt="icon" />
                                            <input type="file" id="file-upload" style="display: none;">
                                        </label>
                                    </div>
                                    <button class="bg-primary absolute p-3 border-0" data-bs-toggle="modal"
                                        data-bs-target="#requestPickupConfirmModel">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade  " id="requestPickupConfirmModel" tabindex="-1"
                                        aria-labelledby="requestPickupConfirmModelLabel" aria-hidden="true">
                                        <div class="modal-dialog rounded-5">
                                            <div class="modal-content p-3">
                                                <div class="modal-body">
                                                    <div class="border-0">
                                                        <img src="{{ asset('assets/like.png') }}" alt="Like" />
                                                    </div>
                                                    <div class="card-body request-pickup-popup">
                                                        <div class="mt-4">
                                                            <h5 class="card-title fw-bold fs-2">Pick up
                                                                Requested <span>Successfully</span></h5>
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
        // chart js
        var xValues = ["Due", "Limit"];
        var yValues = [3050, 5000];
        var barColors = ["#F9D46C", "#F3F3F3"];

        new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                },],
            },
            options: {
                title: {
                    display: true,
                    text: "due",
                },
            },
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
        });
    </script>
    <script>
        $(".alert").show().delay(5000).queue(function (n) {
            $(this).hide(); n();
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