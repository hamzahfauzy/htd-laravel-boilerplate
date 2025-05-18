@extends('themes.sneat.app')

@section('title', $header['title'])

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="{{asset('css/dataTables.css')}}">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
<script src="{{asset('js/datatable.js')}}"></script>
@endpush

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
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    @include('libraries.components.header', compact('header'))
                </div>
                {!! $datatable->renderColumn() !!}
            </div>
        </div>
    </div>
</div>
@endsection
