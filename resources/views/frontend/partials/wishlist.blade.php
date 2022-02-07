<div class="nav-icons">
    <a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-reset nav-icons-a">
        <i class="lar la-heart la-2x icon-style"></i>
        @if (Auth::check())
            @if(Auth::check())
                <span class="badge badge-primary badge-inline badge-pill ml--1">{{ count(Auth::user()->wishlists ?? "N/A")}}</span>
            @else
                <span class="badge badge-primary badge-inline badge-pill ml--1">0</span>
            @endif
        @endif

        <div>
            <span class="nav-box-text d-none d-xl-block opacity-70 d-lg-inline-block ml-2 order-details-title fw-500">
                {{translate('Wishlist')}}
            </span>
        </div>

        {{-- <span class="nav-box-text d-none d-lg-inline-block wishlist-title">{{translate('Wishlist')}}</span>
        @if(Auth::check())
            <span class="nav-box-number">{{ count(Auth::user()->wishlists ?? "N/A" )}}</span>
        @else
            <span class="nav-box-number">0</span>
        @endif --}}
    </a>
</div>