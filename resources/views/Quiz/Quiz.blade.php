@extends('mains.account_main')
@section('title','Test "'.$q->name.'" | ')
@section('content')
    <showquiz datas="{{$json}}"></showquiz>
@stop
