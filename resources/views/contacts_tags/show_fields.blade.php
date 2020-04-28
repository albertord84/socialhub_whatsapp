<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $contactsTags->id }}</p>
</div>

<!-- Contact Id Field -->
<div class="form-group">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    <p>{{ $contactsTags->contact_id }}</p>
</div>

<!-- Attendant Id Field -->
<div class="form-group">
    {!! Form::label('attendant_id', 'Attendant Id:') !!}
    <p>{{ $contactsTags->attendant_id }}</p>
</div>

<!-- Attendant Tag Id Field -->
<div class="form-group">
    {!! Form::label('attendant_tag_id', 'Attendant Tag Id:') !!}
    <p>{{ $contactsTags->attendant_tag_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $contactsTags->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $contactsTags->updated_at }}</p>
</div>

