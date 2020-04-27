@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Contacts Tags
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('contacts_tags.show_fields')
                    <a href="{{ route('contactsTags.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
