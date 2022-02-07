<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Company Name:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->company_name : "N/A" }}
        </div>
    </div>
</div>
<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Company Address:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->company_address : "N/A" }}
        </div>
    </div>
</div>
<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Company Contact No.:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->telephone_number : "N/A" }}
        </div>
    </div>
</div>
