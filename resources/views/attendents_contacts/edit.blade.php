@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Attendents Contact
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($attendentsContact, ['route' => ['attendentsContacts.update', $attendentsContact->id], 'method' => 'patch']) !!}

                        @include('attendents_contacts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection