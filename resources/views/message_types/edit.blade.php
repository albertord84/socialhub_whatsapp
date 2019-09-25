@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Message Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($messageType, ['route' => ['messageTypes.update', $messageType->id], 'method' => 'patch']) !!}

                        @include('message_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection