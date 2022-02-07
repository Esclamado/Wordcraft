@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Other Payment Method Bank Information') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('bank_lists.store') }}" method="post">
                    @csrf

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Parent ID</label>
                        <div class="col-sm-9">
                            <select name="parent_id" id="" class="form-control aiz-selectpicker">
                                <option value="">Select Other Payment Method</option>
                                @foreach ($other_payment_methods as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="pup_location">
                        <label for="parent_id" class="col-sm-3 control-label">Pickup Point Location</label>
                        <div class="col-sm-9">
                            <select name="pup_location_id" id="" class="form-control aiz-selectpicker" data-live-search="true">
                                <option value="">Select Pickup Point Location</option>
                                @foreach (\App\PickupPoint::where('pick_up_status', 1)->get()->pluck('id', 'name') as $location => $key)
                                    <option value="{{ $key }}">{{ $location }}</option>
                                @endforeach
                            </select>
                            <span class="text-muted text-sm">Pickup Point Location will only apply to GCash</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Bank Image</label>
                        <div class="col-sm-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="bank_image" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Bank Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Bank Account Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_acc_name" class="form-control" placeholder="Bank Account Name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 control-label">Bank Account Number</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_acc_number" class="form-control" placeholder="Bank Account Number" required>
                        </div>
                    </div>

                    <br>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
