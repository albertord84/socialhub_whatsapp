<!-- First Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Whatsapp Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whatsapp_id', 'Whatsapp Id:') !!}
    {!! Form::text('whatsapp_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Facebook Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('facebook_id', 'Facebook Id:') !!}
    {!! Form::text('facebook_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Instagram Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('instagram_id', 'Instagram Id:') !!}
    {!! Form::text('instagram_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Linkedin Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('linkedin_id', 'Linkedin Id:') !!}
    {!! Form::text('linkedin_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('contacts.index') !!}" class="btn btn-default">Cancel</a>
</div>
