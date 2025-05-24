@extends('themes.sneat.minimal')
@section('content')
<div class="container-xxl container-p-y">
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">{{__('Welcome')}}</h2>
        <p class="mb-4 mx-2">{{__('Please login to use this application')}}</p>
        <a href="{{route('login')}}" class="btn btn-primary">{{__('Login')}}</a>
        <div class="mt-3">
            <img
            src="{{asset('assets/img/illustrations/girl-doing-yoga-light.png')}}"
            alt="girl-doing-yoga-light"
            width="500"
            class="img-fluid"
            data-app-dark-img="illustrations/girl-doing-yoga-light.png"
            data-app-light-img="illustrations/girl-doing-yoga-light.png"
            />
        </div>
    </div>
</div>
@endsection