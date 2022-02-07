@extends('frontend.layouts.app')

{{-- @section('content')
    <div class="row">
        <div class="col-12 col-lg-5 mx-auto">
            <form action="{{ route('walkin.verify') }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ translate("Verification") }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="" class="col-from-label">OTP Code</label>
                            <div>
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code">
                                @if ($errors->has('code'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('code') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div>
                            A code is sent to <b>{{ $user->name }}</b>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection --}}

@section('content')
    <div class="login-cont py-5">
        <img class="box" src="{{ static_asset('assets/img/box.png') }}">
        <img class="box1" src="{{ static_asset('assets/img/box.png') }}">
        <div class="login-form px-5 py-5">
            <img src="{{ static_asset('assets/img/otp.png') }}" alt="{{ env('APP_NAME') }}" class="h-85px">
            <span class="d-flex flex-column align-items-center" style="row-gap: 10px;">
                <span class="login-title">{{ translate('Verification')}}</span>
                <span>{{ translate('Enter the verification code sent to your number ')}}</span>
            </span>
            <form style="width: 80%;" action="{{ route('walkin.verify') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code">
                    @if ($errors->has('code'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('code') }}
                        </span>
                    @endif
                </div>
                <div class="text-center">
                    <p class="form-label c-pointer">{{ translate("Didn't receive a code?")}} <a style="color: #D73019;" href="{{ route('verification.phone.resend',['id' => encrypt($user->id) ]) }}">{{ translate('Request Again')}}</a></p>
                </div>
                <div class="mt-5 mb-3">
                    <button type="submit" class="btn btn-primary btn-block fw-600 btn-login">{{  translate('Confirm') }}</button>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn fw-600 btn-cancel">{{  translate('Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection