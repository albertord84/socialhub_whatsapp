<div class="table-responsive">
    <table class="table" id="attendantsTags-table">
        <thead>
            <tr>
                <th>Attendant Id</th>
        <th>Name</th>
        <th>Color</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($attendantsTags as $attendantsTags)
            <tr>
                <td>{{ $attendantsTags->attendant_id }}</td>
            <td>{{ $attendantsTags->name }}</td>
            <td>{{ $attendantsTags->color }}</td>
                <td>
                    {!! Form::open(['route' => ['attendantsTags.destroy', $attendantsTags->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('attendantsTags.show', [$attendantsTags->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('attendantsTags.edit', [$attendantsTags->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
