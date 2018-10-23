@extends('mains/account_main')
@section('title','Dashboard |')
@section('content')
    <h1>Role: {{ ucfirst(__("roles.".Auth::user()->role->name)) }}</h1>
@stop