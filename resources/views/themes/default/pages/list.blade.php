@extends('themes.default.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
<script src="{{asset('js/datatable.js')}}"></script>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('libraries.components.header', compact('header'))

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! $datatable->renderColumn() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
