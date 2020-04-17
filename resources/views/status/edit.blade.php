@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Statu
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($statu, ['route' => ['status.update', $statu->id], 'method' => 'patch']) !!}

                        @include('status.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection