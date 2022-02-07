<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-4">
        <div class="customer-user-label">
            {{ translate('Business Name:') }}
        </div>
    </div>
    <div class="col-7 col-md-8">
        <div class="customer-user-data">
            {{ $reseller->reseller->reseller->business_name }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-4">
        <div class="customer-user-label">
            {{ translate('Business Address:') }}
        </div>
    </div>
    <div class="col-7 col-md-8">
        <div class="customer-user-data">
            {{ $reseller->reseller->reseller->business_address }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-4">
        <div class="customer-user-label">
            {{ translate('Nature of Business:') }}
        </div>
    </div>
    <div class="col-7 col-md-8">
        <div class="customer-user-data">
            {{ $reseller->reseller->reseller->nature_of_business }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-4">
        <div class="customer-user-label">
            {{ translate('Office:') }}
        </div>
    </div>
    <div class="col-7 col-md-8">
        <div class="customer-user-data">
            {{ $reseller->reseller->reseller->office }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-4">
        <div class="customer-user-label">
            {{ translate('Years in Business:') }}
        </div>
    </div>
    <div class="col-7 col-md-8">
        <div class="customer-user-data">
            {{ $reseller->reseller->reseller->years_in_business }}
        </div>
    </div>
</div>
