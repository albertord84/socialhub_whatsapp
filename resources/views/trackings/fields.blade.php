<!-- Post Card Field -->
<div class="form-group col-sm-6">
    {!! Form::label('post_card', 'Post Card:') !!}
    {!! Form::text('post_card', null, ['class' => 'form-control']) !!}
</div>

<!-- Post Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('post_date', 'Post Date:') !!}
    {!! Form::date('post_date', null, ['class' => 'form-control','id'=>'post_date']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#post_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush

<!-- Service Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_code', 'Service Code:') !!}
    {!! Form::text('service_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Items Field -->
<div class="form-group col-sm-6">
    {!! Form::label('items', 'Items:') !!}
    {!! Form::number('items', null, ['class' => 'form-control']) !!}
</div>

<!-- Object Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tracking_code', 'Object Code:') !!}
    {!! Form::text('tracking_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Json Csv Data Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('json_csv_data', 'Json Csv Data:') !!}
    {!! Form::textarea('json_csv_data', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status_id', 'Status Id:') !!}
    {!! Form::number('status_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tracking List Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('tracking_list', 'Tracking List:') !!}
    {!! Form::textarea('tracking_list', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('trackings.index') }}" class="btn btn-default">Cancel</a>
</div>
