<div class="table-responsive">
    <table class="table" id="queues-table">
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
        @foreach($queues as $queue)
            <tr>
                <td>{{ $queue->contact_id }}</td>
            <td>{{ $queue->attendant_id }}</td>
            <td>{{ $queue->company_id }}</td>
            <td>{{ $queue->source }}</td>
            <td>{{ $queue->response_to }}</td>
            <td>{{ $queue->message }}</td>
            <td>{{ $queue->type_id }}</td>
            <td>{{ $queue->data }}</td>
            <td>{{ $queue->status_id }}</td>
            <td>{{ $queue->socialnetwork_id }}</td>
                <td>
                    {!! Form::open(['route' => ['queues.destroy', $queue->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('queues.show', [$queue->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('queues.edit', [$queue->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
