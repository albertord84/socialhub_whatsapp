<div class="table-responsive">
    <table class="table" id="contacts-table">
        <thead>
            <tr>
                <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Whatsapp Id</th>
        <th>Facebook Id</th>
        <th>Instagram Id</th>
        <th>Linkedin Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contacts as $contact)
            <tr>
                <td>{!! $contact->first_name !!}</td>
            <td>{!! $contact->last_name !!}</td>
            <td>{!! $contact->phone !!}</td>
            <td>{!! $contact->whatsapp_id !!}</td>
            <td>{!! $contact->facebook_id !!}</td>
            <td>{!! $contact->instagram_id !!}</td>
            <td>{!! $contact->linkedin_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['contacts.destroy', $contact->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('contacts.show', [$contact->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('contacts.edit', [$contact->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
