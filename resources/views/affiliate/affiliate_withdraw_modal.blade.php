<form action="{{ route('withdraw_request.payment_store') }}" method="POST">
    @csrf
    <div class="modal-header">
    	<h5 class="modal-title h6">{{translate('Affiliate Withdraw Request')}}</h5>
    	<button type="button" class="close" data-dismiss="modal">
    	</button>
    </div>
    <div class="modal-body">
      <table class="table table-striped table-bordered" >
          <tbody>
              <tr>
                  <td>{{ translate('Destination') }}</td>
                  <td>{{ ucfirst(json_decode($affiliate_withdraw_request->details)->body->destination) }}</td>
              </tr>
              <tr>
                  <td>{{ translate('Account Number') }}</td>
                  <td>{{ json_decode($affiliate_withdraw_request->details)->body->acc_number }}</td>
              </tr>
              <tr>
                  <td>{{ translate('Account Holder Name') }}</td>
                  <td>{{ json_decode($affiliate_withdraw_request->details)->body->acc_holder_name }}</td>
              </tr>
          </tbody>
      </table>

      <input type="hidden" name="affiliate_user_id" value="{{ $affiliate_user->id }}">
      <input type="hidden" name="affiliate_withdraw_request_id" value="{{ $affiliate_withdraw_request->id }}">

      <div class="form-group row">
          <label class="col-sm-3 col-from-label" for="amount">{{translate('Amount')}}</label>
          <div class="col-sm-9">
              <input type="hidden" name="amount" value="{{$affiliate_withdraw_request->amount}}" class="form-control">
              <input type="number" value="{{$affiliate_withdraw_request->amount}}" class="form-control" disabled>
          </div>
      </div>

      <div class="form-group row">
          <label class="col-sm-3 col-from-label" for="payment_method">{{translate('Payment Method')}}</label>
          <div class="col-sm-9">
              <select name="payment_method" id="payment_method" class="form-control aiz-selectpicker" required>
                  <option value="">{{translate('Select Payment Method')}}</option>
                  <option value="Gcash">{{translate('Gcash')}}</option>
                  <option value="Bank">{{translate('Bank')}}</option>
              </select>
          </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-sm btn-primary" type="submit">{{ translate('Pay')}}</button>
      <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
    </div>
</form>
