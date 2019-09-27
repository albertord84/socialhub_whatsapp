<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{!! $usersAttendant->user_id !!}</p>
</div>

<!-- User Manager Id Field -->
<div class="form-group">
    {!! Form::label('user_manager_id', 'User Manager Id:') !!}
    <p>{!! $usersAttendant->user_manager_id !!}</p>
</div>

<!-- Code Field -->
<div class="form-group">
    {!! Form::label('code', 'Code:') !!}
    <p>{!! $usersAttendant->code !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $usersAttendant->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $usersAttendant->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $usersAttendant->deleted_at !!}</p>
</div>

