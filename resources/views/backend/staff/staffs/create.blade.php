@extends('backend.layouts.app')

@section('content')
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Staff Information') }}</h5>
            </div>

            <form action="{{ route('staffs.store') }}" class="form-horizontal" method="POST">
                @csrf

                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="col-12 col-lg-3 col-from-label">{{ translate('Role') }} <span class="text-danger">*</span></label>
                        <div class="col-12 col-lg-9">
                            <select id="role" name="role_id" class="form-control aiz-selectpicker" data-live-search="true">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->getTranslation('name')}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="emp" class="form-group row">
                        <label for="employee_id" class="col-12 col-lg-3 col-from-label">{{ translate('Employee ID') }}<span class="text-danger">*</span></label>
                        <div class="col-12 col-lg-9">
                            <input type="text" name="employee_id" class="form-control {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" placeholder="{{ translate('Employee ID') }}">
                            @if ($errors->has('employee_id'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('employee_id') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_name" class="col-12 col-lg-3 col-from-label">{{ translate('First Name') }}<span class="text-danger">*</span></label>
                        <div class="col-12 col-lg-9">
                            <input type="text" name="first_name" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" placeholder="{{ translate('First Name') }}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('first_name') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-lg-3 col-from-label">{{ translate('Last Name') }}<span class="text-danger">*</span></label>
                        <div class="col-12 col-lg-9">
                            <input type="text" name="last_name" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" placeholder="{{ translate('Last Name') }}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('last_name') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-lg-3 col-from-label">{{ translate('Email') }} <span class="text-danger">*</span></label>
                        <div class="col-12 col-lg-9 col-from-label">
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="{{ translate('Email') }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-lg-3 col-from-label">{{ translate('Phone') }}<span class="text-danger">*</span></label>
                        <div class="col-12 col-lg-9">
                            <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                            <input type="hidden" id="phone" class="form-control" value="" placeholder="" name="phone">
                            <input type="hidden" name="country_code" value="63">

                            @if ($errors->has('phone'))
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-lg-3 col-from-label">{{ translate('Password') }} <span class="text-danger">*</span> </label>
                        <div class="col-12 col-lg-9">
                            <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ translate('Password') }}">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div id="permission" class="form-group row">
                        <label for="" class="col-12 col-lg-3 col-from-label">{{ translate('Permission') }} <span class="text-danger">*</span></label>
                        <div class="col-12 col-lg-9">
                            <select id="permission" name="permissions[]" class="form-control aiz-selectpicker" multiple>
                                <option value="manage_order_payment_status">Manage Order Payment Status</option>
                                <option value="manage_order_delivery_status">Manage Order Delivery Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var isPhoneShown    = true,
            countryData     = window.intlTelInputGlobals.getCountryData(),
            input           = document.querySelector("#phone-code");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if (country.iso2 == 'bd') {
                country.dialCode = '88';
            } 
        }

        var iti = intlTelInput(input, {
            preferredCountries: ['ph'],
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php echo json_encode(\App\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if(selectedCountryData.iso2 == 'bd'){
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        $('#phone-code').on('change', function(){
            $('#phone').val($('#phone-code').val().replace(/ /g,''));
        });
      
        input.addEventListener("countrychange", function(e) {
            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);
        });

        $('#phone-code').on('keyup', function(){
            if($('input[name=country_code]').val() == "63") {
                let trimmedNum = $(this).val().replace(/\s+/g, '');

                if (trimmedNum.length > 10) {
                    trimmedNum = trimmedNum.substr(0, 10);
                }

                const partitions = [3,3,4];
                const numbers = [];

                let position = 0;
                partitions.forEach(partition => {
                    const part = trimmedNum.substr(position, partition);
                    if (part) numbers.push(part);
                    position += partition;
                })
                $(this).val(numbers.join(' '));
            }
        });

        $(document).ready(function() {
            $('#emp').hide();
            $('#notemp').show();
        });

        $('#role').on('change', function () {
            var is_employee = false;

            @foreach($roles as $role)
                if({{$role->id}} == $('#role').val()){
                    if('{{$role->name}}' == 'Employee'){
                        is_employee = true;
                    }
                }
            @endforeach

            if (is_employee) {
                $('#emp').show();
                $('#permission').hide();
            }

            else {
                $('#emp').hide();
                $('#permission').show();
            }
        });
    </script>
@endsection