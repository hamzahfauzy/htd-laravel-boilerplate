<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($page->isEdit)
    @method('PUT')
    @endif
    
    @foreach($sections as $sectionLabel => $fields)
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header">
                <h4>{{$sectionLabel}}</h4>
            </div>
            <div class="card-body">
                @if(is_array($fields))
                @include('libraries.components.field', ['fields' => $fields, 'data' => $data, 'page' => $page])
                @endif

                @if(is_string($fields))
                {!! $fields !!}
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>