@foreach($fields as $field => $items)
<div class="col-12 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{$field}}</h4>
        </div>

        <div class="card-body">
            @if(is_array($items))
            <div class="detail-container">
                @foreach($items as $value => $label)
                @include('libraries.components.detail-item', compact('value','label','data'))
                @endforeach
            </div>
            @endif

            @if(is_string($items))
            {!! $items !!}
            @endif
        </div>
    </div>
</div>
@endforeach