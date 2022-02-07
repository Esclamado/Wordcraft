@extends('frontend.layouts.app')

@section('content')

<div class="lightblue-bg">
    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('home') }}">{{ translate('Home')}}</a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('home.section.contact_us') }}">{{ translate('Contact Us') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12 col-md text-left">
                <h1 class="h4 text-header-title text-header-blue pt-5">Contact Us</h1>
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="container">
            <div class="position-absolute">
                <div class="img-11"></div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md text-left">
                    <div class="card">
                        <div class="card-body bg-white rounded shadow-sm overflow-hidden">
                            <div class="row">
                                <div class="col-lg-9 col-md">
                                    <p class="text-paragraph-thin">Interested in working with us? We’d love to hear from you. Share your thoughts using the form below.</p>
                                </div>
                            </div>
                                <form id="contact-form" action="{{ route('contact_us.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col col-form-label opacity-60 text-paragraph-thin">{{ translate('Full Name') }}</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-craft form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" name="full_name">
                                            @if ($errors->has('full_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('full_name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="col-form-label opacity-60 text-paragraph-thin">{{ translate('Contact Number') }}</label>
                                            <input type="number" class="form-craft form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" name="contact_number">
                                            @if ($errors->has('contact_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('contact_number') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label opacity-60 text-paragraph-thin">{{ translate('Email Address') }}</label>
                                            <input type="email" class="form-craft form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mb-5">
                                        <label class="col col-form-label opacity-60 text-paragraph-thin">{{ translate('Message') }}</label>
                                        <div class="col-md-12">
                                            <textarea name="message" class="form-craft form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" rows="4" cols="50"></textarea>
                                            @if ($errors->has('message'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('message') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-right row">
                                        <div class="col-md-6">
                                            @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
                                                <div class="form-group">
                                                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary text-title-thin">{{translate('Submit Message')}}
                                                <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.01 10.0835H4V11.9168H16.01V14.6668L20 11.0002L16.01 7.3335V10.0835Z" fill="white"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 overflow-hidden mw-100">

                </div>

                <div class="col-lg-4 p-4  overflow-hidden mw-100">
                    <div class="row">
                        <div class="col-12 mb-5">
                            <p class="opacity-60 text-paragraph-thin">Address</p>
                            <p class="text-paragraph-title pr-5">Calderon Bldg., 827 EDSA South Triangle, Quezon City</p>
                        </div>
                        <div class="col-12 mb-5">
                            <p class="opacity-60 text-paragraph-thin">Email</p>
                            <p class="text-paragraph-title pr-5"><a href="mailto:worldcraftph@gmail.com">worldcraftph@gmail.com</a></p>
                        </div>
                        <div class="col-12">
                            <p class="opacity-60 text-paragraph-thin">Contact</p>
                            <p class="text-paragraph-title pr-5"><a href="tel:+63234101155">+63 2 3410 1155</a><br><a href="tel:+63289299911">+63 2 8929 9911</a></p>
                        </div>

                        <div class="social-icons">
                            <div class="col">
                                <a href="#" class="mr-2">
                                    <svg width="47" height="47" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="23.5" cy="23.5" r="23.5" fill="#FFDEDF"/>
                                        <path d="M21.7869 32V24.4923H20V21.7892H21.7869V19.4804C21.7869 17.6661 22.8425 16 25.2747 16C26.2595 16 26.9877 16.1049 26.9877 16.1049L26.9303 18.6291C26.9303 18.6291 26.1876 18.6211 25.3772 18.6211C24.5002 18.6211 24.3596 19.0701 24.3596 19.8154V21.7892H27L26.8851 24.4923H24.3596V32H21.7869Z" fill="#D71921"/>
                                    </svg>
                                </a>

                                <a href="#" class="mr-2">
                                    <svg width="47" height="47" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="23.5" cy="23.5" r="23.5" fill="#FFDEDF"/>
                                        <g clip-path="url(#clip0)">
                                        <path d="M30.999 18.7768C30.5535 19.5417 30.0068 20.1937 29.3592 20.7328C29.3656 20.8774 29.3687 21.0409 29.3687 21.2231C29.3687 22.2359 29.2408 23.2498 28.9849 24.265C28.7291 25.2802 28.3382 26.2519 27.8124 27.1802C27.2866 28.1084 26.6603 28.9307 25.9334 29.6472C25.2065 30.3636 24.3328 30.9349 23.3122 31.3609C22.2916 31.787 21.1978 32 20.0308 32C18.2095 32 16.5322 31.4325 14.999 30.2976C15.2711 30.3326 15.5321 30.35 15.782 30.35C17.3036 30.35 18.6625 29.8092 19.859 28.7274C19.1495 28.7124 18.5142 28.4603 17.9529 27.9713C17.3916 27.4822 17.0054 26.8572 16.7942 26.0964C17.003 26.1423 17.209 26.1653 17.4124 26.1653C17.7051 26.1653 17.9931 26.1212 18.2764 26.0331C17.5193 25.8581 16.8913 25.4229 16.3922 24.7275C15.8932 24.0321 15.6436 23.2295 15.6436 22.3197V22.2728C16.1083 22.5697 16.604 22.7277 17.1307 22.7466C16.6822 22.4016 16.3266 21.9516 16.0639 21.3967C15.8012 20.8418 15.6699 20.2412 15.6699 19.5951C15.6699 18.9137 15.8178 18.2792 16.1137 17.6915C16.9371 18.8576 17.9347 19.7895 19.1067 20.4874C20.2786 21.1853 21.5359 21.5728 22.8785 21.6501C22.8213 21.3747 22.7926 21.0872 22.7925 20.7878C22.7925 19.7424 23.1131 18.8497 23.7542 18.1098C24.3953 17.3699 25.1688 17 26.0747 17C27.0231 17 27.8219 17.3986 28.4712 18.1957C29.2131 18.0261 29.9077 17.7193 30.5551 17.2754C30.3057 18.1813 29.8251 18.8802 29.1133 19.3719C29.7675 19.2822 30.3961 19.0838 30.999 18.7768H30.999Z" fill="#D71921"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0">
                                        <rect width="16" height="15" fill="white" transform="translate(15 17)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </a>

                                <a href="#">
                                    <svg width="47" height="47" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="23.5" cy="23.5" r="23.5" fill="#FFDEDF"/>
                                        <path d="M31.6239 19.0341C31.4169 18.2334 30.8069 17.6028 30.0325 17.3888C28.6288 17 23 17 23 17C23 17 17.3713 17 15.9675 17.3888C15.1931 17.6029 14.5831 18.2334 14.3761 19.0341C14 20.4853 14 23.5131 14 23.5131C14 23.5131 14 26.541 14.3761 27.9922C14.5831 28.7929 15.1931 29.3972 15.9675 29.6112C17.3713 30 23 30 23 30C23 30 28.6287 30 30.0325 29.6112C30.8069 29.3972 31.4169 28.7929 31.6239 27.9922C32 26.541 32 23.5131 32 23.5131C32 23.5131 32 20.4853 31.6239 19.0341V19.0341ZM21.1591 26.2622V20.7641L25.8636 23.5132L21.1591 26.2622V26.2622Z" fill="#D71921"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mt-5 google-maps">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.2986381285705!2d121.03882529826124!3d14.638981755122963!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b7a947209ed1%3A0x9849dc2f4f9a6db6!2s827%20Epifanio%20de%20los%20Santos%20Ave%2C%20Diliman%2C%20Quezon%20City%2C%201103%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1612928484284!5m2!1sen!2sph" width="100%" height="376" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
</div>
@endsection

@section('script')
    @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <script type="text/javascript">
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: { lat: -33, lng: 151 },
            });
            const image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
            const beachMarker = new google.maps.Marker({
                position: { lat: -33.89, lng: 151.274 },
                map,
                icon: image,
            });
        }

        @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
            // making the CAPTCHA  a required field for form submission
            $(document).ready(function(){
                // alert('helloman');
                $("#contact-form").on("submit", function(evt)
                {
                    var response = grecaptcha.getResponse();
                    if (response.length == 0)
                    {
                        AIZ.plugins.notify('danger', '{{ translate('Please verify you are human!') }}');
                        evt.preventDefault();
                        return false;
                    }
                    $("#contact-form").submit();
                });
            });
        @endif
    </script>
@endsection
