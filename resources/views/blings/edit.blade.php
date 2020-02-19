@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Bling
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bling, ['route' => ['blings.update', $bling->id], 'method' => 'patch']) !!}

                        @include('blings.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection