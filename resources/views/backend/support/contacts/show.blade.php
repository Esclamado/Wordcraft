@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Contact Message') }}</h5>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label for="" class="col-lg-2 col-form-label">
                            <b>{{ translate('Full name') }}</b>
                        </label>
                        <div class="col-lg-8">
                            {{ $contact->full_name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-lg-2 col-form-label">
                            <b>{{ translate('Contact Number') }}</b>
                        </label>
                        <div class="col-lg-8">
                            {{ $contact->contact_number }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-lg-2 col-form-label">
                            <b>{{ translate('Email Address') }}</b>
                        </label>
                        <div class="col-lg-8">
                            {{ $contact->email_address }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-lg-2 col-form-label">
                            <b>{{ translate('IP Address') }}</b>
                        </label>
                        <div class="col-lg-8">
                            {{ $contact->ip_address }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-lg-2 col-form-label">
                            <b>{{ translate('Message') }}</b>
                        </label>
                        <div class="col-lg-8">
                            <p>
                                {{ $contact->message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
