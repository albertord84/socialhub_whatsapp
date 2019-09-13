<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $passwordReset->email !!}</p>
</div>

<!-- Token Field -->
<div class="form-group">
    {!! Form::label('token', 'Token:') !!}
    <p>{!! $passwordReset->token !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $passwordReset->created_at !!}</p>
</div>

