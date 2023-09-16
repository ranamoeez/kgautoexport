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
                            <div class="d-flex justify-content-end">
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
                            </div>
                        </div>

                        <div class="row container-details-card mb-3">
                            @if(count(@$container->container_documents) > 0)
                            @foreach($container->container_documents as $key => $value)
                            <div class="col-6">
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

                    <div class="col-md-6">
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
                            <div class="row shadow border rounded-5 w-100 mb-3 py-2">
                                <span class="col text-fs-3 fw-bold text-center">Email</span>
                                <span class="col text-fs-3 fw-bold text-center">Date</span>
                            </div>
                            <div class="row shadow border rounded-5 w-100 mb-3 py-2">
                                <span class="col text-fs-3 text-center">moh@gmail.com</span>
                                <span class="col text-fs-3 text-center">23.3.2023</span>
                            </div>
                            <div class="row shadow border rounded-5 w-100 mb-3 py-2">
                                <span class="col text-fs-3 text-center">Anas@tach.com</span>
                                <span class="col text-fs-3 text-center">3.3.2023</span>
                            </div>
                            <div class="row shadow border rounded-5 w-100 mb-3 py-2">
                                <span class="col text-fs-3 text-center">Ahmad@tools.com</span>
                                <span class="col text-fs-3 text-center">2.5.2023</span>
                            </div>
                        </div>
                    </div>

                    <div class="container mt-5">
                        <div class="d-flex justify-content-between">
                            <h4 class="fw-bold fs-md-13 fs-lg-25">
                                Container Information
                            </h4>
                            <div class="d-flex justify-content-end">
                                <div class="d-flex px-3 p-1 rounded-pill align-items-center shadow">
                                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path id="Vector"
                                            d="M1.32564 12.1964C1.40397 12.3933 1.5573 12.551 1.75189 12.6348C1.94649 12.7186 2.16642 12.7217 2.36329 12.6434C2.56017 12.5651 2.71787 12.4117 2.80169 12.2171C2.88552 12.0225 2.88861 11.8026 2.81028 11.6057L1.91631 9.35483L7.21631 8.18149V11.9729C7.21631 12.1846 7.30041 12.3876 7.4501 12.5373C7.59979 12.687 7.80281 12.7711 8.01451 12.7711C8.2262 12.7711 8.42923 12.687 8.57892 12.5373C8.72861 12.3876 8.8127 12.1846 8.8127 11.9729V8.18149L14.1127 9.35483L13.2187 11.6057C13.1799 11.7032 13.1606 11.8074 13.162 11.9123C13.1634 12.0173 13.1855 12.1209 13.227 12.2173C13.2686 12.3136 13.3287 12.4009 13.404 12.474C13.4792 12.5471 13.5682 12.6047 13.6657 12.6434C13.7597 12.6806 13.86 12.6995 13.9611 12.6993C14.1209 12.6994 14.2771 12.6516 14.4095 12.5619C14.5418 12.4723 14.6442 12.3449 14.7034 12.1964L15.9406 9.07547C15.983 8.96752 16.0015 8.85162 15.9946 8.73582C15.9877 8.62003 15.9556 8.50713 15.9007 8.40498C15.8473 8.30321 15.7726 8.21415 15.6817 8.1439C15.5908 8.07364 15.4858 8.02384 15.3739 7.9979L12.8037 7.43119V3.99097C12.8037 3.77928 12.7196 3.57625 12.5699 3.42656C12.4202 3.27687 12.2172 3.19278 12.0055 3.19278H10.4091V0.798194C10.4091 0.5865 10.325 0.383476 10.1753 0.233786C10.0256 0.0840952 9.82259 0 9.6109 0H6.41812C6.20643 0 6.0034 0.0840952 5.85371 0.233786C5.70402 0.383476 5.61993 0.5865 5.61993 0.798194V3.19278H4.02354C3.81184 3.19278 3.60882 3.27687 3.45913 3.42656C3.30944 3.57625 3.22534 3.77928 3.22534 3.99097V7.43119L0.65516 7.98194C0.543224 8.00788 0.438207 8.05768 0.347287 8.12793C0.256368 8.19819 0.181688 8.28725 0.128352 8.38902C0.0733794 8.49116 0.0413315 8.60406 0.034439 8.71986C0.0275465 8.83565 0.0459752 8.95156 0.0884419 9.0595L1.32564 12.1964ZM7.21631 1.59639H8.8127V3.19278H7.21631V1.59639ZM4.82173 4.78916H11.2073V7.072L8.19011 6.38555H7.83891L4.82173 7.072V4.78916ZM14.9668 13.7928C14.6867 13.8786 14.4185 13.9993 14.1686 14.152C13.9143 14.3007 13.625 14.379 13.3305 14.379C13.0359 14.379 12.7467 14.3007 12.4924 14.152C11.9394 13.84 11.3153 13.6761 10.6805 13.6761C10.0456 13.6761 9.42151 13.84 8.86858 14.152C8.61081 14.299 8.31921 14.3762 8.02249 14.3762C7.72577 14.3762 7.43417 14.299 7.1764 14.152C6.62297 13.8415 5.99906 13.6785 5.3645 13.6785C4.72995 13.6785 4.10604 13.8415 3.5526 14.152C3.29833 14.3007 3.00906 14.379 2.7145 14.379C2.41994 14.379 2.13067 14.3007 1.8764 14.152C1.62643 13.9993 1.35826 13.8786 1.0782 13.7928C0.971997 13.755 0.858997 13.7402 0.746643 13.7493C0.634289 13.7583 0.525128 13.7911 0.426346 13.8454C0.327563 13.8997 0.241401 13.9743 0.173529 14.0642C0.105657 14.1542 0.0576164 14.2576 0.0325683 14.3675C-0.0270203 14.5697 -0.00423422 14.7872 0.0959549 14.9726C0.196144 15.158 0.365604 15.2963 0.567358 15.3573C0.728085 15.4008 0.881426 15.4681 1.02233 15.5568C1.5066 15.841 2.05724 15.9924 2.61872 15.9958C3.20188 15.9959 3.77468 15.8417 4.27896 15.5488C4.59183 15.3762 4.94333 15.2857 5.30065 15.2857C5.65797 15.2857 6.00946 15.3762 6.32234 15.5488C6.82304 15.8351 7.38983 15.9857 7.96662 15.9857C8.5434 15.9857 9.11019 15.8351 9.6109 15.5488C9.92377 15.3762 10.2753 15.2857 10.6326 15.2857C10.9899 15.2857 11.3414 15.3762 11.6543 15.5488C12.149 15.8441 12.7144 16 13.2906 16C13.8667 16 14.4321 15.8441 14.9269 15.5488C15.0678 15.4601 15.2211 15.3928 15.3818 15.3493C15.4881 15.3278 15.5888 15.2849 15.6779 15.2232C15.767 15.1615 15.8426 15.0823 15.9001 14.9905C15.9576 14.8986 15.9958 14.796 16.0124 14.6889C16.029 14.5818 16.0235 14.4724 15.9964 14.3675C15.9711 14.2595 15.9235 14.1579 15.8567 14.0693C15.7898 13.9807 15.7053 13.9071 15.6084 13.853C15.5115 13.7989 15.4044 13.7656 15.2939 13.7553C15.1835 13.7449 15.072 13.7577 14.9668 13.7928Z"
                                            fill="black" />
                                    </svg>
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
                                        <input type="text" class="form-control" disabled />
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
                                    <label for="" class="col-md-2 fw-bold">Date of sail</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" disabled />
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
                                        <span class="col text-fs-3 text-center">{{ @$val->vehicle->company_name.' '.@$val->vehicle->name.' '.@$val->vehicle->modal }}</span>
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