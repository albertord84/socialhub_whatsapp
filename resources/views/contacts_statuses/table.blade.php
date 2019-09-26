<div class="table-responsive">
    <table class="table" id="contactsStatuses-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contactsStatuses as $contactsStatus)
            <tr>
                <td>{!! $contactsStatus->name !!}</td>
            <td>{!! $contactsStatus->description !!}</td>
                <td>
                    {!! Form::open(['route' => ['contactsStatuses.destroy', $contactsStatus->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('contactsStatuses.show', [$contactsStatus->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('contactsStatuses.edit', [$contactsStatus->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
