@extends('themes.sneat.auth.app')

@section('content')
<h4 class="mb-2">{{ __('Verify Your Email Address') }}</h4>

@if (session('resent'))
    <div class="alert alert-success" role="alert">
        {{ __('A fresh verification link has been sent to your email address.') }}
    </div>
@endif

<p class="mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
<p class="mb-4">{{ __('If you did not receive the email') }}</p>
<form id="formAuthentication" class="mb-3" method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button class="btn btn-primary d-grid w-100">{{ __('Click here to request another') }}</button>
</form>
@endsection