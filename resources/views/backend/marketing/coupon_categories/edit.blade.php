@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-lg-5 mx-auto">
            <form action="{{ route('coupon-categories.update', $couponCategory->id) }}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ translate('Edit Coupon Category') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="" class="col-from-label">{{ translate('Name') }}</label>
                            <div>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $couponCategory->name }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->has('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-from-label">{{ translate('Description') }}</label>
                            <div>
                                <textarea name="description" id="" cols="30" rows="5" class="form-control">{{ $couponCategory->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div></div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
@endsection