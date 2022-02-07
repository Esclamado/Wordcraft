@if (count($product_ids) > 0)
    <label for="" class="col-sm-4 control-from-label">{{ translate('Bundled Products') }}</label>
    <div class="col-sm-8">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td width="40%">{{ translate('Product') }}</td>
                    <td width="20%">{{ translate('Base Price') }}</td>
                    <td width="15%">{{ translate('Min Quantity') }}</td>
                    <td width="15%">{{ translate('Max Quantity') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($product_ids as $key => $id)
                    @php
                        $product = \App\Product::findOrFail($id);
                        $coupon_bundle_product = \App\CouponBundle::where('coupon_id', $coupon_id)->where('product_id', $product->id)->first();
                    @endphp

                    <tr>
                        <td>
                            <div class="form-group row d-flex align-items-center mb-0">
                                <div class="col-auto">
                                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->name }}" class="size-60px img-fit">
                                </div>
                                <div class="col">
                                    <span>{{ $product->getTranslation('name') }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span>{{ single_price($product->unit_price) }}</span>
                        </td>
                        <td>
                            <input type="number" name="quantity_min_{{ $id }}" min="0" step="1" value="{{ $coupon_bundle_product->product_quantity ?? '0' }}" class="form-control" id="" required>
                        </td>
                        <td>
                            <input type="number" name="quantity_max_{{ $id }}" min="0" step="1" value="{{ $coupon_bundle_product->product_quantity_max ?? '0' }}" class="form-control" id="" required>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif