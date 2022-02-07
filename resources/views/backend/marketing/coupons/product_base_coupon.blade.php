<div class="my-2">
    <h3 class="h6">{{translate('Add Your Product Base Coupon')}}</h3>
    <hr>
</div>
<div class="form-group row">
    <label class="col-lg-2 col-from-label d-flex align-items-center" for="coupon_code">{{translate('Coupon code')}}</label>
    <div class="col-lg-10">
        <input type="text" placeholder="{{translate('Coupon code')}}" id="coupon_code" name="coupon_code" class="form-control" required>
    </div>
</div>
<div class="product-choose-list">
    <div class="product-choose">
        <div class="form-group row">
            <label class="col-lg-2 col-from-label d-flex align-items-center" for="name">{{translate('Product')}}</label>
            <div class="col-lg-10">
                <select name="product_ids[]" class="form-control product_id aiz-selectpicker" data-live-search="true" data-selected-text-format="count" required multiple>
                    @foreach(filter_products(\App\Product::query())->get() as $product)
                        <option value="{{$product->id}}">{{ $product->getTranslation('name') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<br>
<div class="form-group row">
    <label class="col-sm-2 control-label d-flex align-items-center" for="start_date">{{translate('Date')}}</label>
    <div class="col-sm-10">
      <input type="text" class="form-control aiz-date-range" readonly name="date_range" placeholder="Select Date">
    </div>
</div>
<div class="form-group row">
   <label class="col-lg-2 col-from-label d-flex align-items-center">{{translate('Discount')}}</label>
   <div class="col-lg-5">
      <input type="number" lang="en" min="0" step="0.01" placeholder="{{translate('Discount')}}" name="discount" class="form-control" required>
   </div>
   <div class="col-lg-5">
       <select class="form-control aiz-selectpicker" name="discount_type">
           <option value="amount">{{translate('Amount')}}</option>
           <option value="percent">{{translate('Percent')}}</option>
       </select>
   </div>
</div>


<script type="text/javascript">

    $(document).ready(function(){
        $('.aiz-date-range').daterangepicker();
        AIZ.plugins.bootstrapSelect('refresh');
    });

</script>
