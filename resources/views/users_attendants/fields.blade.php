<!-- User Manager Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_manager_id', 'User Manager Id:') !!}
    {!! Form::number('user_manager_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::number('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('usersAttendants.index') !!}" class="btn btn-default">Cancel</a>
</div>
