@extends('frontend.layouts.app')

@section('content')
<section class="text-center py-8">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mx-auto">
				<img src="{{ static_asset('images/404.png') }}" class="mw-100 mx-auto mb-5" height="130">
				<h1 class="fw-700 primary-title-bold">{{ translate('Page Not Found!') }}</h1>
				<p class="text-center fs-16 text-subprimary px-9 mb-5">{{ translate('Oops. Page not found! The page you are looking for is not available.') }}</p>
				<a href="{{route('home')}}" class="btn btn-craft-primary fw-500 text-subprimary">Go back to homepage</a>
			</div>
		<div>
    </div>
</section>
@endsection
