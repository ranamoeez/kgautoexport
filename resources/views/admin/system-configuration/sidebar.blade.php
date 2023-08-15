<div class="accordion-item active">
    <div class="">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#ConfigOne" class="btn btn-primary p-10 border-0">System Configuration <i class="fa-solid fa-angle-right"></i>
        </button>
    </div>
    <div id="ConfigOne" class="accordion-collapse collapse show show"
        aria-labelledby="headingOne" data-bs-parent="#accordionConfig">
        <div class="accordion-body">
            <div class="d-flex flex-column">
                <a href="{{ url('admin/systemConfiguration-users.html') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Users
                </a>
                <a href="{{ url('admin/systemConfiguration-adminRole.html') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Admin
                </a>
                <a href="{{ url('admin/systemConfiguration-listOfGroup.html') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    List of groups
                </a>
                <a href="{{ url('admin/systemConfiguration-loginHistory.html') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Log in history
                </a>
            </div>
        </div>
    </div>
</div>
<div class="accordion-item">
    <div class="" id="config-">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#ConfigFive"
            class="btn btn-primary p-10 border-0">Container Configuration <i
                class="fa-solid fa-angle-right"></i></button>
    </div>
    <div id="ConfigFive" class="accordion-collapse collapse show"
        aria-labelledby="headingOne" data-bs-parent="#accordionConfig">
        <div class="accordion-body">
            <div class="d-flex flex-column">

                <a href="{{ url('admin/system-configuration/container-status') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Status
                </a>
                <a href="{{ url('admin/systemConfiguration-shipper.html') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Shipper
                </a>
                <a href="{{ url('admin/systemConfiguration-consignee.html') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Consignee
                </a>
                <a href="{{ url('admin/systemConfiguration-terminal.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Terminal
                </a>
                <a href="{{ url('admin/systemConfiguration-preCarriage.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Pre carriage
                </a>
                <a href="{{ url('admin/systemConfiguration-loadingPort.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Loading port
                </a>
                <a href="{{ url('admin/systemConfiguration-dischargePort.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Discharge port
                </a>
                <a href="{{ url('admin/systemConfiguration-destinationPort.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Destination port
                </a>
                <a href="{{ url('admin/systemConfiguration-notify.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Notify party
                </a>
                <a href="{{ url('admin/systemConfiguration-measurement.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Measurement
                </a>
                <a href="{{ url('admin/systemConfiguration-shippingLine.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Shipping line
                </a>
            </div>
        </div>
    </div>
</div>
<div class="accordion-item">
    <div class="" id="config-">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#ConfigTwo"
            class="btn btn-primary p-10 border-0">Auto Configuration <i
                class="fa-solid fa-angle-right"></i></button>
    </div>
    <div id="ConfigTwo" class="accordion-collapse collapse show"
        aria-labelledby="headingOne" data-bs-parent="#accordionConfig">
        <div class="accordion-body">
            <div class="d-flex flex-column">

                <a href="{{ url('admin/system-configuration/auto-status') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Status
                </a>
                <a href="{{ url('admin/systemConfiguration-autoTarminal.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Auto Terminal
                </a>
                <a href="{{ url('admin/systemConfiguration-auction.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Auction
                </a>
                <a href="{{ url('admin/systemConfiguration-auctionLocation.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Auction location
                </a>
            </div>
        </div>
    </div>
</div>
<div class="accordion-item">
    <div class="" id="config-">
        <button type="button" data-bs-toggle="collapse"
            data-bs-target="#ConfigThree" class="btn btn-primary p-10 border-0">Mail
            Configuration <i class="fa-solid fa-angle-right"></i></button>
    </div>
    <div id="ConfigThree" class="accordion-collapse collapse show"
        aria-labelledby="headingOne" data-bs-parent="#accordionConfig">
        <div class="accordion-body">
            <div class="d-flex flex-column">

                <a href="{{ url('admin/systemConfiguration-mailTemplate.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Mail templates
                </a>
                <a href="{{ url('admin/systemConfiguration-sendToAllUser.htm') }}l"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Send to all users
                </a>
            </div>
        </div>
    </div>
</div>
<div class="accordion-item">
    <div class="" id="config-">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#ConfigFour"
            class="btn btn-primary p-10 border-0">More Features <i
                class="fa-solid fa-angle-right"></i></button>
    </div>
    <div id="ConfigFour" class="accordion-collapse collapse show"
        aria-labelledby="headingOne" data-bs-parent="#accordionConfig">
        <div class="accordion-body">
            <div class="d-flex flex-column">
                <a href="{{ url('admin/systemConfiguration-reminderTemplates.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Reminder Templates
                </a>
                <a href="{{ url('admin/systemConfiguration-pickupHistory.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Pickup History
                </a>
                <a href="{{ url('admin/systemConfiguration-vehicleBrands.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Vehicles Brand
                </a>
                <a href="{{ url('admin/systemConfiguration-userLevel.html') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    User Level
                </a>
            </div>
        </div>
    </div>
</div>