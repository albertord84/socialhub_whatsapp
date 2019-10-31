@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Users Seller
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($usersSeller, ['route' => ['usersSellers.update', $usersSeller->id], 'method' => 'patch']) !!}

                        @include('users_sellers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection