@extends('mains.account_main')
@section('title','Správa přístupu k "'.$q["name"].'" | ')
@section('content')
    <passmanage datas="{{json_encode($data)}}" quiz="{{json_encode($q)}}"></passmanage>
@stop
