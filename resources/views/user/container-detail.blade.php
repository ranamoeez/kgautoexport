@extends('layouts.user')

@section('content')

    <style type="text/css">
        table th {
            font-weight: bold !important;
        }
    </style>

    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div class="mt-5 px-4 px-md-14">
                <div class="row">
                    <div class="col-md-6">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="22"
                                                viewBox="0 0 19 22" fill="none">
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

                        <div class="row container-details-card mb-3" style="height:fit-content;">
                            @if(count(@$container->container_documents) > 0)
                            @foreach($container->container_documents as $key => $value)
                            <div class="col-4">
                                <div class="card mt-3 container-header-detail-card" style="max-height:350px;">
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

                    <div class="col-md-6">
                        <form method="POST" action="{{ url('user/send-email') }}" class="d-flex align-items-center shadow mb-2 form">
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

                    <div class="container mt-5">
                        <div class="d-flex justify-content-between">
                            <h4 class="fw-bold fs-md-13 fs-lg-25">
                                Container Information
                            </h4>
                            <div class="d-flex justify-content-end">
                                <div class="d-flex px-3 p-1 rounded-pill align-items-center shadow">
                                    @php
                                        $icon = "booked";
                                        if (@$container->status_id == "2") {
                                            $icon = "loaded";
                                        } elseif (@$container->status_id == "3") {
                                            $icon = "shipped";
                                        } elseif (@$container->status_id == "4") {
                                            $icon = "delivered";
                                        }
                                    @endphp
                                    <img src="{{ asset('assets/icons/'.$icon.'.png') }}" style="width: 25px;">
                                    <span class="text-fs-4 ms-1">{{ @$container->status->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Container No.</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->container_no }}" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Booking No.</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->booking_no }}" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Shipping line</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->shipping_line->name }}" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Vessel Name</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->vessel_name }}" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Destination port</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->destination_port->name }}" disabled />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Consignee</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->consignee->company_name }}" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Forwarding agent</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Arrival</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->arrival }}" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Departure</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->departure }}" disabled />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label for="" class="col-md-2 fw-bold">Landing port</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" value="{{ @$container->discharge_port->name }}" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <h4 class="fw-bold fs-md-13 fs-lg-25">
                                    Vehicles Information
                                </h4>
                                <div class="p-3">
                                    <div class="row shadow border rounded-5 w-10 mb-3 py-4">
                                        <span class="col text-fs-3 fw-bold text-center">Description</span>
                                        <span class="col text-fs-3 fw-bold text-center">VIN</span>
                                        <span class="col text-fs-3 fw-bold text-center">Weight</span>
                                    </div>
                                    @php
                                        $units = 0;
                                        $weight = 0;
                                    @endphp
                                    @if(count(@$container->buyers) > 0)
                                    @foreach(@$container->buyers as $k => $v)
                                    @if(@$v->user->id == auth()->user()->id)
                                    @foreach($v->vehicles as $ke => $val)
                                    @php
                                        $units = $units + 1;
                                        $weight = $weight + @$val->vehicle->weight;
                                    @endphp
                                    <div class="row shadow border rounded-5 w-10 mb-3 py-4">
                                        <span class="col text-fs-3 text-center">{{ @$val->vehicle->modal.' '.@$val->vehicle->company_name.' '.@$val->vehicle->name }}</span>
                                        <span class="col text-fs-3 text-center">{{ @$val->vehicle->vin }}</span>
                                        <span class="col text-fs-3 text-center">{{ @$val->vehicle->weight }} kg</span>
                                    </div>
                                    @endforeach
                                    @endif
                                    @endforeach
                                    @endif
                                    <div class="row mb-3">
                                        <span class="col text-fs-3 text-center"></span>
                                        <span class="col text-fs-3 fw-bold text-center">Total {{ $units }} units</span>
                                        <span class="col text-fs-3 fw-bold text-center">{{ $weight }} kg</span>
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

            $(document).on("submit", ".form", function (event) {
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
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
    </script>

@endsection