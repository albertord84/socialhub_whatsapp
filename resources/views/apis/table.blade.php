<div class="table-responsive">
    <table class="table" id="apis-table">
        <thead>
            <tr>
                <th>Contact Id</th>
        <th>Sended</th>
        <th>Message</th>
        <th>Type Id</th>
        <th>Data</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($apis as $api)
            <tr>
                <td>{{ $api->contact_id }}</td>
            <td>{{ $api->sended }}</td>
            <td>{{ $api->message }}</td>
            <td>{{ $api->type_id }}</td>
            <td>{{ $api->data }}</td>
                <td>
                    {!! Form::open(['route' => ['apis.destroy', $api->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('apis.show', [$api->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('apis.edit', [$api->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
