@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Pickup Point Information')}}</h5>
            </div>
            <form action="{{ route('pick_up_points.store') }}" method="POST">
            	@csrf
                <div class="card-body">
                    <div class="form-group row row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row row">
                        <label class="col-sm-3 col-from-label" for="address">{{translate('Location')}}</label>
                        <div class="col-sm-9">
                            <textarea name="address" rows="8" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" required></textarea>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row row">
                        <label class="col-sm-3 col-from-label" for="phone">{{translate('Phone')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Phone')}}" id="phone" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="handling_fee" class="col-sm-3 col-from-label">{{ translate('Handling Fee') }}</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Handling Fee" name="handling_fee" class="form-control {{ $errors->has('handling_fee') ? 'is-invalid' : '' }}" required>
                            @if ($errors->has('handling_fee'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('handling_fee') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row row">
                        <label class="col-sm-3 col-from-label">{{translate('Pickup Point Status')}}</label>
                        <div class="col-sm-3">
                            <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                        		<input value="1" type="checkbox" name="pick_up_status">
                        		<span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Pick-up Point Manager')}}</label>
                        <div class="col-sm-9">
                            <select name="staff_id" class="form-control aiz-selectpicker {{ $errors->has('staff_id') ? 'is-invalid' : '' }}" required data-live-search="true" required multiple>
                                @foreach(\App\Staff::all() as $staff)
                                    @if ($staff->user != null && $staff->user->user_type == 'staff')
                                        <option value="{{$staff->id}}">{{$staff->user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('staff_id'))
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $errors->first('staff_id') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row row">
                        <label for="region" class="col-sm-3 col-form-label">{{ translate('Island') }}</label>
                        <div class="col-sm-9">
                            <select class="form-control aiz-selectpicker {{ $errors->has('region') ? 'is-invalid' : '' }}" name="region" id="region" data-live-search="true" required>
                                <option value="">Select Island</option>
                                <option value="north_luzon">North Luzon</option>
                                <option value="south_luzon">South Luzon</option>
                                <option value="visayas">Visayas</option>
                                <option value="mindanao">Mindanao</option>
                            </select>
                            @if ($errors->has('region'))
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $errors->first('region') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row row">
                        <label for="" class="col-sm-3 col-form-label">{{ translate('Pickup Point Type') }}</label>
                        <div class="col-sm-9">
                            <select name="type" id="" class="form-control aiz-selectpicker {{ $errors->has('type') ? 'is-invalid' : '' }}">
                                <option value="">Select Type</option>
                                <option value="branch">Branch</option>
                                <option value="Warehouse">Warehouse</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $errors->first('type') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
