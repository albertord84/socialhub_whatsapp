<div class="table-responsive">
    <table class="table" id="trackings-table">
        <thead>
            <tr>
                <th>Post Card</th>
        <th>Post Date</th>
        <th>Service Code</th>
        <th>Items</th>
        <th>Object Code</th>
        <th>Json Csv Data</th>
        <th>Status Id</th>
        <th>Tracking List</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($trackings as $tracking)
            <tr>
                <td>{{ $tracking->post_card }}</td>
            <td>{{ $tracking->post_date }}</td>
            <td>{{ $tracking->service_code }}</td>
            <td>{{ $tracking->items }}</td>
            <td>{{ $tracking->object_code }}</td>
            <td>{{ $tracking->json_csv_data }}</td>
            <td>{{ $tracking->status_id }}</td>
            <td>{{ $tracking->tracking_list }}</td>
                <td>
                    {!! Form::open(['route' => ['trackings.destroy', $tracking->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('trackings.show', [$tracking->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('trackings.edit', [$tracking->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
