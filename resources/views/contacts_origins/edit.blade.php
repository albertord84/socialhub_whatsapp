@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Contacts Origins
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($contactsOrigins, ['route' => ['contactsOrigins.update', $contactsOrigins->id], 'method' => 'patch']) !!}

                        @include('contacts_origins.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection