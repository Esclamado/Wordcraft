@extends('frontend.layouts.app')

@section('content')

<div class="d-flex" style="align-self: center;">
<div class="card-welcome">
    <div class="welcome-icon">
    <svg width="98" height="98" viewBox="0 0 98 98" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle opacity="0.16" cx="49" cy="49" r="49" fill="#C2CBD7"/>
        <path d="M59.5418 26H28.8751C27.7251 26 26.9585 26.7666 26.9585 27.9166V70.0833C26.9585 71.2334 27.7251 72 28.8751 72H48.0418V68.1666H30.7918V29.8334H57.6251V47.0834H61.4585V27.9166C61.4585 26.7666 60.6918 26 59.5418 26Z" fill="#1B1464"/>
        <path d="M36.5416 37.5C37.6002 37.5 38.4583 36.6419 38.4583 35.5834C38.4583 34.5248 37.6002 33.6667 36.5416 33.6667C35.4831 33.6667 34.625 34.5248 34.625 35.5834C34.625 36.6419 35.4831 37.5 36.5416 37.5Z" fill="#1B1464"/>
        <path d="M36.5416 47.0833C37.6002 47.0833 38.4583 46.2252 38.4583 45.1666C38.4583 44.1081 37.6002 43.25 36.5416 43.25C35.4831 43.25 34.625 44.1081 34.625 45.1666C34.625 46.2252 35.4831 47.0833 36.5416 47.0833Z" fill="#1B1464"/>
        <path d="M36.5416 56.6666C37.6002 56.6666 38.4583 55.8085 38.4583 54.75C38.4583 53.6915 37.6002 52.8334 36.5416 52.8334C35.4831 52.8334 34.625 53.6915 34.625 54.75C34.625 55.8085 35.4831 56.6666 36.5416 56.6666Z" fill="#1B1464"/>
        <path d="M53.7916 33.6666H40.375V37.5H53.7916V33.6666Z" fill="#1B1464"/>
        <path d="M49.9584 43.25H40.375V47.0834H49.9584V43.25Z" fill="#1B1464"/>
        <path d="M46.125 52.8334H40.375V56.6667H46.125V52.8334Z" fill="#1B1464"/>
        <path d="M67.2083 60.5C67.2083 64.7166 63.7583 68.1666 59.5417 68.1666C55.325 68.1666 51.8749 64.7166 51.8749 60.5C51.8749 56.2834 55.3249 52.8334 59.5416 52.8334C60.4999 52.8334 61.6499 53.025 62.6082 53.4084L64.1416 49.9584C58.3916 47.4667 51.4916 50.15 48.9999 55.9C46.5083 61.65 49.1916 68.55 54.9416 71.0416C60.6916 73.5333 67.5916 70.85 70.0832 65.1C70.6582 63.5666 71.0416 62.0334 71.0416 60.5H67.2083Z" fill="#D71921"/>
        <path d="M65.8667 53.4084L59.5417 59.7334L57.0501 57.2416L54.3667 59.925L58.2001 63.7584C58.9667 64.525 60.1167 64.525 60.8834 63.7584L68.5501 56.0917L65.8667 53.4084Z" fill="#D71921"/>
    </svg>

    </div>
    <div class="welcom-header">
        {{ translate('Thank you for applying as a reseller!')}}
    </div>
    <div class="welcome-body">
    Please allow us 1 to 2 days to review your application. We will notify email for any updates about your application.
    </div>
    <div class="welcom-footer" style="color:#9199A4;">
    Got any concerns? email us at <span style="color:#1B1464 !important;">support@worldcraft.com</span>
    </div>
</div>
</div>
    <a href="{{ route('dashboard') }}">
    <div class="btn-craft-primary fw-500" style="
    margin:auto;
    width:226px;
    margin-bottom:74px;
    font-size:16px;
    ">
    Go to your account
    <svg width="16" height="10" style="margin-left:5px;" viewBox="0 0 16 8" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12.01 3.08333H0V4.91666H12.01V7.66666L16 3.99999L12.01 0.333328V3.08333Z" fill="white"/>
    </svg>
    </div>
    </a>


@endsection