@extends('frontend.layouts.app')

@section('content')

<div class="py-6">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                <div class="position-absolute">
                    <div class="img-1"></div>
                    <div class="img-4"></div>
                </div>
                <div class="bg-white rounded shadow-sm p-4 text-left">
                    <h1 class="h3 fw-600 header-title">{{ translate('Forgot Password?') }}</h1>
                    <p class="mb-4 text-subprimary">{{translate('Enter your email address to recover your password.')}} </p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-craft form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email / Phone') }}" name="email">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-block btn-login" type="submit">
                                {{ translate('Send Password Reset Link') }}
                            </button>
                        </div>
                    </form>
                    <div class="mt-3">
                        <a href="{{route('user.login')}}" class="text-reset opacity-60 text-subprimary">{{translate('Back to Login')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
