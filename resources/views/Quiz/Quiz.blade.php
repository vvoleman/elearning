@extends('mains.account_main')
@section('title','Test "'.$q->name.'" | ')
@section('content')
@csrf
<showquiz datas="{{$json}}"></showquiz>
@stop
