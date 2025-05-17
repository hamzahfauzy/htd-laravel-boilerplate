@extends('themes.sneat.auth.app')

@section('content')
<h4 class="mb-2">{{ __('Confirm Password') }} 🔒</h4>
<p class="mb-4">{{ __('Please confirm your password before continuing.') }}</p>

<form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Password') }}</label>
        <input
        type="password"
        class="form-control @error('password') is-invalid @enderror"
        id="password"
        name="password"
        placeholder="{{__('Enter your password')}}"
        value="{{ old('password') }}" required autocomplete="current-password" autofocus
        />

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <button class="btn btn-primary d-grid w-100">{{__('Confirm Password')}}</button>
</form>
@if (Route::has('password.request'))
<div class="text-center">
    <a href="{{route('password.request')}}" class="d-flex align-items-center justify-content-center">
        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
        {{__('Forgot Your Password?')}}
    </a>
</div>
@endif
@endsection