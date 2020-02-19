<!-- Contact Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    {!! Form::number('contact_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source', 'Source:') !!}
    {!! Form::number('source', null, ['class' => 'form-control']) !!}
</div>

<!-- Sended Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sended', 'Sended:') !!}
    {!! Form::number('sended', null, ['class' => 'form-control']) !!}
</div>

<!-- Json Data Field -->
<div class="form-group col-sm-6">
    {!! Form::label('json_data', 'Json Data:') !!}
    {!! Form::text('json_data', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('sales.index') }}" class="btn btn-default">Cancel</a>
</div>
