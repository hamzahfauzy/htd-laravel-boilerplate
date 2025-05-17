<div class="d-flex justify-content-between align-items-center">
    <h3 class="m-0">{{ $header['title'] }}</h3>

    <div class="header-button">
        {!! $header['button'] ? implode(' ', $header['button']) : '' !!}
    </div>
</div>