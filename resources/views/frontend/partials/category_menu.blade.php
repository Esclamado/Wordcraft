@php
    $walkin = strpos(Route::currentRouteName(), "walkin");
@endphp
<div class="aiz-category-menu bg-white rounded @if(Route::currentRouteName() == 'home') shadow-sm" @else shadow-lg" id="category-sidebar" @endif>
    <div class="py-3 bg-soft-primary d-none d-lg-block rounded-top all-category position-relative text-left border-bottom mx-3 mb-2">
        <span class="fw-600 fs-16 mr-3 promotion-header text-header-blue">{{ translate('Categories') }}</span>
    </div>
   
    <ul class="list-unstyled categories mb-0 text-left">
        <li class="category-nav-element">
            <a @if($walkin !== false) href="{{ route('walkin.product') }}" @else href="{{ route('search') }}" @endif  class="text-truncate text-reset py-1 px-3 d-block text-title-thin">All Product</a>
        </li>
    </ul>

    <ul class="list-unstyled categories no-scrollbar py-2 mb-0 text-left">
        @foreach (\App\Category::where('level', 0)->get()->take(11) as $key => $category)
            <li class="category-nav-element" data-id="{{ $category->id }}">
                <a @if($walkin !== false) href="{{ route('walkin.products.category', $category->slug) }}" @else href="{{ route('products.category', $category->slug) }}" @endif class="text-truncate text-reset py-2 px-3 d-block text-title-thin">
                    <img
                        class="cat-image lazyload mr-2 opacity-60"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($category->icon) }}"
                        width="16"
                        alt="{{ $category->getTranslation('name') }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                    >
                    <span class="cat-name">{{ $category->getTranslation('name') }}</span>
                </a>
                @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                    <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg">
                        <div class="c-preloader text-center absolute-center">
                            <i class="las la-spinner la-spin la-3x opacity-70"></i>
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
