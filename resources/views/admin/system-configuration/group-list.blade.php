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
                            <h3 class="fw-bold fs-5">List of Groups</h3>
                            <button class="btn border-0 add" type="button">
                                <img src="{{ asset('assets/plus_green.svg') }}" alt="add" />
                            </button>
                            <div class="modal fade new buyer" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog rounded-5" style="max-width: 746px; width: 746px;">
                                    <div class="modal-content p-3">
                                        <div class="modal-header border-0">
                                            <h1 class="modal-title fw-bold" id="modalLabel" style="font-size: 28px">Add New Group</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('admin/system-configuration/group-list/add') }}" method="POST" class="form">
                                                @csrf
                                                <div class="row mt-4">

                                                    <div class="col-md-12 mb-4">
                                                        <!-- username -->
                                                        <div class="row">
                                                            <label for="" class="col-md-4">Name</label>
                                                            <div class="col-md-8">
                                                                <div class="input-group shadow-lg rounded-4">
                                                                    <input type="text" name="name" id="name" value=""
                                                                        class="py-2 form-control rounded-end-4"
                                                                        required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="d-flex justify-content-center mt-4">
                                                    <button class="btn btn-primary px-5" type="submit">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">
                            <div class="d-flex gap-2 align-items-center page-icon">
                                @php
                                    $prev = (int)$page - 1;
                                    $next = (int)$page + 1;
                                    $pre = 'page='.$prev;
                                    $nex = 'page='.$next;
                                @endphp
                                <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/system-configuration/group-list?'.$pre) }}" @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </a>
                                <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                                <a class="btn" @if(count($group) < 10) href="javascript:void();" @else href="{{ url('admin/system-configuration/group-list?'.$nex) }}" @endif>
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
                                    <th scope="col" class="fw-bold">Title</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @if(count(@$group) > 0)
                                    @foreach(@$group as $key => $value)
                                    <tr class="align-middle overflow-hidden shadow mb-2">
                                        <td>
                                            <p class=" text-fs-3">
                                                {{ @$value->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center float-end">
                                                <p class="fs-5 text-primary me-3">
                                                    <i class="fa-solid fa-edit edit" data-id="{{ @$value->id }}" style="cursor: pointer;"></i>
                                                </p>
                                                <p class="fs-5 text-danger">
                                                    <i class="fa-solid fa-circle-xmark delete" data-url="{{ url('admin/system-configuration/group-list/delete', @$value->id) }}" style="cursor: pointer;"></i>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2">No data found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade remove" id="removeRowModal" tabindex="-1"
                        aria-labelledby="removeRowModalLabel" aria-hidden="true">
                        <div class="modal-dialog rounded-5">
                            <div class="modal-content p-3">
                                <div class="modal-header border-0">
                                    <h1 class="modal-title fw-bold" id="removeRowModalLabel" style="font-size: 28px">
                                        Delete this Record?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <button id="delete-link" type="button" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5">Ok</button>
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

        $(document).ready(function () {
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
                            toastr["success"](res.msg, "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr["error"](res.msg, "Failed!");
                        }
                    }
                });
            });

            $(document).on("click", ".add", function () {
                
                $("#modalLabel").text("Add New Group");
                $("#name").val('');
                $("#position").val('');

                $("#modal").modal("show");
                $(".form").attr("action", "{{ url('admin/system-configuration/group-list/add') }}");
                        
            });

            $(document).on("click", ".edit", function () {
                var id = $(this).attr("data-id");

                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/system-configuration/group-list/edit') }}/"+id,
                    success: function (res) {
                        res = JSON.parse(res);
                        console.log(res);
                        if (res.success == true) {
                            $("#modalLabel").text("Edit Group");
                            $("#name").val(res.data.name);
                            $("#position").val(res.data.position);

                            $("#modal").modal("show");
                            $(".form").attr("action", "{{ url('admin/system-configuration/group-list/edit') }}/"+id);
                        }
                    }
                });
            });

            $(document).on("click", ".delete", function () {
                $("#delete-link").attr("data-url", $(this).attr('data-url'));
                $("#removeRowModal").modal("show");
            });
            $(document).on("click", "#delete-link", function () {
                $.ajax({
                    type: "GET",
                    url: $(this).attr("data-url"),
                    success: function (res) {
                        res = JSON.parse(res);
                        $("#removeRowModal").modal("hide");
                        if (res.success == true) {
                            toastr["success"](res.msg, "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>

@endsection