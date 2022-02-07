@extends('frontend.layouts.app')

@section('content')
<section class="lightblue-bg py-5">
    <div class="container">
        <div class="position-absolute">
            <div class="img-27"></div>
        </div>
        <div class="d-flex align-items-start">
              @include('frontend.inc.user_side_nav')
              <div class="aiz-user-panel">
                <div class="page-title">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6 col-12">
                            <span class="heading heading-6 text-capitalize fw-600 mb-0 text-paragraph-title">
                                {{ translate('Wishlist') }}
                            </span>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="float-md-right">
                                <ul class="breadcrumb">
                                    <li><a href="{{ route('home') }}" class="text-breadcrumb text-secondary-color opacity-50">{{ translate('Home') }}</a>
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z" fill="#8D8A8A"/>
                                        </svg>
                                    </li>
                                    <li><a href="{{ route('dashboard') }}" class="text-breadcrumb text-secondary-color opacity-50">{{ translate('Dashboard') }}</a>
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z" fill="#8D8A8A"/>
                                        </svg>
                                    </li>
                                    <li class="active"><a href="{{ route('wishlists.index') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('Wishlist') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                    @if (count($wishlists) != null)
                        <div class="row gutters-7">
                            @foreach ($wishlists as $key => $wishlist)
                                @if ($wishlist->product != null) 
                                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-4 col-sm-6" id="wishlist_{{ $wishlist->id ?? "N/A" }}">
                                    <div class="card mb-2 shadow-sm border-style mb-4">
                                        <div class="card-body border-bottom">
                                            <a href="{{ route('product', $wishlist->product->slug ?? "N/A") }}" class="d-block mb-3">
                                                <img src="{{ uploaded_asset($wishlist->product->thumbnail_img ?? "N/A") }}" class="img-fit" style="max-height: 180px; min-height: 180px;">
                                            </a>

                                            <h5 class="fs-14 mb-0 lh-1-5 fw-600 text-truncate-2">
                                                <a href="{{ route('product', $wishlist->product->slug ?? "N/A") }}" class="text-reset fw-600 text-title-thin">{{ $wishlist->product->getTranslation('name') }}</a>
                                            </h5>
                                            @if($wishlist->product->rating != null)
                                                <div class="rating rating-sm mb-1">
                                                    {{ renderStarRating($wishlist->product->rating ?? "N/A") }}
                                                </div>
                                            @endif
                                            <div class=" fs-14">
                                                  @if(home_base_price($wishlist->product->id ?? "N/A") != home_discounted_base_price($wishlist->product->id ?? "N/A"))
                                                      <del class="opacity-60 mr-1 fw-600 text-title-thin">{{ home_base_price($wishlist->product->id ?? "N/A") }}</del>
                                                  @endif
                                                      <span class="fw-600 text-primary fw-600 text-title-thin text-primary-blue">{{ home_discounted_base_price($wishlist->product->id) }}</span>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('product', $wishlist->product->slug ?? "N/A") }}" class="btn btn-sm btn-block btn-craft-red text-paragraph-thin w-100">
                                                <svg class="mr-2" width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.223 8.9775C13.968 9.4425 13.473 9.75 12.9105 9.75H7.32305L6.49805 11.25H15.498V12.75H6.49805C5.35805 12.75 4.63805 11.5275 5.18555 10.5225L6.19805 8.6925L3.49805 3H1.99805V1.5H4.45055L5.15555 3H16.2555C16.8255 3 17.1855 3.615 16.908 4.11L14.223 8.9775ZM14.9805 4.5H5.86805L7.64555 8.25H12.9105L14.9805 4.5ZM6.49805 13.5C5.67305 13.5 5.00555 14.175 5.00555 15C5.00555 15.825 5.67305 16.5 6.49805 16.5C7.32305 16.5 7.99805 15.825 7.99805 15C7.99805 14.175 7.32305 13.5 6.49805 13.5ZM12.5055 15C12.5055 14.175 13.173 13.5 13.998 13.5C14.823 13.5 15.498 14.175 15.498 15C15.498 15.825 14.823 16.5 13.998 16.5C13.173 16.5 12.5055 15.825 12.5055 15Z" fill="#D73019"/>
                                                </svg>

                                                {{ translate('Add to cart')}}
                                            </a>
                                            <a href="#" class="link wishlist-remove link--style-3 ml-3" data-toggle="tooltip" data-placement="top" title="Remove from wishlist" onclick="removeFromWishlist({{ $wishlist->id }})">
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.97721 3.66663H12.6439L13.5605 4.58329H16.3105V6.41663H5.31055V4.58329H8.06055L8.97721 3.66663ZM6.22708 16.5C6.22708 17.5083 7.05208 18.3333 8.06041 18.3333H13.5604C14.5687 18.3333 15.3937 17.5083 15.3937 16.5V7.33331H6.22708V16.5ZM8.06055 9.16663H13.5605V16.5H8.06055V9.16663Z" fill="#C0BCBC"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                            <div class="text-center">
                                <svg width="63" height="65" viewBox="0 0 63 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 20H48V65H0V20Z" fill="#FFCFD1"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M30.1172 33.1809V28.4153H27.4365H18.2031V33.1809H19.3947H30.1172Z" fill="#D71921"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M30.1172 28.4153V33.1809H40.8398H42.0312V28.4153H32.7979H30.1172Z" fill="#D71921"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.3945 33.1808H30.1172V45.0949H19.3945V33.1808Z" fill="#D71921"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M30.1172 33.1808H40.8397V45.0949H30.1172V33.1808Z" fill="#D71921"/>
                                <path d="M59.9022 52.6602C59.9022 52.0022 59.3689 51.4688 58.7108 51.4688H55.1365V8.33981C55.1365 6.36899 53.5331 4.76561 51.5623 4.76561H47.9881V3.5742C47.9881 1.60339 46.3847 0 44.4139 0C42.4431 0 40.8397 1.60339 40.8397 3.5742V4.76561H33.6913V3.5742C33.6913 1.60339 32.0879 0 30.1172 0C28.1464 0 26.5429 1.60339 26.5429 3.5742V4.76561H19.3946V3.5742C19.3946 1.60339 17.7912 0 15.8204 0C13.8496 0 12.2461 1.60339 12.2461 3.5742V4.76561H8.67186C6.70104 4.76561 5.09766 6.36899 5.09766 8.33981V55.043C5.09766 58.3277 7.76997 61 11.0547 61H53.9452C57.2299 61 59.9022 58.3277 59.9022 55.043V52.6602ZM43.2225 3.5742C43.2225 2.91727 43.757 2.3828 44.4139 2.3828C45.0708 2.3828 45.6053 2.91727 45.6053 3.5742V8.33981C45.6053 8.99675 45.0708 9.53121 44.4139 9.53121C43.757 9.53121 43.2225 8.99675 43.2225 8.33981V3.5742ZM28.9257 3.5742C28.9257 2.91727 29.4601 2.3828 30.1171 2.3828C30.7739 2.3828 31.3084 2.91727 31.3084 3.5742V8.33981C31.3084 8.99675 30.7739 9.53121 30.117 9.53121C29.46 9.53121 28.9256 8.99675 28.9256 8.33981L28.9257 3.5742ZM14.6289 3.5742C14.6289 2.91727 15.1633 2.3828 15.8203 2.3828C16.4772 2.3828 17.0117 2.91727 17.0117 3.5742V8.33981C17.0117 8.99675 16.4772 9.53121 15.8203 9.53121C15.1633 9.53121 14.6289 8.99675 14.6289 8.33981V3.5742ZM53.9452 58.6172H15.8175C16.567 57.6209 17.0117 56.3828 17.0117 55.043V53.8516H50C50.658 53.8516 51.1914 53.3182 51.1914 52.6602C51.1914 52.0022 50.658 51.4688 50 51.4688H15.8203C15.5043 51.4688 15.2012 51.5944 14.9778 51.8177C14.7544 52.0411 14.6289 52.3442 14.6289 52.6602V55.043C14.6289 57.0138 13.0255 58.6172 11.0547 58.6172C9.08385 58.6172 7.48046 57.0138 7.48046 55.043V16.6799H10.4586C11.1166 16.6799 11.65 16.1465 11.65 15.4885C11.65 14.8304 11.1166 14.2971 10.4586 14.2971H7.48046V8.33981C7.48046 7.68287 8.01492 7.14841 8.67186 7.14841H12.2461V8.33981C12.2461 10.3106 13.8495 11.914 15.8203 11.914C17.7911 11.914 19.3945 10.3106 19.3945 8.33981V7.14841H26.5429V8.33981C26.5429 10.3106 28.1463 11.914 30.1171 11.914C32.0879 11.914 33.6913 10.3106 33.6913 8.33981V7.14841H40.8397V8.33981C40.8397 10.3106 42.4431 11.914 44.4139 11.914C46.3847 11.914 47.9881 10.3106 47.9881 8.33981V7.14841H51.5623C52.2193 7.14841 52.7537 7.68287 52.7537 8.33981V14.2969H10.4756C9.81756 14.2969 9.28417 14.8303 9.28417 15.4883C9.28417 16.1464 9.81756 16.6797 10.4756 16.6797H52.7537V51.4688H49.1794C48.5214 51.4688 47.988 52.0022 47.988 52.6602C47.988 53.3182 48.5214 53.8516 49.1794 53.8516H57.5194V55.043C57.5196 57.0138 55.9162 58.6172 53.9452 58.6172Z" fill="#1B1464"/>
                                <path d="M43.2227 33.1808V28.4152C43.2227 27.7571 42.6893 27.2238 42.0312 27.2238H36.3717C36.5635 26.7651 36.6699 26.2621 36.6699 25.7345C36.6699 23.5995 34.9329 21.8624 32.7979 21.8624C31.7581 21.8624 30.8134 22.2751 30.1172 22.9445C29.4209 22.2752 28.4763 21.8624 27.4365 21.8624C25.3015 21.8624 23.5645 23.5995 23.5645 25.7345C23.5645 26.2621 23.6708 26.7651 23.8627 27.2238H18.2031C17.5451 27.2238 17.0117 27.7571 17.0117 28.4152V33.1808C17.0117 33.8388 17.5451 34.3722 18.2031 34.3722H18.2032V45.0948C18.2032 45.7529 18.7366 46.2863 19.3947 46.2863H40.8398C41.4979 46.2863 42.0312 45.7529 42.0312 45.0948V34.3722C42.6893 34.3722 43.2227 33.8388 43.2227 33.1808ZM40.8398 31.9894H31.3086V29.6066H40.8398V31.9894ZM32.7979 24.2454C33.6191 24.2454 34.2871 24.9134 34.2871 25.7346C34.2871 26.5559 33.6191 27.2239 32.7979 27.2239H31.3086V25.7346C31.3086 24.9134 31.9767 24.2454 32.7979 24.2454ZM25.9473 25.7346C25.9473 24.9134 26.6153 24.2454 27.4365 24.2454C28.2578 24.2454 28.9258 24.9134 28.9258 25.7346V27.2239H27.4365C26.6154 27.2239 25.9473 26.5559 25.9473 25.7346ZM19.3945 29.6067H28.9258V31.9895H19.3945V29.6067ZM20.5861 34.3722H28.9259V43.9034H20.5861V34.3722ZM39.6484 43.9036H31.3086V34.3723H39.6484V43.9036Z" fill="#1B1464"/>
                                </svg>

                                <h3 class="cart-craft-text mb-0 mt-3">
                                    Your wishlist is empty.
                                </h3>
                            </div>
                        </div>
                    @endif

                    <div class="aiz-pagination">
                      	{{ $wishlists->links() ?? "N/A" }}
                	</div>
              </div>
        </div>
    </div>
</section>
@endsection

@section('modal')

<div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
        <div class="modal-content position-relative">
            <div class="c-preloader">
                <i class="fa fa-spin fa-spinner"></i>
            </div>
            <button type="button" class="close absolute-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div id="addToCart-modal-body">

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">

    var count = 0; // needed for safari

        window.onload = function () {
            $.get("{{ route('check_auth') }}", function (data, status) {
                if (data == 1) {
                    // Do nothing
                }

                else {
                    window.location = '{{ route('user.login') }}';
                }
            });
        }

        setTimeout(function(){count = 1;},200);

        function removeFromWishlist(id){
            $.post('{{ route('wishlists.remove') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
                $('#wishlist').html(data);
                $('#wishlist_'+id).hide();
                AIZ.plugins.notify('success', '{{ translate('Item has been removed from wishlist') }}');
                location.reload();
            })
        }
    </script>
@endsection
