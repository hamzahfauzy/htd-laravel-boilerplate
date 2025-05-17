@extends('themes.sneat.app')

@section('title', $header['title'])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        @include('libraries.components.header', compact('header'))

        <div class="mb-3"></div>
        
        @include('libraries.components.detail', compact('fields','data'))
    </div>
</div>
@endsection
