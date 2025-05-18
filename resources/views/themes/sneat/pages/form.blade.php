@extends('themes.sneat.app')

@section('title', $header['title'])

@push('styles')
@foreach ($resource::getStyles() as $style)
<link rel="stylesheet" href="{{$style}}">
@endforeach
@endpush

@push('scripts')
@foreach ($resource::getScripts() as $script)
<script src="{{$script}}"></script>
@endforeach
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        @include('libraries.components.header', compact('header'))

        <div class="mb-3"></div>
        
        @include('libraries.components.form', compact('page','sections','data'))
    </div>
</div>
@endsection
