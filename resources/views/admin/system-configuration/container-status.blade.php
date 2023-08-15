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
            <form action="">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="accordion" id="accordionConfig">
                            @include('admin.system-configuration.sidebar')
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <h3 class="fw-bold fs-5">Container Status</h3>
                                <button class="btn border-0">
                                    <img src="{{ asset('assets/plus_green.svg') }}" alt="add" />
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-fs-4">
                                        <th scope="col" class="fw-bold">Name</th>
                                        <th scope="col" class="fw-bold">Position</th>
                                        <th scope="col"></th>
                                    </thead>
                                    <tbody>
                                        @if(count(@$status) > 0)
                                        @foreach(@$status as $key => $value)
                                        <tr class="align-middle overflow-hidden shadow mb-2">
                                            <td>
                                                <p class=" text-fs-3">
                                                    {{ $value->name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class=" text-fs-3">
                                                    {{ $value->position }}
                                                </p>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center float-end">
                                                    <p class="fs-5 text-primary me-3">
                                                        <i class="fa-solid fa-edit" data-id="{{ $value->id }}" style="cursor: pointer;"></i>
                                                    </p>
                                                    <p class="fs-5 text-danger">
                                                        <i class="fa-solid fa-circle-xmark delete" data-id="{{ $value->id }}" style="cursor: pointer;"></i>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["ru", "jp", "pk", "no"]
        });
    </script>

@endsection