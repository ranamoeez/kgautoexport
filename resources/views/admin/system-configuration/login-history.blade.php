@extends('layouts.admin')

@section('title')
    System Configuration
@endsection

@section('content')
    
    <div class="below-header-height outer-container">
        <div class="inner-container">
            <div class="px-14 d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    System Configuration
                </h4>
            </div>
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="accordion" id="accordionConfig">
                        @include('admin.system-configuration.sidebar')
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bold fs-5">Users Login History</h3>
                        </div>
                        <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">
                            <div class="d-flex gap-2 align-items-center page-icon">
                                @php
                                    $prev = (int)$page - 1;
                                    $next = (int)$page + 1;
                                    $pre = 'page='.$prev;
                                    $nex = 'page='.$next;
                                @endphp
                                <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/system-configuration/login-history?'.$pre) }}" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </a>
                                <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                                <a class="btn" @if(count($history) < 10) href="javascript:void();" @else href="{{ url('admin/system-configuration/login-history?'.$nex) }}" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-fs-4">
                                    <th scope="col" class="fw-bold">Username</th>
                                    <th scope="col">Date</th>
                                </thead>
                                <tbody>
                                    @if(count(@$history) > 0)
                                    @foreach(@$history as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <p class=" text-fs-3">
                                                {{ @$value->user->surname }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class=" text-fs-3">
                                                @if(@$value->datetime) {{ date("M d, Y H:i:s", strtotime(@$value->datetime)) }} @endif
                                            </p>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                        <td class="text-center" colspan="2">
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
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
    </script>

@endsection