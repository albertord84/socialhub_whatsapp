<div class="table-responsive">
    <table class="table" id="chats-table">
        <thead>
            <tr>
                <th>Contact Id</th>
        <th>Attendant Id</th>
        <th>Message</th>
        <th>Type Id</th>
        <th>Data</th>
        <th>Status Id</th>
        <th>Socialnetwork Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($chats as $chat)
            <tr>
                <td>{!! $chat->contact_id !!}</td>
            <td>{!! $chat->attendant_id !!}</td>
            <td>{!! $chat->message !!}</td>
            <td>{!! $chat->type_id !!}</td>
            <td>{!! $chat->data !!}</td>
            <td>{!! $chat->status_id !!}</td>
            <td>{!! $chat->socialnetwork_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['chats.destroy', $chat->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('chats.show', [$chat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('chats.edit', [$chat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
