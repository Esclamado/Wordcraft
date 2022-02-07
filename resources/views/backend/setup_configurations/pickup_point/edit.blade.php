@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Update Pickup Point Information')}}</h5>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-fill border-light">
      				@foreach (\App\Language::all() as $key => $language)
      					<li class="nav-item">
      						<a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('pick_up_points.edit', ['id'=>$pickup_point->id, 'lang'=> $language->code] ) }}">
      							<img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
      							<span>{{$language->name}}</span>
      						</a>
      					</li>
  		            @endforeach
      			</ul>

                <form class="p-4" action="{{ route('pick_up_points.update',$pickup_point->id) }}" method="POST">
                	<input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" value="{{ $pickup_point->getTranslation('name', $lang) }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="address">{{translate('Location')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                        <div class="col-sm-9">
                            <textarea name="address" rows="8" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" required>{{ $pickup_point->getTranslation('address', $lang) }}</textarea>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="phone">{{translate('Phone')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Phone')}}" id="phone" name="phone" value="{{ $pickup_point->phone }}" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" required>
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
                            <input type="number" name="handling_fee" id="handling_fee" value="{{ $pickup_point->handling_fee }}" class="form-control {{ $errors->has('handling_fee') ? 'is-invalid' : '' }}">
                            @if ($errors->has('handling_fee'))
                                <span class="invalid-feedbacl" role="alert">
                                    {{ $errors->first('handling_fee') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{translate('Pickup Point Status')}}</label>
                        <div class="col-sm-3">
                            <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                        		<input value="1" type="checkbox" name="pick_up_status"@if ($pickup_point->pick_up_status == 1) checked @endif>
                        		<span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Manager')}}</label>
                        <div class="col-sm-9">
                            <select name="staff_id[]" class="form-control aiz-selectpicker {{ $errors->has('staff_id') }}" data-live-search="true" multiple>
                                @foreach(\App\Staff::all() as $staff)
                                    @if ($staff->user != null && $staff->user->user_type == 'staff')
                                        <option value="{{ $staff->id }}" @if (in_array($staff->id, explode(',', $pickup_point->staff_id))) selected @endif>{{$staff->user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('staff_id'))
                                <span class="invalid-feedback" role="alert">
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
                                <option value="north_luzon" @if ($pickup_point->region == 'north_luzon') selected @endif>North Luzon</option>
                                <option value="south_luzon" @if ($pickup_point->region == 'south_luzon') selected @endif>South Luzon</option>
                                <option value="visayas" @if ($pickup_point->region == 'visayas') selected @endif>Visayas</option>
                                <option value="mindanao" @if ($pickup_point->region == 'mindanao') selected @endif>Mindanao</option>
                            </select>
                            @if ($errors->has('region'))
                                <span class="invalid-feedback" role="alert">
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
                                <option value="branch" @if ($pickup_point->type == 'branch') selected @endif>Branch</option>
                                <option value="warehouse" @if ($pickup_point->type == 'warehouse') selected @endif>Warehouse</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('type') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
