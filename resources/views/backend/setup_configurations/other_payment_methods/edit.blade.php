@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Other Payment Method Information') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('other-payment-methods.update', $other_payment_method->id) }}" method="POST">
                    {{ method_field('PUT') }}
                    @csrf

                    <div class="form-group row">
                        <label for="unique_id" class="col-sm-3 control-label">Unique ID Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="unique_id" class="form-control{{ $errors->has('unique_id') ? ' is-invalid' : '' }}" placeholder="e.g: bank-sample" value="{{ $other_payment_method->unique_id }}">
                            @if ($errors->has('unique_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('unique_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Name" value="{{ $other_payment_method->name }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="title" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Title" value="{{ $other_payment_method->title }}">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="8" cols="10">{{ $other_payment_method->description }}</textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="type" class="col-sm-3 control-label">Type</label>
                        <div class="col-sm-9">
                            <select name="type" id="type" class="form-control aiz-selectpicker{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                <option value="" selected disabled>{{translate('Select Type')}}</option>
                                <option value="single_payment_option" @if ($other_payment_method->type == 'single_payment_option') selected @endif >{{translate('Single Payment Option')}}</option>
                                <option value="multiple_payment_option" @if ($other_payment_method->type == 'multiple_payment_option') selected @endif>{{translate('Multiple Payment Option')}}</option>
                                <option value="e_wallet" @if ($other_payment_method->type == 'e_wallet') selected @endif>{{ translate('E-Wallet') }}</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <label for="" class="col-sm-3 control-label"></label>
                    </div>

                    <div class="row mb-3">
                        <label for="new_step" class="col-sm-3 control-label">Step(s) on how to pay <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="mb-3">
                                <label for="" class="control-label"><strong>Current Steps</strong></label>
                                <div>
                                    @foreach ($other_payment_method_steps as $key => $value)
                                        <ul class="list-unstyled">
                                            <li>
                                                <div class="d-inline-flex align-items-start">
                                                    <div class="mr-4">
                                                        {{ $key + 1 }}.
                                                    </div>
                                                    <div>
                                                        {{ $value->step }}
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-inline-flex">
                                <button type="button" id="add_input" name="button" class="btn btn-primary mr-3">
                                    Add new Step
                                </button>

                                <button type="button" id="remove_input" name="button" class="btn btn-primary">
                                    Remove Last Step
                                </button>
                            </div>

                            <input type="hidden" name="total_steps" value="1" id="total_steps">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="step" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9" id="new_step">
                            <input type="text" id="new_1" name="step_1" class="form-control mb-3" placeholder="Step No 1" value="">
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

@section('script')
    <script type="text/javascript">

        $('#add_input').on('click', add);
        $('#remove_input').on('click', remove);

        function add () {
            var new_step_no = parseInt($('#total_steps').val()) + 1;
            var new_input = "<input type='text' id='new_" + new_step_no + "'name='step_" + new_step_no + "'class='form-control mb-3' placeholder='Step No " + new_step_no + "' value='' required>"

            $('#count').val(new_step_no);
            $('#new_step').append(new_input);
            $('#total_steps').val(new_step_no);
        }

        function remove() {
            var last_step_no = $('#total_steps').val();
            if (last_step_no > 1) {
                $('#new_' + last_step_no).remove();
                $('#total_steps').val(last_step_no - 1);
            }
        }

    </script>
@endsection
