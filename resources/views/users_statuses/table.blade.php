<div class="table-responsive">
    <table class="table" id="usersStatuses-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usersStatuses as $usersStatus)
            <tr>
                <td>{!! $usersStatus->name !!}</td>
            <td>{!! $usersStatus->description !!}</td>
                <td>
                    {!! Form::open(['route' => ['usersStatuses.destroy', $usersStatus->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('usersStatuses.show', [$usersStatus->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('usersStatuses.edit', [$usersStatus->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
