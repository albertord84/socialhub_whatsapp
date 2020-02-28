<div class="table-responsive">
    <table class="table" id="chatsBlings-table">
        <thead>
            <tr>
                <th>Contact Id</th>
        <th>Attendant Id</th>
        <th>Company Id</th>
        <th>Source</th>
        <th>Response To</th>
        <th>Message</th>
        <th>Type Id</th>
        <th>Data</th>
        <th>Status Id</th>
        <th>Socialnetwork Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($chatsBlings as $chatsBling)
            <tr>
                <td>{{ $chatsBling->contact_id }}</td>
            <td>{{ $chatsBling->attendant_id }}</td>
            <td>{{ $chatsBling->company_id }}</td>
            <td>{{ $chatsBling->source }}</td>
            <td>{{ $chatsBling->response_to }}</td>
            <td>{{ $chatsBling->message }}</td>
            <td>{{ $chatsBling->type_id }}</td>
            <td>{{ $chatsBling->data }}</td>
            <td>{{ $chatsBling->status_id }}</td>
            <td>{{ $chatsBling->socialnetwork_id }}</td>
                <td>
                    {!! Form::open(['route' => ['chatsBlings.destroy', $chatsBling->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('chatsBlings.show', [$chatsBling->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('chatsBlings.edit', [$chatsBling->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
