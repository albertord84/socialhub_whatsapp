<div class="table-responsive">
    <table class="table" id="companiesBlings-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Bling Username</th>
        <th>Bling Apikey</th>
        <th>Bling Message</th>
        <th>Bling Contrated</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($companiesBlings as $companiesBlings)
            <tr>
                <td>{{ $companiesBlings->company_id }}</td>
            <td>{{ $companiesBlings->bling_username }}</td>
            <td>{{ $companiesBlings->bling_apikey }}</td>
            <td>{{ $companiesBlings->bling_message }}</td>
            <td>{{ $companiesBlings->bling_contrated }}</td>
                <td>
                    {!! Form::open(['route' => ['companiesBlings.destroy', $companiesBlings->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('companiesBlings.show', [$companiesBlings->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('companiesBlings.edit', [$companiesBlings->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
