@extends('themes.sneat.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {!! \App\Libraries\Dashboard::render() !!}
</div>
@endsection
