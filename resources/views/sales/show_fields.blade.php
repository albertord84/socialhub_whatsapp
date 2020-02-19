<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $sales->id }}</p>
</div>

<!-- Contact Id Field -->
<div class="form-group">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    <p>{{ $sales->contact_id }}</p>
</div>

<!-- Source Field -->
<div class="form-group">
    {!! Form::label('source', 'Source:') !!}
    <p>{{ $sales->source }}</p>
</div>

<!-- Sended Field -->
<div class="form-group">
    {!! Form::label('sended', 'Sended:') !!}
    <p>{{ $sales->sended }}</p>
</div>

<!-- Json Data Field -->
<div class="form-group">
    {!! Form::label('json_data', 'Json Data:') !!}
    <p>{{ $sales->json_data }}</p>
</div>

