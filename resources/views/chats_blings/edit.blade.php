@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Chats Bling
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($chatsBling, ['route' => ['chatsBlings.update', $chatsBling->id], 'method' => 'patch']) !!}

                        @include('chats_blings.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection