@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6">{{translate('Coupon Information Update')}}</h3>
            </div>
            <form action="{{ route('coupon.update', $coupon->id) }}" method="POST">
                <input name="_method" type="hidden" value="PATCH">
            	@csrf
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $coupon->id }}" id="id">
                    <div class="form-group row">
                        <label class="col-lg-2 col-from-label d-flex align-items-center" for="name">{{translate('Coupon Type')}}</label>
                        <div class="col-lg-10">
                            <select name="coupon_type" id="coupon_type" class="form-control aiz-selectpicker" onchange="coupon_form()" required>
                                @if ($coupon->type == "product_base"))
                                    <option value="product_base" selected>{{translate('For Products')}}</option>
                                @elseif ($coupon->type == "cart_base")
                                    <option value="cart_base">{{translate('For Total Orders')}}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div id="coupon_form">

                    </div>

                    {{-- // Additional Coupon Information --}}
                    <hr>

                    <div>
                        {{-- Category --}}
                        <div class="form-group row">
                            <label for="" class="col-lg-4 col-from-label d-flex align-items-center">{{ translate('Coupon Category') }}</label>
                            <div class="col-lg-8">
                                <select name="category_id" id="" class="form-control aiz-selectpicker" data-live-search="true">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($coupon_categories as $key => $item)
                                        <option value="{{ $item->id }}" {{ $coupon->category_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Description --}}
                        <div class="form-group row">
                            <label for="" class="col-lg-4 col-from-label d-flex align-items-center">{{ translate('Description') }}</label>
                            <div class="col-lg-8">
                                <textarea name="description" id="" cols="30" rows="5" class="form-control">{{ $coupon->description }}</textarea>
                            </div>
                        </div>

                        {{-- Max Usage --}}
                        <div class="form-group row">
                            <label for="" class="col-lg-4 col-from-label d-flex align-items-center">{{ translate('Maximum Coupon Usage') }}</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" name="usage_limit" value="{{ $coupon->usage_limit }}" required>
                            </div>
                        </div>

                        {{-- User Usage Limit --}}
                        <div class="form-group row">
                            <label for="" class="col-lg-4 col-from-label d-flex align-items-center">{{ translate('Maximum Coupon Individual User Limit') }}</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" name="usage_limit_user" value="{{ $coupon->usage_limit_user }}" required>
                            </div>
                        </div>

                        {{-- User Roles --}}
                        <div class="form-group row">
                            <label for="role_restricted" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Role Restricted') }}</label>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input value="1" type="checkbox" name="role_restricted" onchange="show_roles_input()" {{ $coupon->role_restricted == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row" id="roles_input" @if ($coupon->role_restricted == 0) style="display: none;" @endif>
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center" >{{ translate('User Roles') }}</label>
                            <div class="col-lg-8">
                                @php
                                    $roles = json_decode($coupon->roles);
                                @endphp

                                <select class="form-control aiz-selectpicker" data-live-search="false" data-selected-text-format="text" name="roles[]" id="roles" multiple>
                                    <option value="" disabled selected>Select User Role</option>
                                    <option value="customer" @if ($coupon->roles != null && in_array('customer', $roles) == 'customer') selected  @endif>Customer</option>
                                    <option value="reseller" @if ($coupon->roles != null && in_array('reseller', $roles) == 'reseller') selected  @endif>Reseller</option>
                                    <option value="employee" @if ($coupon->roles != null && in_array('employee', $roles) == 'employee') selected  @endif>Employee</option>
                                </select>
                            </div>
                        </div>

                        {{-- // Individual Use --}}
                        <div class="form-group row">
                            <label for="individual_use" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Individual Use Only') }}</label>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input value="1" type="checkbox" name="individual_use" onchange="show_individual_users()" {{ $coupon->individual_use == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row" id="individual_users" @if ($coupon->individual_use == 0) style="display: none;" @endif>
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('User List') }}</label>
                            <div class="col-lg-8">
                                <select name="individual_user_id" id="" class="form-control aiz-selectpicker" data-live-search="true" data-selected-text-format="text">
                                    <option value="" disabled selected>Select User</option>
                                    @foreach (\App\User::where('banned', '!=', 1)->get(['id', 'name']) as $item)
                                        <option value="{{ $item->id }}" {{ $coupon->individual_user_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="individual_use" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Coupon Bundle') }}</label>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input value="1" type="checkbox" name="bundle_coupon" onchange="show_products()" {{ $coupon->bundle_coupon == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row" id="bundle_coupon_type"  @if ($coupon->bundle_coupon == 0) style="display: none;" @endif>
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Coupon Bundle Type') }}</label>
                            <div class="col-lg-8">
                                <select name="bundle_coupon_type" id="bundle_coupon_type_container" class="form-control aiz-selectpicker" data-live-search="false" onchange="coupon_bundle_type_toggle(this)">
                                    <option value="" disabled selected>Select Bundle Coupon Type</option>
                                    <option value="product" @if ($coupon->bundle_coupon_type == 'product') selected @endif>Product Items</option>
                                    <option value="category" @if ($coupon->bundle_coupon_type == 'category') selected @endif>Category Items</option>
                                </select>
                            </div>
                        </div>

                        {{-- Products Bundle --}}
                        <div class="form-group row" id="bundle_products" @if ($coupon->bundle_coupon_type != 'product') style="display: none;" @endif>
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Product List') }}</label>
                            <div class="col-lg-8">
                                <select name="products[]" id="products" class="form-control aiz-selectpicker" data-live-search="true" data-selected-text-format="count" multiple>
                                    <option value="" disabled>Select Products</option>
                                    @foreach(\App\Product::orderBy('created_at', 'desc')->get() as $product)
                                        @php
                                            $coupon_bundle_products = \App\CouponBundle::where('coupon_id', $coupon->id)->where('product_id', $product->id)->first();
                                        @endphp
                                    
                                        <option value="{{$product->id}}" @if ($coupon_bundle_products != null) selected @endif>{{ $product->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="bundle_product_table" @if ($coupon->bundle_coupon_type != 'product') style="display: none;" @endif>

                        </div>
                        {{-- End Products Bundle --}}
                    
                        {{-- Categories Bundle --}}
                        <div class="form-group row" id="bundle_categories" @if ($coupon->bundle_coupon_type != 'category') style="display: none;" @endif>
                            <label for="" class="col-lg-4 control-from-label d-flex align-items-center">{{ translate('Category List') }}</label>
                            <div class="col-lg-8">
                                <select name="categories[]" id="categories" class="form-control aiz-selectpicker" data-live-search="true" data-selected-text-format="count" multiple>
                                    <option value="" disabled>Select Categories</option>
                                    @foreach (\App\Category::where('level', 0)->orderBy('created_at', 'desc')->get() as $category)
                                        @php
                                            $coupon_bundle_categories = \App\CouponCategoryBundle::where('coupon_id', $coupon->id)->where('category_id', $category->id)->first();    
                                        @endphp

                                        <option value="{{ $category->id }}" @if ($coupon_bundle_categories != null) selected @endif>{{ $category->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="bundle_category_table" @if ($coupon->bundle_coupon_type != 'category') style="display: none;" @endif>

                        </div>
                        {{-- End Categories --}}
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            coupon_form();

            get_coupon_bundle();
            get_coupon_categories_bundle();

            $('#products').on('change', function () {
                get_coupon_bundle();
            });
            
            $('#categories').on('change', function () {
                get_coupon_categories_bundle();
            });

            function get_coupon_bundle () {
                var product_ids = $('#products').val();
                if (product_ids.length > 0) {
                    $.post('{{ route('coupon.bundle_product_edit') }}', { _token: '{{ csrf_token() }}', product_ids: product_ids, coupon_id: {{ $coupon->id }} }, function (data) {
                        $('#bundle_product_table').html(data);
                        $('.aiz-selectpicker').selectpicker();
                    });
                }

                else {
                    $('#bundle_product_table').html(null);
                }
            }

            function get_coupon_categories_bundle () {
                var category_ids = $('#categories').val();
                if (category_ids.length > 0) {
                    $.post('{{ route('coupon.bundle_category_edit') }}', { _token: '{{ csrf_token() }}', category_ids: category_ids, coupon_id: {{ $coupon->id }} }, function (data) {
                        $('#bundle_category_table').html(data);
                        $('.aiz-selectpicker').selectpicker();
                    });
                }

                else {
                    $('3bundle_category_table').html(null);
                }
            }

            function coupon_form(){
                var coupon_type = $('#coupon_type').val();
                var id = $('#id').val();
                $.post('{{ route('coupon.get_coupon_form_edit') }}',{_token:'{{ csrf_token() }}', coupon_type:coupon_type, id:id}, function(data){
                    $('#coupon_form').html(data);
                });
            }
        });  

        function show_roles_input () {
            $('#roles_input').toggle();
        }

        function show_individual_users () {
            $('#individual_users').toggle();
        }

        function show_products () {
            $('#bundle_coupon_type').toggle()
        }

        function coupon_bundle_type_toggle (type) {
            if (type.value == 'product') {
                $('#bundle_products').toggle();
                $('#bundle_product_table').toggle();

                $('#bundle_categories').hide();
                $('#bundle_category_table').hide();
            }

            else if (type.value == 'category') {
                $('#bundle_categories').toggle();
                $('#bundle_category_table').toggle();

                $('#bundle_products').hide();
                $('#bundle_product_table').hide();
            }

            else {
                $('#bundle_categories').hide();
                $('#bundle_category_table').hide();
                $('#bundle_products').hide();
                $('#bundle_product_table').hide();
            }
        }
    </script>
@endsection
