<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Business Name:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->business_name : 'N\A' }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Business Address:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->business_address : 'N\A' }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Nature of Business:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->nature_of_business : 'N\A' }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Office:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->office : 'N\A' }}
        </div>
    </div>
</div>

<div class="row d-flex align-items-center mb-2">
    <div class="col-5 col-md-2">
        <div class="customer-user-label">
            {{ translate('Years in Business:') }}
        </div>
    </div>
    <div class="col-5 col-md-10">
        <div class="customer-user-data">
            {{ $user->reseller != null ? $user->reseller->years_in_business : 'N\A' }}
        </div>
    </div>
</div>
