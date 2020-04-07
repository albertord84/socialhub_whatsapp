<div class="table-responsive">
    <table class="table" id="contactsTags-table">
        <thead>
            <tr>
                <th>Contact Id</th>
        <th>Attendant Id</th>
        <th>Attendant Tag Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contactsTags as $contactsTags)
            <tr>
                <td>{{ $contactsTags->contact_id }}</td>
            <td>{{ $contactsTags->attendant_id }}</td>
            <td>{{ $contactsTags->attendant_tag_id }}</td>
                <td>
                    {!! Form::open(['route' => ['contactsTags.destroy', $contactsTags->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('contactsTags.show', [$contactsTags->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('contactsTags.edit', [$contactsTags->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
