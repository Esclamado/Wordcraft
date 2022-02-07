<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-success mb-4">
        <div class="check-addtocart">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M46 23.9996C46 36.1009 36.172 45.9552 24.0809 46H24.0004C11.8723 46 2 36.1284 2 23.9996C2 11.8716 11.8722 2 24.0004 2H24.0812C36.1722 2.04499 46 11.8993 46 23.9996Z" stroke="#10865C" stroke-width="4"/>
                <path d="M32.2434 20.6176L24.1368 28.7253L22.3851 30.477C21.9713 30.8909 21.4285 31.0975 20.8863 31.0975C20.3435 31.0975 19.8013 30.8909 19.387 30.477L15.6207 26.7091C14.7931 25.8815 14.7931 24.5409 15.6207 23.7127C16.4473 22.8851 17.7895 22.8851 18.6172 23.7127L20.8863 25.9818L29.2469 17.6211C30.0746 16.793 31.4169 16.793 32.2434 17.6211C33.071 18.4488 33.071 19.7911 32.2434 20.6176Z" fill="#10865C"/>
            </svg>
        </div>
        <h3 class="header-subtitle mt-3">{{ translate('Item added to your cart!')}}</h3>
    </div>
    <div class="media mb-4 borderTopBot">
        @php
            $product_image = null;

            if ($data['variant'] != "") {
                $product_image = \App\ProductStock::where('product_id', $product->id)
                    ->where('variant', $data['variant'])
                    ->first()->image;

                if ($product_image != null) {
                    $product_image = uploaded_asset($product_image);
                }

                else {
                    $product_image = uploaded_asset($product->thumbnail_img);
                }
            }

            else {
                $product_image = uploaded_asset($product->thumbnail_img);
            }
        @endphp
        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ $product_image }}" class="mr-4 ml-4 lazyload size-100px img-fit rounded" alt="Product Image">
        <div class="media-body pt-3 text-left">
            <h6 class="text-title-thin">
                {{  $product->getTranslation('name')  }}
            </h6>
            <div class="h6 text-primary text-price-cart-modal">
                <strong>
                    {{ single_price(($data['price']+$data['tax'])*$data['quantity']) }}
                </strong>
            </div>
        </div>
    </div>
    <div class="text-center mb-3">
        <button class="btn btn-outline-primary mb-3 mb-sm-0 btn-border-craft-blue fw-600" data-dismiss="modal">{{ translate('Back to shopping')}}</button>
        <a href="{{ route('cart') }}" class="btn btn-primary mb-3 mb-sm-0 btn-craft-primary-nopadding ml-md-2 ml-lg-2 fw-600">{{ translate('View Cart')}}</a>
    </div>
</div>
