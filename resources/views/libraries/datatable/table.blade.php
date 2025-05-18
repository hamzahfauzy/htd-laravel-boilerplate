<div class="">
    <table class="table {{$class}} table-responsive">
        <thead>
            <tr>
                @foreach($columns as $column)
                <th>{{$column}}</th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>