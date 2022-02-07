@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Payment Method Information') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('payment_methods.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 control-label">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Payment Method Name">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Value" class="col-sm-3 control-label">{{ translate('Value') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" placeholder="Payment Method Value">
                            @if ($errors->has('value'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('value') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <br>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
