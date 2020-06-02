<div class="table-responsive">
    <table class="table" id="rapidMessages-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Message</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rapidMessages as $rapidMessages)
            <tr>
                <td>{{ $rapidMessages->user_id }}</td>
            <td>{{ $rapidMessages->message }}</td>
                <td>
                    {!! Form::open(['route' => ['rapidMessages.destroy', $rapidMessages->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('rapidMessages.show', [$rapidMessages->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('rapidMessages.edit', [$rapidMessages->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
