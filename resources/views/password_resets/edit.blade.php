@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Password Reset
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($passwordReset, ['route' => ['passwordResets.update', $passwordReset->id], 'method' => 'patch']) !!}

                        @include('password_resets.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection