@extends('backend.layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Reason For Refund Request')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 col-from-label"><b>{{translate('Reason')}}:</b></label>
                    <div class="col-lg-8">
                        <p class="bord-all pad-all">{{ $refund->reason }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-lg-2 col-from-label"><b>{{ translate('Additional Information') }}</b></label>
                    <div class="col-lg-8">
                        <p class="bord-all pad-all">
                            {{ $refund->additional_information }}
                        </p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-lg-2 col-from-label"><b>{{ translate('Image') }}</b></label>
                    <div class="col-lg-8">
                        <p class="bord-all pad-all">
                            <img src="{{ uploaded_asset($refund->image) }}" class="img-fluid" alt="">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
