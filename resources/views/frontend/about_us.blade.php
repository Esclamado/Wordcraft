@extends('frontend.layouts.app')

@section('content')

<div class="bg-light">
    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-xxl-7 col-xl-7 mx-auto text-lg-left">
                    <ul class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('home') }}">{{ translate('Home')}}</a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('home.section.about_us') }}">{{ translate('About WorldCraft') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
                <div class="row">
                    <div class="col-xxl-7 col-xl-7 mx-auto text-lg-left py-lg-4">
                        <h1 class="h4 text-subheader-title text-header-blue">WorldCraft is a subsidiary of Filipinas Multi-line Group of Companies which has been in the importation business for more than <span class="text-primary-red">35 years</span>.</h1>
                    </div>
                </div>
        </div>
    </section>
    <section class="bg-light">
        <div class="container">
            <div class="position-absolute">
                <div class="img-12"></div>
                <div class="img-13"></div>
                <div class="img-14"></div>
                <div class="img-15"></div>
                <div class="img-16"></div>
            </div>
            
            <div class="row">
                <div class="col-xxl-10 col-xl-10 mx-auto d-flex justify-content-center align-items-center">
                    <iframe width="920" height="406" src="https://www.youtube-nocookie.com/embed/n8GInF6DP7o" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>

            <div class="row">
                    <div class="col-xxl-8 col-xl-8 mx-auto text-lg-left">
                        <p class="oreder-item-header fw-400 mt-5">WorldCraft started selling multi-purpose racks, multi-purpose desks and school desks and chairs in 2020. It grew as it answered to the immediate need to rise to the occasion to help its employees in the outbreak of the Pandemic, thus the creation of the <b>Employee Self-help Program</b> when employees needed to earn more in the safety of their houses.<br><br>WorldCraft grew its inventory and is now a go to shop for space-saving and time-saving furniture that will provide you the perfect fit for the available space that you have at home and office.</p>
                    </div>
            </div>

           <div class="desktop-content">
                <div class="grid-about-photos mt-5">
                    <div class="photo1"></div>
                    <div class="photo2"></div>
                    <div class="photo3"></div>
                    <div class="photo4"></div>
                </div>
           </div>

            <div class="container">
                <div class="row mobile-content mt-5">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="photo1"></div>
                            </div>
                            <div class="col-6">
                                <div class="photo2 ml-1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="photo3 my-3"></div>
                            </div>
                            <div class="col-6">
                                <div class="photo4 my-3 ml-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="apply-reseller-banner mt-5">
            <div class="container grid-reseller-banner pt-5">
                <div class="position-absolute">
                    <div class="img-50"></div>
                    <div class="img-51"></div>
                </div>
                <div class="reseller-title">
                    <p class="text-paragraph-thin fw-600 text-primary-red" style="letter-spacing: 0.215em;">BE OUR RESELLER</p>
                    <h2 class="text-header-title text-light">WorldCraft is accepting resellers who wish to sell face to face and online.</h2>
                </div>
                <div class="reseller-button">
                    <a href="{{ route('reseller.index', ['step' => 1]) }}" class="btn btn-craft-primary text-title-thin">Apply as a reseller
                        <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.01 10.0835H4V11.9168H16.01V14.6668L20 11.0002L16.01 7.3335V10.0835Z" fill="white"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
