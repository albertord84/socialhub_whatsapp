<div class="table-responsive">
    <table class="table" id="usersAttendants-table">
        <thead>
            <tr>
                <th>User Manager Id</th>
        <th>Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usersAttendants as $usersAttendant)
            <tr>
                <td>{!! $usersAttendant->user_manager_id !!}</td>
            <td>{!! $usersAttendant->code !!}</td>
                <td>
                    {!! Form::open(['route' => ['usersAttendants.destroy', $usersAttendant->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('usersAttendants.show', [$usersAttendant->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('usersAttendants.edit', [$usersAttendant->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
