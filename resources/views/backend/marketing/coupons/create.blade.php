@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Coupon Information Adding')}}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('coupon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-2 col-from-label d-flex align-items-center" for="coupon_type">{{translate('Coupon Type')}}</label>
                        <div class="col-lg-10">
                            <select name="coupon_type" id="coupon_type" class="form-control aiz-selectpicker{{ $errors->has('coupon_type') ? ' is-invalid' : '' }}" onchange="coupon_form()">
                                <option value="" disabled selected>{{translate('Select One') }}</option>
                                <option value="product_base">{{translate('For Products')}}</option>
                                <option value="cart_base">{{translate('For Total Orders')}}</option>
                            </select>
                            @if ($errors->has('coupon_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('coupon_type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" id="forProduct" class="form-control" value="0" placeholder="" name="forProduct">
                    <input type="hidden" id="forCart" class="form-control" value="0" placeholder="" name="forCart">

                    <div id="coupon_form">

                    </div>
                
                    {{-- // Additional Coupon Information --}}
                    <hr>
                    
                    <div>
                        {{-- Category --}}
                        <div class="form-group row">
                            <label for="" class="col-lg-4 col-from-label d-flex align-items-center">{{ translate('Coupon Category') }}</label>
                            <div class="col-lg-8">
                                <select name="category_id" id="category_id" class="form-control aiz-selectpicker{{ $errors->has('category_id') ? ' is-invalid' : '' }}" data-live-search="true">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($coupon_categories as $key => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Description --}}
                        <div class="form-group row">
                            <label for="" class="col-lg-4 col-from-label d-flex align-items-center">{{ translate('Description') }}</label>
                            <div class="col-lg-8">
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="usage_limit" class="col-lg-4 col-from-label d-flex align-items-center">{{ translate('Maximum Coupon Usage') }}</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control{{ $errors->has('usage_limit') ? ' is-invalid' : '' }}" name="usage_limit">
                                @if ($errors->has('usage_limit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('usage_limit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="usage_limit_user" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Maximum Coupon Individual User Limit') }}</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control{{ $errors->has('usage_limit_user') ? ' is-invalid' : '' }}" name="usage_limit_user">
                                @if ($errors->has('usage_limit_user'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('usage_limit_user') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- // User Roles --}}
                        <div class="form-group row">
                            <label for="role_restricted" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Role Restricted') }}</label>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input value="1" type="checkbox" name="role_restricted" onchange="show_roles_input()">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row" id="roles_input" style="display: none;">
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('User Roles') }}</label>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker" data-live-search="false" data-selected-text-format="text" name="roles[]" id="roles" multiple>
                                    <option value="" disabled>Select User Role</option>
                                    <option value="customer">Customer</option>
                                    <option value="reseller">Reseller</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                        </div>
                        {{-- // End Roles Restricted --}}

                        {{-- // Individual Use --}}
                        <div class="form-group row">
                            <label for="individual_use" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Individual Use Only') }}</label>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input value="1" type="checkbox" name="individual_use" onchange="show_individual_users()">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row" id="individual_users" style="display: none;">
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('User List') }}</label>
                            <div class="col-lg-8">
                                <select name="individual_user_id" id="" class="form-control aiz-selectpicker" data-live-search="true" data-selected-text-format="text">
                                    <option value="" disabled selected>Select User</option>
                                    @foreach (\App\User::where('banned', '!=', 1)->get(['id', 'name']) as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- //  End Individual Use --}}
                    
                        {{-- // Bundle Coupon --}}
                        <div class="form-group row">
                            <label for="individual_use" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Coupon Bundle') }}</label>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input value="1" type="checkbox" name="bundle_coupon" onchange="show_products()">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row" id="bundle_coupon_type" style="display: none;">
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Coupon Bundle Type') }}</label>
                            <div class="col-lg-8">
                                <select name="bundle_coupon_type" id="bundle_coupon_type_container" class="form-control aiz-selectpicker" data-live-search="false" onchange="coupon_bundle_type_toggle(this)">
                                    <option value="" disabled selected>Select Bundle Coupon Type</option>
                                    <option value="product">Product Items</option>
                                    <option value="category">Category Items</option>
                                </select>
                            </div>
                        </div>

                        {{-- // Product List --}}
                        <div class="form-group row" id="bundle_products" style="display: none;">
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Product List') }}</label>
                            <div class="col-lg-8">
                                <select name="products[]" id="products" class="form-control aiz-selectpicker" data-live-search="true" data-selected-text-format="count" multiple>
                                    <option value="" disabled selected>Select Products</option>
                                    @foreach(\App\Product::orderBy('created_at', 'desc')->get() as $product)
                                        <option value="{{$product->id}}">{{ $product->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="bundle_product_table" style="display: none;">

                        </div>

                        {{-- End Product List --}}
                    
                        {{-- Category List --}}
                        <div class="form-group row" id="bundle_categories" style="display: none;">
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Category List') }}</label>
                            <div class="col-lg-8">
                                <select name="categories[]" id="categories" class="form-control aiz-selectpicker" data-live-search="true" data-selected-text-format="count" multiple>
                                    <option value="" disabled selected>Select Categories</option>
                                    @foreach (\App\Category::where('level', 0)->orderBy('created_at', 'desc')->get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="bundle_category_table" style="display: none;">

                        </div>
                        {{-- End Category List --}}
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')

<script type="text/javascript">
    function coupon_form(){
        var coupon_type = $('#coupon_type').val();
		$.post('{{ route('coupon.get_coupon_form') }}',{_token:'{{ csrf_token() }}', coupon_type:coupon_type}, function(data){
            $('#coupon_form').html(data);
		});
    }

    function show_roles_input () {
        $('#roles_input').toggle()
    }

    function show_individual_users () {
        $('#individual_users').toggle()
    }

    function show_products () {
        $('#bundle_coupon_type').toggle()
    }

    function coupon_bundle_type_toggle (type) {
        if (type.value == 'product') {
            // Products
            $('#bundle_products').toggle()
            $('#bundle_product_table').toggle()

            // Categories
            $('#bundle_categories').hide()
            $('#bundle_category_table').hide()
        }

        else if (type.value == 'category') {
            $('#bundle_categories').toggle()
            $('#bundle_category_table').toggle()

            $('#bundle_products').hide()
            $('#bundle_product_table').hide()
        }

        else {
            $('#bundle_categories').hide()
            $('#bundle_category_table').hide()
            
            $('#bundle_products').hide()
            $('#bundle_product_table').hide()
        }
    }

    $(document).ready(function () {
        $('#products').on('change', function () {
            var product_ids = $('#products').val();
            if (product_ids.length > 0) {
                $.post('{{ route('coupon.bundle_product') }}', { _token: '{{ csrf_token() }}', product_ids: product_ids }, function (data) {
                    $('#bundle_product_table').html(data);
                    $('.aiz-selectpicker').selectpicker();
                });
            }

            else {
                $('#bundle_product_table').html(null);
            }
        })

        $('#categories').on('change', function () {
            var category_ids = $('#categories').val();
            if (category_ids.length > 0) {
                $.post('{{ route('coupon.bundle_category') }}', { _token: '{{ csrf_token() }}', category_ids: category_ids }, function (data) {
                    $('#bundle_category_table').html(data);
                    $('.aiz-selectpicker').selectpicker();
                });
            }

            else {
                $('#bundle_category_table').html(null);
            }
        });
    })
</script>

@endsection
