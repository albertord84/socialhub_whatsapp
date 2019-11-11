@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Messages Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($messagesType, ['route' => ['messagesTypes.update', $messagesType->id], 'method' => 'patch']) !!}

                        @include('messages_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection