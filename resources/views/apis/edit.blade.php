@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Api
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($api, ['route' => ['apis.update', $api->id], 'method' => 'patch']) !!}

                        @include('apis.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection