<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::number('company_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Bling Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bling_username', 'Bling Username:') !!}
    {!! Form::text('bling_username', null, ['class' => 'form-control']) !!}
</div>

<!-- Bling Apikey Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bling_apikey', 'Bling Apikey:') !!}
    {!! Form::text('bling_apikey', null, ['class' => 'form-control']) !!}
</div>

<!-- Bling Message Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bling_message', 'Bling Message:') !!}
    {!! Form::text('bling_message', null, ['class' => 'form-control']) !!}
</div>

<!-- Bling Contrated Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bling_contrated', 'Bling Contrated:') !!}
    {!! Form::number('bling_contrated', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('companiesBlings.index') }}" class="btn btn-default">Cancel</a>
</div>
