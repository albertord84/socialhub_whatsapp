<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $attendantsContact->id !!}</p>
</div>

<!-- Attendant Id Field -->
<div class="form-group">
    {!! Form::label('attendant_id', 'Attendant Id:') !!}
    <p>{!! $attendantsContact->attendant_id !!}</p>
</div>

<!-- Contact Id Field -->
<div class="form-group">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    <p>{!! $attendantsContact->contact_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $attendantsContact->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $attendantsContact->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $attendantsContact->deleted_at !!}</p>
</div>

