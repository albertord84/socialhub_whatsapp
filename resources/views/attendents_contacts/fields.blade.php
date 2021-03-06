<!-- Attendant Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('attendant_id', 'Attendant Id:') !!}
    {!! Form::number('attendant_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Contact Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    {!! Form::number('contact_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('attendantsContacts.index') !!}" class="btn btn-default">Cancel</a>
</div>
