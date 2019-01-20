@extends('mains.account_main')
@section('title',$module->name.' | ')
@section('content')
    <moduleview datas="{{json_encode($data)}}" name="{{$module->name}}" desc="{{$module->desc}}"></moduleview>
    <!--<modulecreate></modulecreate>!-->
@stop