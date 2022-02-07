@extends('frontend.layouts.app')

@section('content')
<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="fw-600 h4">{{ translate('All Categories') }}</h1>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('categories.all') }}">{{ translate('All Categories') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="mb-4">
    <div class="container">
        <div class="mb-3 bg-white shadow-sm rounded">
            <div class="px-5 py-3 text-subprimary">
                <a href="{{ route('search') }}" class="text-reset">All Product</a>
            </div>
            <div class="border-bottom">
                <div class="row">
                </div>
            </div>
            <ul class="list-unstyled categories no-scrollbar text-left">
                @foreach (\App\Category::where('level', 0)->get()->take(11) as $key => $category)
                    <div class="px-5 py-3 text-subprimary">
                        <li class="category-nav-element" data-id="{{ $category->id }}">
                            <a href="{{ route('products.category', $category->slug) }}" class="text-reset text-center">
                                <img
                                    class="cat-image lazyload mr-2 opacity-60"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($category->icon) }}"
                                    width="16"
                                    alt="{{ $category->getTranslation('name') }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                >
                                <span class="pl-4 py-3 text-center text-subprimary">{{ $category->getTranslation('name') }}</span>
                            </a>
                            @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                                <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4">
                                    <div class="c-preloader text-center absolute-center">
                                        <i class="las la-spinner la-spin la-3x opacity-70"></i>
                                    </div>
                                </div>
                            @endif
                        </li>
                    </div>
                    <div class="border-bottom">
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
</section>

@endsection
