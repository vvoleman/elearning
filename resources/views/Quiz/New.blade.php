@extends('mains.account_main')
@section('title','Nový test | ')
@section('content')
    {{Form::open()}}
    <newquiz course_id="{{$course_id}}"></newquiz>
    {{Form::close()}}
@stop
