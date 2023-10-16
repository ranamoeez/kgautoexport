<div class="accordion-item active">
    <div class="">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#ConfigOne" class="btn btn-primary p-10 border-0">System Configuration <i class="fa-solid fa-angle-right"></i>
        </button>
    </div>
    <div id="ConfigOne" class="accordion-collapse collapse show show"
        aria-labelledby="headingOne" data-bs-parent="#accordionConfig">
        <div class="accordion-body">
            <div class="d-flex flex-column">
                <a href="{{ url('admin/system-configuration/users') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Users
                </a>
                @if(\Auth::user()->id == '1')
                <a href="{{ url('admin/system-configuration/admins') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Admins
                </a>
                @endif
                <a href="{{ url('admin/system-configuration/operators') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Operators
                </a>
                <a href="{{ url('admin/system-configuration/group-list') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    List of groups
                </a>
                <a href="{{ url('admin/system-configuration/login-history') }}"
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
                <a href="{{ url('admin/system-configuration/shipper') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Shipper
                </a>
                <a href="{{ url('admin/system-configuration/consignee') }}"
                    class="fw-semibold text-dark text-decoration-none">
                    Consignee
                </a>
                <a href="{{ url('admin/system-configuration/terminal') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Terminal
                </a>
                <a href="{{ url('admin/system-configuration/pre-carriage') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Pre carriage
                </a>
                <a href="{{ url('admin/system-configuration/loading-port') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Loading port
                </a>
                <a href="{{ url('admin/system-configuration/discharge-port') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Discharge port
                </a>
                <a href="{{ url('admin/system-configuration/destination-port') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Destination port
                </a>
                <a href="{{ url('admin/system-configuration/notify-party') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Notify party
                </a>
                <a href="{{ url('admin/system-configuration/measurement') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Measurement
                </a>
                <a href="{{ url('admin/system-configuration/shipping-line') }}"
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
                <a href="{{ url('admin/system-configuration/terminal') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Auto Terminal
                </a>
                <a href="{{ url('admin/system-configuration/auction') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Auction
                </a>
                <a href="{{ url('admin/system-configuration/auction-location') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Auction location
                </a>
                <a href="{{ url('admin/system-configuration/posts') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Posts for sale
                </a>
                <a href="{{ url('admin/system-configuration/carriers') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Carriers
                </a>
                <a href="{{ url('admin/system-configuration/shipping-company') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Shipping Company
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

                <a href="{{ url('admin/system-configuration/mail-templates') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Mail templates
                </a>
                <a href="{{ url('admin/system-configuration/send-to-all-users') }}"
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
                <a href="{{ url('admin/system-configuration/reminder-templates') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Reminder Templates
                </a>
                <a href="{{ url('admin/system-configuration/vehicles-brand') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Vehicles Brand
                </a>
                <a href="{{ url('admin/system-configuration/vehicles-modal') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Vehicles Model
                </a>
                <a href="{{ url('admin/system-configuration/fine-type') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Auction Fine Type
                </a>
                <a href="{{ url('admin/system-configuration/trans-fine-type') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Trans. Fine Type
                </a>
                <a href="{{ url('admin/system-configuration/user-levels') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    User Levels
                </a>
                @if(\Auth::user()->id == '1')
                <a href="{{ url('admin/system-configuration/admin-levels') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Admin Levels
                </a>
                <a href="{{ url('admin/system-configuration/operator-levels') }}"
                    class="fw-semibold text-dark text-decoration-none fs-6">
                    Operator Levels
                </a>
                @endif
            </div>
        </div>
    </div>
</div>