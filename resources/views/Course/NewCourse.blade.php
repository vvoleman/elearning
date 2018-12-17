@extends('mains.account_main')
@section('title','Nový kurz | ')
@section('content')
    {{Form::open(["route"=>"course.postNewCourse"])}}
        <newcourse></newcourse>
    {{Form::close()}}
@stop
