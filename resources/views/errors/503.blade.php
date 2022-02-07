@extends('frontend.layouts.503app')

@section('content')
<section class="text-center py-6">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mx-auto">
				<img src="{{ static_asset('assets/img/worldcraft_logo.png') }}" style="height: 90px;">
				<h1 class="h2 fw-700 mt-5 text-header-title text-header-blue fw-700">{{ translate("Coming soon...") }}</h1>
				<div class="my-3 text-paragraph-thin px-5 mb-4 mt-3">
					<p class="text-title-thin">Our website is under construction, we are working very hard to give you the best experience with this one. Give us your email and we’ll notify you once we’re up!</p>
				</div>
				<div class="d-inline-block d-md-block">
					<form class="form-inline d-flex justify-content-center align-items-center" method="POST" action="{{ route('subscribers.store') }}">
						@csrf
						<div class="form-group mb-0">
							<input type="email" class="form-craft form-control" placeholder="{{ translate('Enter your Email Address') }}" name="email" required style="width: 329px;">
						</div>
						<button type="submit" class="btn btn-primary btn-craft-primary-nopadding" style="z-index: 999;">
							{{ translate('Subscribe') }}
						</button>
					</form>
				</div>
			</div>
		</div>	
	</div>
</section>
<div class="copyright-container text-center" style="margin-top: 10rem!important;margin-bottom: 5rem!important;">
	<span class="opacity-60 text-center">Copyright © 2021 WorldCraft</span>
</div>

<div class="position-absolute">
	<div class="img-9"></div>
	<div class="img-10"></div>
	<div class="img-5"></div>
	<div class="img-6"></div>
	<div class="img-7"></div>
	<div class="img-8"></div>
</div>
@endsection

@section('script')
    <script type="text/javascript">

$(document).ready(function() {
	$('.top-navbar').addClass('d-none');
	$('.logo-bar-area').addClass('d-none');
	$('.footer').addClass('d-none');
	$('.footer-bottom-background').addClass('d-none');
	

});
</script>
@endsection
