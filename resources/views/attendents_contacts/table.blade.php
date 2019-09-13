<div class="table-responsive">
    <table class="table" id="attendantsContacts-table">
        <thead>
            <tr>
                <th>Attendant Id</th>
        <th>Contact Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($attendantsContacts as $attendantsContact)
            <tr>
                <td>{!! $attendantsContact->attendant_id !!}</td>
            <td>{!! $attendantsContact->contact_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['attendantsContacts.destroy', $attendantsContact->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('attendantsContacts.show', [$attendantsContact->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('attendantsContacts.edit', [$attendantsContact->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
