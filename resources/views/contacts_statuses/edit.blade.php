@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Contacts Status
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($contactsStatus, ['route' => ['contactsStatuses.update', $contactsStatus->id], 'method' => 'patch']) !!}

                        @include('contacts_statuses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection