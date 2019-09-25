<div class="table-responsive">
    <table class="table" id="systemConfigs-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Value</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($systemConfigs as $systemConfig)
            <tr>
                <td>{!! $systemConfig->name !!}</td>
            <td>{!! $systemConfig->value !!}</td>
            <td>{!! $systemConfig->description !!}</td>
                <td>
                    {!! Form::open(['route' => ['systemConfigs.destroy', $systemConfig->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('systemConfigs.show', [$systemConfig->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('systemConfigs.edit', [$systemConfig->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
