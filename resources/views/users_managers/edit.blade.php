@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Users Manager
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($usersManager, ['route' => ['usersManagers.update', $usersManager->id], 'method' => 'patch']) !!}

                        @include('users_managers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection