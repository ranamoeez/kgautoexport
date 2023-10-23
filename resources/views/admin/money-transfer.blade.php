@extends('layouts.admin')

@section('title')
    Money Transfer
@endsection

@section('content')

    <div class="below-header-height outer-container">
        <div class="inner-container">

            <div class="d-flex justify-content-between">
                <h4 class="fw-bold fs-md-13 fs-lg-25">
                    Money Transfer
                </h4>
            </div>

            <div>
                <div class="d-flex justify-content-between mt-3 align-items-center justify-content-lg-end">

                    <div class="d-flex gap-2 align-items-center page-icon">
                        @php
                            $prev = (int)$page - 1;
                            $next = (int)$page + 1;
                            $pre = 'page='.$prev;
                            $nex = 'page='.$next;
                        @endphp
                        <a class="btn" @if(@$page == 1) href="javascript:void();" @else href="{{ url('admin/money-transfer?'.$pre) }}" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </a>
                        <p class="text-fs-4 m-0">Page {{ @$page }}</p>
                        <a class="btn" @if(count($list) < 10) href="javascript:void();" @else href="{{ url('admin/money-transfer?'.$nex) }}" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fs-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-fs-4">
                            <th scope="col" class="fw-bold">ID</th>
                            <th scope="col" class="fw-bold">Buyer</th>
                            <th scope="col" class="fw-bold">VIN</th>
                            <th scope="col" class="fw-bold">Amount</th>
                            <th scope="col" class="fw-bold">Exchange Company</th>
                            <th scope="col" class="fw-bold">Transfer Number</th>
                            <th scope="col" class="fw-bold">Comment</th>
                            <th scope="col" class="fw-bold">Status</th>
                        </thead>
                        <tbody>
                            @if(count(@$list) > 0)
                            @foreach(@$list as $key => $value)
                            <tr class="align-middle overflow-hidden shadow mb-2">
                                <td>
                                    <p class="text-fs-3">
                                        {{ @$value->id }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->user->name }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->vehicle->vin }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        ${{ @$value->amount }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->exchange_company }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->transfer_no }}
                                    </p>
                                </td>
                                <td>
                                    <p class=" text-fs-3">
                                        {{ @$value->comment }}
                                    </p>
                                </td>
                                <td>
                                    <div class="text-center text-fs-4">
                                        <select class="form-select option-select text-white ps-1 pe-2 py-1 status" style="background-position: right; min-width: 50px" aria-label="Default select example" data-id="{{ @$value->id }}">
                                            <option value="waiting" data-color="warning" @if(@$value->status == "waiting") selected @endif>Waiting</option>
                                            <option value="approved" data-color="success" @if(@$value->status == "approved") selected @endif>Approved</option>
                                            <option value="rejected" data-color="danger" @if(@$value->status == "rejected") selected @endif>Rejected</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr id="row" class="align-middle overflow-hidden shadow mb-2">
                                <td class="text-center" colspan="8">
                                    <p>No record found</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        // Function to update the background color (selected option)
        $(document).ready(function () {
            // Get the modal
            var modal = document.getElementById("myModal");

            $(".myImg").click(function () {
                $("#myModal").css("display", "block");
                $("#img01").attr("src", $(this).attr("src"));
            });

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() { 
                modal.style.display = "none";
            }

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

            $(document).on("change", "#buyer, #destination, #search-veh, #pay_status", function () {
                $("#filters-form").submit();
            });

            $(document).on("change", ".status", function () {
                var form = new FormData();
                form.append("status", $(this).find("option:selected").val());
                form.append("id", $(this).attr("data-id"));

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/update-money-data") }}',
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
                            toastr["success"]("Status updated successfully!", "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2-selection--single').removeClass('select2-selection--single');
            $(document).on("change", "#buyer, #terminal, #status, #destination, #search-veh, #unpaid", function () {
                $("#filters-form").submit();
            });
        });
    </script>

@endsection