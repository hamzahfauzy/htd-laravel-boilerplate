<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($page->isEdit)
    @method('PUT')
    @endif
    
    @foreach($sections as $sectionLabel => $fields)
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header">
                {{$sectionLabel}}
            </div>
            <div class="card-body">
                @include('libraries.components.field', ['fields' => $fields, 'data' => $data])
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>