@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">
                    {{ translate('Store Location Information') }}
                </h5>
            </div>
            <div class="card-body">
                <form class="" action="{{ route('store-locations.store') }}" method="post">
                    @csrf

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Island</label>
                        <div class="col-sm-9">
                            <select name="island_name" id="" class="form-control aiz-selectpicker {{ $errors->has('island_name') ? 'is-invalid' : '' }}">
                                <option value="north_luzon">North Luzon</option>
                                <option value="south_luzon">South Luzon</option>
                                <option value="visayas">Visayas</option>
                                <option value="mindanao">Mindanao</option>
                            </select>
                            @if ($errors->has('island_name'))
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $errors->has('island_name') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Store Location Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Store Location Address</label>
                        <div class="col-sm-9">
                            <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">
                            @if ($errors->has('address'))
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Phone Number</label>
                        <div class="col-sm-9">
                            <input type="text" name="phone_number" class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}">
                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('phone_number') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Google Maps URL</label>
                        <div class="col-sm-9">
                            <input type="text" name="google_maps_url" class="form-control {{ $errors->has('google_maps_url') ? 'is-invalid' : '' }}">
                            @if ($errors->has('google_maps_url'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('google_maps_url') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <br>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
