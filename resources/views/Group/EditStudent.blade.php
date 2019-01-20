@extends('mains.account_main')
@section('title',$g["name"].' | ')
@section('content')
    <editstudent datas="{{json_encode($g)}}" slug="{{$g["slug"]}}"></editstudent>
@stop
