<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $attendantsTags->id }}</p>
</div>

<!-- Attendant Id Field -->
<div class="form-group">
    {!! Form::label('attendant_id', 'Attendant Id:') !!}
    <p>{{ $attendantsTags->attendant_id }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $attendantsTags->name }}</p>
</div>

<!-- Color Field -->
<div class="form-group">
    {!! Form::label('color', 'Color:') !!}
    <p>{{ $attendantsTags->color }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $attendantsTags->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $attendantsTags->updated_at }}</p>
</div>

