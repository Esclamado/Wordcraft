@php
    $coupon_det = json_decode($coupon->details);
@endphp

<div class="card-header p-0 mb-2">
   <h3 class="h6">{{translate('Edit Your Cart Base Coupon')}}</h3>
</div>
<div class="form-group row">
   <label class="col-lg-3 col-from-label" for="coupon_code">{{translate('Coupon code')}}</label>
   <div class="col-lg-9">
       <input type="text" value="{{$coupon->code}}" id="coupon_code" name="coupon_code" class="form-control" required>
   </div>
</div>


<div class="form-group row">
  <label class="col-lg-3 col-from-label">{{translate('Minimum Shopping')}}</label>
  <div class="col-lg-9">
     <input type="number" lang="en" min="0" step="0.01" name="min_buy" class="form-control" value="{{ $coupon_det->min_buy }}" required>
  </div>
</div>
<div class="form-group row">
   <label class="col-lg-3 col-from-label">{{translate('Discount')}}</label>
   <div class="col-lg-6">
       <input type="number" lang="en" min="0" step="0.01" placeholder="{{translate('Discount')}}" name="discount" class="form-control" value="{{ $coupon->discount }}" required>
   </div>
   <div class="col-lg-3">
       <select class="form-control aiz-selectpicker" name="discount_type" id="couponDiscount">
           <option value="amount" @if ($coupon->discount_type == 'amount') selected  @endif >{{translate('Amount')}}</option>
           <option value="percent" @if ($coupon->discount_type == 'percent') selected  @endif>{{translate('Percent')}}</option>
       </select>
   </div>
</div>

<div class="form-group row" id="percent" style="display: none;">
  <label class="col-lg-3 col-from-label">{{translate('Maximum Discount Amount')}}</label>
  <div class="col-lg-9">
     <input type="number" lang="en" min="0" step="0.01" placeholder="{{translate('Maximum Discount Amount')}}" name="max_discount" class="form-control" value="{{ $coupon_det->max_discount }}" id="maxdiscount">
  </div>
</div>

@php
  $start_date = date('m/d/Y', $coupon->start_date);
  $end_date = date('m/d/Y', $coupon->end_date);
@endphp
<div class="form-group row">
    <label class="col-sm-3 control-label" for="start_date">{{translate('Date')}}</label>
    <div class="col-sm-9">
      <input type="text" class="form-control aiz-date-range" value="{{ $start_date .' - '. $end_date }}" readonly name="date_range" placeholder="Select Date">
    </div>
</div>


<script type="text/javascript">

  var couponDiscount = $('#couponDiscount').val();
     $(document).ready(function(){
         $('.aiz-selectpicker').selectpicker();
         $('.aiz-date-range').daterangepicker();
         $("#"+couponDiscount).show();
          
          $('#couponDiscount').on('change', function() {
              if(couponDiscount != ""){
                  $("#"+couponDiscount ?? '').hide();
                  $("#maxdiscount").prop("required", false);
              }
              if($(this).val()){
                  couponDiscount = $(this).val();
                  $("#"+$(this).val()).show();
                  $("#maxdiscount").prop("required", true);
              }
          });
     });
  </script>
