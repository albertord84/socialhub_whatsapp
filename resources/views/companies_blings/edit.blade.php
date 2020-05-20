@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Companies Blings
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($companiesBlings, ['route' => ['companiesBlings.update', $companiesBlings->id], 'method' => 'patch']) !!}

                        @include('companies_blings.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection