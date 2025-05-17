@extends('themes.sneat.auth.app')

@section('content')
<h4 class="mb-2">{{ __('Reset Password') }}</h4>
<p class="mb-4">{{__("Please fill the following field to reset your password")}}</p>
<form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email Address') }}</label>
        <input
        type="text"
        class="form-control @error('email') is-invalid @enderror"
        id="email"
        name="email"
        placeholder="{{__('Enter your email')}}"
        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
        />

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">{{ __('Password') }}</label>
        </div>
        <div class="input-group input-group-merge @error('password') is-invalid @enderror">
            <input
                type="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password"
                required autocomplete="current-password"
            />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3 form-password-toggle">
        <label class="form-label" for="password">{{ __('Confirm Password') }}</label>
        <div class="input-group input-group-merge">
        <input
            type="password"
            id="password-confirm"
            class="form-control"
            name="password_confirmation"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
            aria-describedby="password"
            required autocomplete="new-password"
        />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
    </div>
    <button class="btn btn-primary d-grid w-100">{{ __('Reset Password') }}</button>
</form>
@endsection