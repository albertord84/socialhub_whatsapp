<div class="table-responsive">
    <table class="table" id="rpis-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Mac</th>
        <th>Tunnel</th>
        <th>Ip</th>
        <th>Password</th>
        <th>Data</th>
        <th>Soft Version</th>
        <th>Soft Version Date</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rpis as $rpi)
            <tr>
                <td>{!! $rpi->company_id !!}</td>
            <td>{!! $rpi->mac !!}</td>
            <td>{!! $rpi->tunnel !!}</td>
            <td>{!! $rpi->ip !!}</td>
            <td>{!! $rpi->password !!}</td>
            <td>{!! $rpi->data !!}</td>
            <td>{!! $rpi->soft_version !!}</td>
            <td>{!! $rpi->soft_version_date !!}</td>
                <td>
                    {!! Form::open(['route' => ['rpis.destroy', $rpi->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('rpis.show', [$rpi->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('rpis.edit', [$rpi->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
