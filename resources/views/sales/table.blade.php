<div class="table-responsive">
    <table class="table" id="sales-table">
        <thead>
            <tr>
                <th>Contact Id</th>
        <th>Source</th>
        <th>Sended</th>
        <th>Json Data</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sales as $sales)
            <tr>
                <td>{{ $sales->contact_id }}</td>
            <td>{{ $sales->source }}</td>
            <td>{{ $sales->sended }}</td>
            <td>{{ $sales->json_data }}</td>
                <td>
                    {!! Form::open(['route' => ['sales.destroy', $sales->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('sales.show', [$sales->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('sales.edit', [$sales->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
