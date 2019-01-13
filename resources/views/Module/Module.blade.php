@extends('mains.account_main')
@section('title',$module->name.' | ')
@section('content')
    <moduleview datas="{{json_encode($data)}}"></moduleview>
@stop