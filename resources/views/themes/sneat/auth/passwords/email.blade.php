@extends('themes.sneat.auth.app')

@section('content')
<h4 class="mb-2">{{ __('Reset Password') }} 🔒</h4>
<p class="mb-4">{{__("Enter your email and we'll send you instructions to reset your password")}}</p>

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email Address') }}</label>
        <input
        type="text"
        class="form-control @error('email') is-invalid @enderror"
        id="email"
        name="email"
        placeholder="{{__('Enter your email')}}"
        value="{{ old('email') }}" required autocomplete="email" autofocus
        />

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <button class="btn btn-primary d-grid w-100">{{__('Send Reset Link')}}</button>
</form>
<div class="text-center">
    <a href="{{route('login')}}" class="d-flex align-items-center justify-content-center">
        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
        {{__('Back to login')}}
    </a>
</div>
@endsection