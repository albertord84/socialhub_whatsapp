@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Messages Status
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($messagesStatus, ['route' => ['messagesStatuses.update', $messagesStatus->id], 'method' => 'patch']) !!}

                        @include('messages_statuses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection