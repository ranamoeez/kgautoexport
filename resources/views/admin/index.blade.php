@extends('layouts.admin')

@section('content')

    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    My Vehicles List
                </h4>
            </div>

            <div class="row align-items-center">
                <div class="col-md-2">
                    <label for="Buyer" class="fw-semibold">Buyer</label>
                    <select id="Buyer" name="Buyer"
                        class="selectjs form-select p-2 border border-gray-200 rounded-lg">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="Terminal" class="fw-semibold">Terminal</label>
                    <select id="Terminal" name="Terminal" class="selectjs form-select p-2">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="Status" class="fw-semibold">Status</label>
                    <select id="Status" name="Status" class="selectjs form-select p-2">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="search" class="fw-semibold">Search</label>
                    <input type="text" class="form-control p-2" placeholder="search">
                </div>

                <div class="col-md-2">
                    <label for="Status" class="fw-semibold">Destination</label>
                    <select id="Status" name="Status" class="selectjs form-select p-2">
                        <option value="All" selected>All</option>
                        <option value="option1">Option1</option>
                        <option value="option2">Option2</option>
                        <option value="option3">Option3</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">Only unpaid</label>
                    </div>
                </div>
            </div>


            <div>
                <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">

                    <div class="d-flex gap-2 align-items-center page-icon">
                        <button class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                        <p class="text-fs-4 m-0">Page 1</p>
                        <button class="btn p-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-fs-4">
                            <th scope="col"></th>
                            <th scope="col" class="fw-bold">Vehicle Photo</th>
                            <th scope="col" class="fw-bold">Delivery Date</th>
                            <th scope="col" class="fw-bold">Description</th>
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Buyer</th>
                            <th scope="col" class="fw-bold">Client Name</th>
                            <th scope="col" class="fw-bold">Destination</th>
                            <th scope="col" class="fw-bold">Title</th>
                            <th scope="col" class="fw-bold">key</th>
                            <th scope="col" class="fw-bold">Price</th>
                            <th scope="col" class="fw-bold">Status</th>
                            <th scope="col" class="fw-bold">Terminal</th>
                            <th scope="col" class="fw-bold">Notes</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href class="text-link text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </a>
                                        <a href class="text-link text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <img src="{{ asset('assets/FordExplorerXLT.webp') }}"
                                        class="rounded-4 table-thumbnail-image" />
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        23, 3 ,2023
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Toyota LC200 Land cruiser, 2019

                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        PL5473829
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Adham
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Mohammad
                                    </span>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4 p-1 rounded-pill shadow">
                                        <span class="text-fs-4 ms-1">Aqaba</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1"
                                            style="background-position: right; min-width: 50px"
                                            aria-label="Default select example">
                                            <option value="1" data-color="danger">No</option>
                                            <option value="2" data-color="success">Yes</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1"
                                            style="background-position: right; min-width: 50px"
                                            aria-label="Default select example">
                                            <option value="1" data-color="success">Yes</option>
                                            <option value="2" data-color="danger">No</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select"
                                            aria-label="Default select example">
                                            <option value="1">56,679</option>
                                            <option value="2" data-color="danger">56,679</option>
                                        </select>
                                    </div>
                                </td>

                                <td>
                                    <div class="text-center text-fs-4">
                                        <select id="selectOption" class="form-select"
                                            aria-label="Default select example">
                                            <option value="1">New</option>
                                            <option value="2">Old</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Newyork,USA
                                    </span>
                                </td>
                                <td>
                                    <div class="border border-1 p-2 rounded-3">
                                        <p class="text-fs-3 m-0">
                                            Title received on 12/18
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center items-center message-icon">
                                        <i class="fa-circle-minus fa-solid fs-3 text-danger"
                                            data-bs-toggle="modal" data-bs-target="#removeRowModal"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href class="text-link text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </a>
                                        <a href class="text-link text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <img src="{{ asset('assets/FordExplorerXLT.webp') }}"
                                        class="rounded-4 table-thumbnail-image" />
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        23, 3 ,2023
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Toyota LC200 Land cruiser, 2019

                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        PL5473829
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Adham
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Mohammad
                                    </span>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4 p-1 rounded-pill shadow">
                                        <span class="text-fs-4 ms-1">Aqaba</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1"
                                            style="background-position: right; min-width: 50px"
                                            aria-label="Default select example">
                                            <option value="1" data-color="danger">No</option>
                                            <option value="2" data-color="success">Yes</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1"
                                            style="background-position: right; min-width: 50px"
                                            aria-label="Default select example">
                                            <option value="1" data-color="success">Yes</option>
                                            <option value="2" data-color="danger">No</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1"
                                            style="background-position: right; min-width: 50px"
                                            aria-label="Default select example">
                                            <option value="1" data-color="danger">56,679</option>
                                            <option value="2" data-color="success">56,679</option>
                                        </select>
                                    </div>
                                </td>

                                <td>
                                    <div class="text-center text-fs-4">
                                        <select id="selectOption" class="form-select"
                                            aria-label="Default select example">
                                            <option value="1">New</option>
                                            <option value="2">Old</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-fs-3">
                                        Newyork,USA
                                    </span>
                                </td>
                                <td>
                                    <div class="border border-1 p-2 rounded-3">
                                        <p class="text-fs-3 m-0">
                                            Title received on 12/18
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center items-center message-icon">
                                        <i class="fa-circle-minus fa-solid fs-3 text-danger"
                                            data-bs-toggle="modal" data-bs-target="#removeRowModal"></i>
                                    </div>
                                </td>
                            </tr>
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
                                    <a href="#" class="btn btn-danger border-0 mt-4 col-md-12 rounded-3 fs-5"
                                        data-bs-dismiss="modal">Ok</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-warning border-0 mt-4 col-md-12 rounded-3 fs-5"
                                        data-bs-dismiss="modal">Cancel</a>
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