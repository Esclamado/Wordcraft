@extends('frontend.layouts.app')

@section('content')
@php
    $terms =  \App\Page::where('type', 'terms_conditions_page')->first();
@endphp
<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="row">
                     <div class="col-lg-6">
                         <ul class="breadcrumb bg-transparent p-0">
                             <li class="breadcrumb-item opacity-50">
                                 <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('home') }}">{{ translate('Home')}}</a>
                             </li>
                             <li class="text-dark fw-600 breadcrumb-item">
                                 <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('terms') }}">{{ translate('Terms and Conditions') }}</a>
                             </li>
                         </ul>
                     </div>
                </div>
 
                <div class="text-left">
                     <h1 class="h4 text-header-title text-header-blue">{{ $terms->getTranslation('title') }}</h1>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <section class="mb-4">
     <div class="container">
         <div class="row">
             <div class="col-lg-8 mx-auto">
                 <div class="p-4 bg-white rounded shadow-sm overflow-hidden mw-100 text-left other-pages-content">
                     @php
                         echo $terms->getTranslation('content');
                     @endphp
                 </div>
             </div>
         </div>
     </div>
 </section>
@endsection
