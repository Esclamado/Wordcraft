@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-lg-5 mx-auto">
            <form action="{{ route('user.login.verify') }}" method="POST">
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
@endsection