@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Socialnetwork
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($socialnetwork, ['route' => ['socialnetworks.update', $socialnetwork->id], 'method' => 'patch']) !!}

                        @include('socialnetworks.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection