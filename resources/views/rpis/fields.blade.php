<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::number('company_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mac Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mac', 'Mac:') !!}
    {!! Form::text('mac', null, ['class' => 'form-control']) !!}
</div>

<!-- Tunnel Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tunnel', 'Tunnel:') !!}
    {!! Form::text('tunnel', null, ['class' => 'form-control']) !!}
</div>

<!-- Ip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip', 'Ip:') !!}
    {!! Form::text('ip', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Data Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data', 'Data:') !!}
    {!! Form::text('data', null, ['class' => 'form-control']) !!}
</div>

<!-- Soft Version Field -->
<div class="form-group col-sm-6">
    {!! Form::label('soft_version', 'Soft Version:') !!}
    {!! Form::text('soft_version', null, ['class' => 'form-control']) !!}
</div>

<!-- Soft Version Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('soft_version_date', 'Soft Version Date:') !!}
    {!! Form::text('soft_version_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('rpis.index') !!}" class="btn btn-default">Cancel</a>
</div>
