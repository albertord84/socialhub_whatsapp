<div class="table-responsive">
    <table class="table" id="contactsOrigins-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contactsOrigins as $contactsOrigins)
            <tr>
                <td>{{ $contactsOrigins->name }}</td>
            <td>{{ $contactsOrigins->description }}</td>
                <td>
                    {!! Form::open(['route' => ['contactsOrigins.destroy', $contactsOrigins->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('contactsOrigins.show', [$contactsOrigins->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('contactsOrigins.edit', [$contactsOrigins->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
