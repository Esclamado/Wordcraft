@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 h6">{{ translate('Basic Affiliate')}}</h6>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('affiliate.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="type" value="user_registration_first_purchase">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('User Registration & First Purchase')}}</label>
                            </div>
                            <div class="col-lg-6">
                                @php
                                    if(\App\AffiliateOption::where('type', 'user_registration_first_purchase')->first() != null){
                                        $percentage = \App\AffiliateOption::where('type', 'user_registration_first_purchase')->first()->percentage;
                                        $status = \App\AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status;
                                    }
                                    else {
                                        $percentage = null;
                                    }
                                @endphp
                                <input type="number" min="0" step="0.01" max="100" class="form-control" name="percentage" value="{{ $percentage }}" placeholder="Percentage of Order Amount" required>
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label">%</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('Status')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="status" type="checkbox" @if ($status)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6">{{ translate('Product Sharing Affiliate')}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('affiliate.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                          <input type="hidden" name="type" value="product_sharing">
            							<label class="col-lg-3 col-from-label">{{ translate('Product Sharing and Purchasing')}}</label>
            							<div class="col-lg-6">
                            @php
                                if(\App\AffiliateOption::where('type', 'product_sharing')->first() != null && \App\AffiliateOption::where('type', 'product_sharing')->first()->details != null){
                                    $commission_product_sharing = json_decode(\App\AffiliateOption::where('type', 'product_sharing')->first()->details)->commission;
                                    $commission_type_product_sharing = json_decode(\App\AffiliateOption::where('type', 'product_sharing')->first()->details)->commission_type;
                                    $status = \App\AffiliateOption::where('type', 'product_sharing')->first()->status;
                                }
                                else {
                                    $commission_product_sharing = null;
                                    $commission_type_product_sharing = null;
                                }
                            @endphp
                            <input type="number" min="0" step="0.01" max="100" class="form-control" name="amount" value="{{ $commission_product_sharing }}" placeholder="Percentage of Order Amount" required>
            							</div>
            							<div class="col-md-3">
            								<select class="form-control aiz-selectpicker" name="amount_type">
                              <option value="amount" @if ($commission_type_product_sharing == "amount") selected @endif>$</option>
                              <option value="percent" @if ($commission_type_product_sharing == "percent") selected @endif>%</option>
            								</select>
            							</div>
            						</div>
                        <div class="form-group row">
                          <div class="col-lg-4">
                              <label class="control-label">{{ translate('Status')}}</label>
                          </div>
                          <div class="col-lg-8">
                              <label class="aiz-switch aiz-switch-success mb-0">
                                  <input value="1" name="status" type="checkbox" @if ($status)
                                      checked
                                  @endif>
                                  <span class="slider round"></span>
                              </label>
                          </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6">{{ translate('Employee - Reseller Commission')}}</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('affiliate.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <input type="hidden" name="type" value="employee_reseller_commission">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('Employee - Reseller Commission')}}</label>
                            </div>
                            <div class="col-lg-6">
                                @php
                                    if(\App\AffiliateOption::where('type', 'employee_reseller_commission')->first() != null){
                                        $percentage = \App\AffiliateOption::where('type', 'employee_reseller_commission')->first()->percentage;
                                        $status = \App\AffiliateOption::where('type', 'employee_reseller_commission')->first()->status;
                                    }
                                    else {
                                        $status = null;
                                        $percentage = null;
                                    }
                                @endphp
                                <input type="number" min="0" step="0.01" max="100" class="form-control" name="percentage" value="{{ $percentage }}" placeholder="Percentage of Order Amount" required>
                            </div>
                            <div class="col-lg-2">
                                <label class="control-label">%</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('Status')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="status" type="checkbox" @if ($status)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6">
                        {{ translate('Minimum First Purchase') }}
                    </h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('affiliate.store') }}" method="post">
                        @csrf

                        <div class="form-group row">
                            <input type="hidden" name="type" value="minimum_first_purchase">
                            <div class="col-lg-4">
                                <label for="" class="control-label">{{ translate('Minimum First Purchase') }}</label>
                            </div>
                            <div class="col-lg-6">
                                @php
                                    if (\App\AffiliateOption::where('type', 'minimum_first_purchase')->first() != null) {
                                        $percentage = \App\AffiliateOption::where('type', 'minimum_first_purchase')->first()->percentage;

                                        $status = \App\AffiliateOption::where('type', 'minimum_first_purchase')->first()->status;
                                    }

                                    else {
                                        $status = null;
                                        $percentage = null;
                                    }
                                @endphp

                                <input type="number" min="0" name="percentage" class="form-control" value="{{ $percentage }}" placeholder="Minimum First Purchase Amount" required>
                            </div>
                            <div class="col-lg-2">
                                <label for="" class="control-label">$</label>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
