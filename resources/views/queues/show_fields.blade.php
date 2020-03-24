<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $queue->id }}</p>
</div>

<!-- Contact Id Field -->
<div class="form-group">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    <p>{{ $queue->contact_id }}</p>
</div>

<!-- Attendant Id Field -->
<div class="form-group">
    {!! Form::label('attendant_id', 'Attendant Id:') !!}
    <p>{{ $queue->attendant_id }}</p>
</div>

<!-- Company Id Field -->
<div class="form-group">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $queue->company_id }}</p>
</div>

<!-- Source Field -->
<div class="form-group">
    {!! Form::label('source', 'Source:') !!}
    <p>{{ $queue->source }}</p>
</div>

<!-- Response To Field -->
<div class="form-group">
    {!! Form::label('response_to', 'Response To:') !!}
    <p>{{ $queue->response_to }}</p>
</div>

<!-- Message Field -->
<div class="form-group">
    {!! Form::label('message', 'Message:') !!}
    <p>{{ $queue->message }}</p>
</div>

<!-- Type Id Field -->
<div class="form-group">
    {!! Form::label('type_id', 'Type Id:') !!}
    <p>{{ $queue->type_id }}</p>
</div>

<!-- Data Field -->
<div class="form-group">
    {!! Form::label('data', 'Data:') !!}
    <p>{{ $queue->data }}</p>
</div>

<!-- Status Id Field -->
<div class="form-group">
    {!! Form::label('status_id', 'Status Id:') !!}
    <p>{{ $queue->status_id }}</p>
</div>

<!-- Socialnetwork Id Field -->
<div class="form-group">
    {!! Form::label('socialnetwork_id', 'Socialnetwork Id:') !!}
    <p>{{ $queue->socialnetwork_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $queue->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $queue->updated_at }}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{{ $queue->deleted_at }}</p>
</div>

