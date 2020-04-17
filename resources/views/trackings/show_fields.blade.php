<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $tracking->id }}</p>
</div>

<!-- Post Card Field -->
<div class="form-group">
    {!! Form::label('post_card', 'Post Card:') !!}
    <p>{{ $tracking->post_card }}</p>
</div>

<!-- Post Date Field -->
<div class="form-group">
    {!! Form::label('post_date', 'Post Date:') !!}
    <p>{{ $tracking->post_date }}</p>
</div>

<!-- Service Code Field -->
<div class="form-group">
    {!! Form::label('service_code', 'Service Code:') !!}
    <p>{{ $tracking->service_code }}</p>
</div>

<!-- Items Field -->
<div class="form-group">
    {!! Form::label('items', 'Items:') !!}
    <p>{{ $tracking->items }}</p>
</div>

<!-- Object Code Field -->
<div class="form-group">
    {!! Form::label('tracking_code', 'Object Code:') !!}
    <p>{{ $tracking->tracking_code }}</p>
</div>

<!-- Json Csv Data Field -->
<div class="form-group">
    {!! Form::label('json_csv_data', 'Json Csv Data:') !!}
    <p>{{ $tracking->json_csv_data }}</p>
</div>

<!-- Status Id Field -->
<div class="form-group">
    {!! Form::label('status_id', 'Status Id:') !!}
    <p>{{ $tracking->status_id }}</p>
</div>

<!-- Tracking List Field -->
<div class="form-group">
    {!! Form::label('tracking_list', 'Tracking List:') !!}
    <p>{{ $tracking->tracking_list }}</p>
</div>

