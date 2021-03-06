<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Whatsapp Id</th>
        <th>Facebook Id</th>
        <th>Instagram Id</th>
        <th>Linkedin Id</th>
        <th>Email Verified At</th>
        <th>Password</th>
        <th>Remember Token</th>
        <th>Login</th>
        <th>Cpf</th>
        <th>Phone</th>
        <th>Image Path</th>
        <th>Role Id</th>
        <th>Status Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{!! $user->company_id !!}</td>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->whatsapp_id !!}</td>
            <td>{!! $user->facebook_id !!}</td>
            <td>{!! $user->instagram_id !!}</td>
            <td>{!! $user->linkedin_id !!}</td>
            <td>{!! $user->email_verified_at !!}</td>
            <td>{!! $user->password !!}</td>
            <td>{!! $user->remember_token !!}</td>
            <td>{!! $user->login !!}</td>
            <td>{!! $user->CPF !!}</td>
            <td>{!! $user->phone !!}</td>
            <td>{!! $user->image_path !!}</td>
            <td>{!! $user->role_id !!}</td>
            <td>{!! $user->status_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
