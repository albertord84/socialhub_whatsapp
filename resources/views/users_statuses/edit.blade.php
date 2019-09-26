@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Users Status
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($usersStatus, ['route' => ['usersStatuses.update', $usersStatus->id], 'method' => 'patch']) !!}

                        @include('users_statuses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection