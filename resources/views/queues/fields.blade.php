<!-- Contact Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    {!! Form::number('contact_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Attendant Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('attendant_id', 'Attendant Id:') !!}
    {!! Form::number('attendant_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::number('company_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source', 'Source:') !!}
    {!! Form::number('source', null, ['class' => 'form-control']) !!}
</div>

<!-- Response To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('response_to', 'Response To:') !!}
    {!! Form::number('response_to', null, ['class' => 'form-control']) !!}
</div>

<!-- Message Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('message', 'Message:') !!}
    {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_id', 'Type Id:') !!}
    {!! Form::number('type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Data Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data', 'Data:') !!}
    {!! Form::text('data', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status_id', 'Status Id:') !!}
    {!! Form::number('status_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Socialnetwork Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('socialnetwork_id', 'Socialnetwork Id:') !!}
    {!! Form::number('socialnetwork_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('queues.index') }}" class="btn btn-default">Cancel</a>
</div>
