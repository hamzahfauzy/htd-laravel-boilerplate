<div class="card-datatable overflow-hidden">
    <table class="table {{$class}}">
        <thead>
            <tr>
                @foreach($columns as $column)
                <th>{{$column}}</th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>