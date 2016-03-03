@extends('layouts.main')

@section('content')

<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Edit Contact</strong>
  </div>

  {!! Form::model($contact, ['files' => true, 'method' => 'PATCH', 'route' => ['contacts.update', $contact->id]]) !!}

  @include('contacts.form')

  {!! Form::close() !!}

</div>

@endsection
