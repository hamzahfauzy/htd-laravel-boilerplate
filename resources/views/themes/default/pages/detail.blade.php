@extends('themes.default.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('libraries.components.header', compact('header'))
        
        @include('libraries.components.detail', compact('fields','data'))
    </div>
</div>
@endsection
