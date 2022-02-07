

@if (Auth::user() && Auth::user()->user_type != "customer")
    @if (Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
        <div class="">
            @if (count($products) > 0)
                <ul class="list-group list-group-raw">
                    @foreach ($products as $key => $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a class="text-reset text-subprimary" href="{{ route('walkin.product.details', ['slug' => $product->slug, 'order_id' => encrypt($orderId), 'location' => $location]) }}">
                                <div class="d-flex search-product align-items-center">
                                    <div class="mr-3">
                                        <img class="size-40px img-fit rounded" src="{{ uploaded_asset($product->thumbnail_img) }}">
                                    </div>
                                    <div class="flex-grow-1 overflow--hidden minw-0">
                                        <div class="product-name text-truncate mb-5px text-subprimary">
                                            {{  $product->getTranslation('name')  }}
                                        </div>
                                        <div class="">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="opacity-60 fs-15">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="fw-600 fs-16 text-primary text-subprimary">{{ home_discounted_base_price($product->id) }}</span>
                                        </div>
                                    </div>
                                </div>
                            <a class="add form-label" href="{{ route('walkin.product.details', ['slug' => $product->slug, 'order_id' => encrypt($orderId), 'location' => $location]) }}">{{translate('Add to order')}}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
@else
    <div class="">
        @if (sizeof($keywords) > 0)
            <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary text-subprimary">{{translate('Popular Suggestions')}}</div>
            <ul class="list-group list-group-raw">
                @foreach ($keywords as $key => $keyword)
                    <li class="list-group-item py-1">
                        <a class="text-reset hov-text-primary text-subprimary" href="{{ route('suggestion.search', $keyword) }}">{{ $keyword }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="">
        @if (count($categories) > 0)
            <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary text-subprimary">{{translate('Category Suggestions')}}</div>
            <ul class="list-group list-group-raw">
                @foreach ($categories as $key => $category)
                    <li class="list-group-item py-1">
                        <a class="text-reset hov-text-primary text-subprimary" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="">
        @if (count($products) > 0)
            <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary text-subprimary">{{translate('Products')}}</div>
            <ul class="list-group list-group-raw">
                @foreach ($products as $key => $product)
                    <li class="list-group-item">
                        <a class="text-reset text-subprimary" href="{{ route('product', $product->slug) }}">
                            <div class="d-flex search-product align-items-center">
                                <div class="mr-3">
                                    <img class="size-40px img-fit rounded" src="{{ uploaded_asset($product->thumbnail_img) }}">
                                </div>
                                <div class="flex-grow-1 overflow--hidden minw-0">
                                    <div class="product-name text-truncate mb-5px text-subprimary">
                                        {{  $product->getTranslation('name')  }}
                                    </div>
                                    <div class="">
                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                            <del class="opacity-60 fs-15">{{ home_base_price($product->id) }}</del>
                                        @endif
                                        <span class="fw-600 fs-16 text-primary text-subprimary">{{ home_discounted_base_price($product->id) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    @if(\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
        <div class="">
            @if (count($shops) > 0)
                <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary text-subprimary">{{translate('Shops')}}</div>
                <ul class="list-group list-group-raw">
                    @foreach ($shops as $key => $shop)
                        <li class="list-group-item">
                            <a class="text-reset text-subprimary" href="{{ route('shop.visit', $shop->slug) }}">
                                <div class="d-flex search-product align-items-center">
                                    <div class="mr-3">
                                        <img class="size-40px img-fit rounded" src="{{ uploaded_asset($shop->logo) }}">
                                    </div>
                                    <div class="flex-grow-1 overflow--hidden">
                                        <div class="product-name text-truncate mb-5px text-subprimary">
                                            {{ $shop->name }}
                                        </div>
                                        <div class="opacity-60 text-subprimary">
                                            {{ $shop->address }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
@endif
