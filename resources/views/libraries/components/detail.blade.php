@foreach($fields as $field => $items)
<div class="col-12 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            {{$field}}
        </div>

        <div class="card-body">
            <div class="detail-container">
                @foreach($items as $value => $label)
                @include('libraries.components.detail-item', compact('value','label','data'))
                @endforeach
            </div>
        </div>
    </div>
</div>
@endforeach