@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Payment Channel Information') }}</h5>
            </div>
            <div class="card-body">
                <form class="" action="{{ route('payment-channels.store') }}" method="post">
                    @csrf

                    <div class="form-group row">
                        <label for="payment_method" class="col-sm-3 control-label">{{ translate('Payment Method') }}</label>
                        <div class="col-sm-9">
                            <select name="payment_method" id="payment_method_id" class="form-control aiz-selectpicker {{ $errors->has('payment_method') ? 'is-invalid is-invalid-pass' : '' }}" data-live-search="true">
                                <option value="">Select Payment Method</option>
                                @foreach ($payment_methods as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('payment_method'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    {{ $errors->first('payment_method') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Name" class="col-sm-3 control-label">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="image" class="col-sm-3 control-label">{{ translate('Image') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group {{ $errors->has('image') ? 'is-invalid' : '' }}" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="image" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    {{ $errors->first('image') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">{{ translate('Value') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="value" class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" placeholder="{{ translate('Value') }}">
                            @if ($errors->has('value'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('value') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-3 col-from-label">{{ translate("Additional Fee") }}</label>
                        <div class="col-md-6">
                            <input type="number" name="fee" id="fee" min="0" value="0" step="0.01" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}">
                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <select name="rate" id="rate" class="form-control aiz-selectpicker">
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">{{ translate('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"></textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('description') }}
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
