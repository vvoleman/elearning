@extends('mains.account_main')
@section('title','Nový modul | ')
@section('content')
    {!! Form::open(["route"=>["module.postNewModule",$c->slug]]) !!}
    <modulecreate></modulecreate>
    {!! Form::close() !!}
@stop