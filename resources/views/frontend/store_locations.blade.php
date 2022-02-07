@extends('frontend.layouts.app')

@section('content')

<div class="bg-light">
    <section class="py-4">
        <div class="container">
            <div class="mb-5">
                <h1 class="text-header-title text-header-blue text-center mt-5">Store Locations</h1>
            </div>
            @php
                $north_store_locations = \App\StoreLocation::where('status', 1)
                    ->where('island_name', 'north_luzon')->get(['island_name', 'name', 'address', 'phone_number', 'google_maps_url']);

                $south_store_locations = \App\StoreLocation::where('status', 1)
                    ->where('island_name', 'south_luzon')->get(['island_name', 'name', 'address', 'phone_number', 'google_maps_url']);

                $visayas_store_locations = \App\StoreLocation::where('status', 1)
                    ->where('island_name', 'visayas')->get(['island_name', 'name', 'address', 'phone_number', 'google_maps_url']);

                $mindanao_store_locations = \App\StoreLocation::where('status', 1)
                    ->where('island_name', 'mindanao')->get(['island_name', 'name', 'address', 'phone_number', 'google_maps_url']);
            @endphp
            <div class="row">
                <div class="col-12 col-lg-4">
                    <p class="opacity-60 text-breadcrumb fw-600">N O R T H  L U Z O N</p>
                    @foreach ($north_store_locations as $key => $north_store)
                        <div class="p-4 lightblue-bg rounded shadow-sm overflow-hidden mw-100 text-left store-card mb-3">
                            <a href="{{ $north_store->google_maps_url }}" target="_blank" class="float-right">
                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 0.5625V3.56212C13 4.06512 12.4141 4.31166 12.0753 3.95988L11.2694 3.12295L5.77324 8.83052C5.5617 9.0502 5.21876 9.0502 5.00721 8.83052L4.49653 8.3002C4.28499 8.08052 4.28499 7.72437 4.49653 7.50471L9.99276 1.79709L9.18696 0.960258C8.84682 0.607031 9.08772 0 9.56999 0H12.4583C12.7575 0 13 0.251836 13 0.5625ZM9.18642 6.34673L8.82531 6.72173C8.77501 6.77397 8.73511 6.83598 8.70789 6.90423C8.68067 6.97248 8.66666 7.04562 8.66667 7.11949V10.5H1.44444V3H7.40278C7.54643 2.99999 7.6842 2.94073 7.78578 2.83526L8.14689 2.46026C8.48812 2.10588 8.24645 1.5 7.76389 1.5H1.08333C0.485017 1.5 0 2.00367 0 2.625V10.875C0 11.4963 0.485017 12 1.08333 12H9.02778C9.62609 12 10.1111 11.4963 10.1111 10.875V6.74447C10.1111 6.24333 9.52765 5.99236 9.18642 6.34673Z" fill="#161DBC"/>
                                </svg>
                            </a>
                            <p class="fw-600 text-title-thin">{{ $north_store->name }}</p>
                            <div class="row">
                                <div class="col-md-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C15.31 2 18 4.69 18 8C18 12.5 12 19 12 19C12 19 6 12.5 6 8C6 4.69 8.69 2 12 2ZM19 22V20H5V22H19ZM8 8C8 5.79 9.79 4 12 4C14.21 4 16 5.79 16 8C16 10.13 13.92 13.46 12 15.91C10.08 13.47 8 10.13 8 8ZM10 8C10 6.9 10.9 6 12 6C13.1 6 14 6.9 14 8C14 9.1 13.11 10 12 10C10.9 10 10 9.1 10 8Z" fill="#62616A"/>
                                    </svg>
                                </div>
                                <div class="col-md-10">
                                    <a href="{{ $north_store->google_maps_url }}" target="_blank">
                                        {{ $north_store->address }}
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-1">
                                    <svg id="Layer_1" enable-background="new 0 0 512.021 512.021" height="16" viewBox="0 0 512.021 512.021" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.838-3.837 9.361-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.866 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="col-md-10">
                                    <a href="tel:{{ $north_store->phone_number }}" target="_blank">
                                        {{ $north_store->phone_number }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-12 col-lg-4">
                    <p class="opacity-60 text-breadcrumb fw-600">S O U T H  L U Z O N</p>
                    @foreach ($south_store_locations as $key => $south_store)
                        <div class="p-4 lightblue-bg rounded shadow-sm overflow-hidden mw-100 text-left store-card mb-3">
                            <a href="{{ $south_store->google_maps_url }}" target="_blank" class="float-right">
                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 0.5625V3.56212C13 4.06512 12.4141 4.31166 12.0753 3.95988L11.2694 3.12295L5.77324 8.83052C5.5617 9.0502 5.21876 9.0502 5.00721 8.83052L4.49653 8.3002C4.28499 8.08052 4.28499 7.72437 4.49653 7.50471L9.99276 1.79709L9.18696 0.960258C8.84682 0.607031 9.08772 0 9.56999 0H12.4583C12.7575 0 13 0.251836 13 0.5625ZM9.18642 6.34673L8.82531 6.72173C8.77501 6.77397 8.73511 6.83598 8.70789 6.90423C8.68067 6.97248 8.66666 7.04562 8.66667 7.11949V10.5H1.44444V3H7.40278C7.54643 2.99999 7.6842 2.94073 7.78578 2.83526L8.14689 2.46026C8.48812 2.10588 8.24645 1.5 7.76389 1.5H1.08333C0.485017 1.5 0 2.00367 0 2.625V10.875C0 11.4963 0.485017 12 1.08333 12H9.02778C9.62609 12 10.1111 11.4963 10.1111 10.875V6.74447C10.1111 6.24333 9.52765 5.99236 9.18642 6.34673Z" fill="#161DBC"/>
                                </svg>
                            </a>
                            <p class="fw-600 text-title-thin">{{ $south_store->name }}</p>
                            <div class="row">
                                <div class="col-md-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C15.31 2 18 4.69 18 8C18 12.5 12 19 12 19C12 19 6 12.5 6 8C6 4.69 8.69 2 12 2ZM19 22V20H5V22H19ZM8 8C8 5.79 9.79 4 12 4C14.21 4 16 5.79 16 8C16 10.13 13.92 13.46 12 15.91C10.08 13.47 8 10.13 8 8ZM10 8C10 6.9 10.9 6 12 6C13.1 6 14 6.9 14 8C14 9.1 13.11 10 12 10C10.9 10 10 9.1 10 8Z" fill="#62616A"/>
                                        </svg>
                                </div>
                                <div class="col-md-10">
                                    <a href="{{ $south_store->google_maps_url }}" target="_blank">
                                        {{ $south_store->address }}
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-1">
                                    <svg id="Layer_1" enable-background="new 0 0 512.021 512.021" height="16" viewBox="0 0 512.021 512.021" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.838-3.837 9.361-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.866 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="col-md-10">
                                    <a href="tel:{{ $south_store->phone_number }}" target="_blank">
                                        {{ $south_store->phone_number }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-12 col-lg-4">
                    <div>
                        <p class="opacity-60 text-breadcrumb fw-600">V I S A Y A S</p>
                        @foreach ($visayas_store_locations as $key => $visayas)
                            <div class="p-4 lightblue-bg rounded shadow-sm overflow-hidden mw-100 text-left store-card mb-3">
                                <a href="{{ $visayas->google_maps_url }}" target="_blank" class="float-right">
                                    <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 0.5625V3.56212C13 4.06512 12.4141 4.31166 12.0753 3.95988L11.2694 3.12295L5.77324 8.83052C5.5617 9.0502 5.21876 9.0502 5.00721 8.83052L4.49653 8.3002C4.28499 8.08052 4.28499 7.72437 4.49653 7.50471L9.99276 1.79709L9.18696 0.960258C8.84682 0.607031 9.08772 0 9.56999 0H12.4583C12.7575 0 13 0.251836 13 0.5625ZM9.18642 6.34673L8.82531 6.72173C8.77501 6.77397 8.73511 6.83598 8.70789 6.90423C8.68067 6.97248 8.66666 7.04562 8.66667 7.11949V10.5H1.44444V3H7.40278C7.54643 2.99999 7.6842 2.94073 7.78578 2.83526L8.14689 2.46026C8.48812 2.10588 8.24645 1.5 7.76389 1.5H1.08333C0.485017 1.5 0 2.00367 0 2.625V10.875C0 11.4963 0.485017 12 1.08333 12H9.02778C9.62609 12 10.1111 11.4963 10.1111 10.875V6.74447C10.1111 6.24333 9.52765 5.99236 9.18642 6.34673Z" fill="#161DBC"/>
                                    </svg>
                                </a>
                                <p class="fw-600 text-title-thin">{{ $visayas->name }}</p>
                                <div class="row">
                                    <div class="col-md-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C15.31 2 18 4.69 18 8C18 12.5 12 19 12 19C12 19 6 12.5 6 8C6 4.69 8.69 2 12 2ZM19 22V20H5V22H19ZM8 8C8 5.79 9.79 4 12 4C14.21 4 16 5.79 16 8C16 10.13 13.92 13.46 12 15.91C10.08 13.47 8 10.13 8 8ZM10 8C10 6.9 10.9 6 12 6C13.1 6 14 6.9 14 8C14 9.1 13.11 10 12 10C10.9 10 10 9.1 10 8Z" fill="#62616A"/>
                                            </svg>
                                    </div>
                                    <div class="col-md-10">
                                        <a href="{{ $visayas->google_maps_url }}" target="_blank">
                                            {{ $visayas->address }}
                                        </a>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-1">
                                        <svg id="Layer_1" enable-background="new 0 0 512.021 512.021" height="16" viewBox="0 0 512.021 512.021" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.838-3.837 9.361-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.866 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="col-md-10">
                                        <a href="tel:{{ $visayas->phone_number }}" target="_blank">
                                            {{ $visayas->phone_number }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <p class="opacity-60 text-breadcrumb fw-600">M I N D A N A O</p>
                        @foreach ($mindanao_store_locations as $key => $mindanao)
                            <div class="p-4 lightblue-bg rounded shadow-sm overflow-hidden mw-100 text-left store-card mb-3">
                                <a href="{{ $mindanao->google_maps_url }}" target="_blank" class="float-right">
                                    <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 0.5625V3.56212C13 4.06512 12.4141 4.31166 12.0753 3.95988L11.2694 3.12295L5.77324 8.83052C5.5617 9.0502 5.21876 9.0502 5.00721 8.83052L4.49653 8.3002C4.28499 8.08052 4.28499 7.72437 4.49653 7.50471L9.99276 1.79709L9.18696 0.960258C8.84682 0.607031 9.08772 0 9.56999 0H12.4583C12.7575 0 13 0.251836 13 0.5625ZM9.18642 6.34673L8.82531 6.72173C8.77501 6.77397 8.73511 6.83598 8.70789 6.90423C8.68067 6.97248 8.66666 7.04562 8.66667 7.11949V10.5H1.44444V3H7.40278C7.54643 2.99999 7.6842 2.94073 7.78578 2.83526L8.14689 2.46026C8.48812 2.10588 8.24645 1.5 7.76389 1.5H1.08333C0.485017 1.5 0 2.00367 0 2.625V10.875C0 11.4963 0.485017 12 1.08333 12H9.02778C9.62609 12 10.1111 11.4963 10.1111 10.875V6.74447C10.1111 6.24333 9.52765 5.99236 9.18642 6.34673Z" fill="#161DBC"/>
                                    </svg>
                                </a>
                                <p class="fw-600 text-title-thin">{{ $mindanao->name }}</p>
                                <div class="row">
                                    <div class="col-md-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C15.31 2 18 4.69 18 8C18 12.5 12 19 12 19C12 19 6 12.5 6 8C6 4.69 8.69 2 12 2ZM19 22V20H5V22H19ZM8 8C8 5.79 9.79 4 12 4C14.21 4 16 5.79 16 8C16 10.13 13.92 13.46 12 15.91C10.08 13.47 8 10.13 8 8ZM10 8C10 6.9 10.9 6 12 6C13.1 6 14 6.9 14 8C14 9.1 13.11 10 12 10C10.9 10 10 9.1 10 8Z" fill="#62616A"/>
                                            </svg>
                                    </div>
                                    <div class="col-md-10">
                                        <a href="{{ $mindanao->google_maps_url }}" target="_blank">
                                            {{ $mindanao->address }}
                                        </a>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-1">
                                        <svg id="Layer_1" enable-background="new 0 0 512.021 512.021" height="16" viewBox="0 0 512.021 512.021" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.838-3.837 9.361-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.866 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="col-md-10">
                                        <a href="tel:{{ $mindanao->phone_number }}" target="_blank">
                                            {{ $mindanao->phone_number }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
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
</div>

@endsection
