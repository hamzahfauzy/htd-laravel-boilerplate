@extends('themes.sneat.minimal')
@section('title','401 Unauthorized')
@section('content')
<div class="container-xxl container-p-y">
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">{{__('401 Unauthorized')}}</h2>
        <p class="mb-4 mx-2">{{__('Sorry! you cannot access this page.')}}</p>
        <a href="{{url('/')}}" class="btn btn-primary">{{__('Back to home')}}</a>
    </div>
</div>
@endsection