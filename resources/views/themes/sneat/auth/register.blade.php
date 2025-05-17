@extends('themes.sneat.auth.app')

@section('content')
<!-- /Logo -->
<h4 class="mb-2">Adventure starts here 🚀</h4>
<p class="mb-4">Make your app management easy and fun!</p>

<form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input
        type="text"
        class="form-control @error('name') is-invalid @enderror"
        id="name"
        name="name"
        placeholder="{{__('Enter your name')}}"
        value="{{ old('name') }}" required autocomplete="name" autofocus
        />

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email Address') }}</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{__('Enter your email')}}" value="{{ old('email') }}" required autocomplete="email" />

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3 form-password-toggle">
        <label class="form-label" for="password">{{__('Password')}}</label>
        <div class="input-group input-group-merge @error('password') is-invalid @enderror">
        <input
            type="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
            aria-describedby="password"
            required autocomplete="new-password"
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

    <button class="btn btn-primary d-grid w-100">{{__('Sign up')}}</button>
</form>

<p class="text-center">
    <span>{{__('Already have an account?')}}</span>
    <a href="{{route('login')}}">
        <span>{{__('Sign in instead')}}</span>
    </a>
</p>
@endsection