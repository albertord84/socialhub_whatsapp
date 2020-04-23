@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Attendants Tags
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($attendantsTags, ['route' => ['attendantsTags.update', $attendantsTags->id], 'method' => 'patch']) !!}

                        @include('attendants_tags.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection