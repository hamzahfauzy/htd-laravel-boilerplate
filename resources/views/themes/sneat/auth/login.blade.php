@extends('themes.sneat.auth.app')

@section('content')
    <!-- /Logo -->
<h4 class="mb-2">Welcome to Sneat! 👋</h4>
<p class="mb-4">{{__('Please sign-in to your account and start the adventure')}}</p>

<form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
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
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">{{ __('Password') }}</label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
                <small>{{ __('Forgot Your Password?') }}</small>
            </a>
            @endif
        </div>
        <div class="input-group input-group-merge">
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
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }}/>
            <label class="form-check-label" for="remember-me">{{ __('Remember Me') }}</label>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
    </div>
</form>

@if (Route::has('register'))
<p class="text-center">
    <span>{{__('New on our platform?')}}</span>
    <a href="{{route('register')}}">
        <span>{{__('Create an account')}}</span>
    </a>
</p>
@endif
@endsection
    