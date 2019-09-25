<div class="table-responsive">
    <table class="table" id="passwordResets-table">
        <thead>
            <tr>
                <th>Email</th>
        <th>Token</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($passwordResets as $passwordReset)
            <tr>
                <td>{!! $passwordReset->email !!}</td>
            <td>{!! $passwordReset->token !!}</td>
                <td>
                    {!! Form::open(['route' => ['passwordResets.destroy', $passwordReset->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('passwordResets.show', [$passwordReset->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('passwordResets.edit', [$passwordReset->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
