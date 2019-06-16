@extends('mains.account_main')
@section('title','Test "'.$q->name.'" | ')
@section('content')
@csrf
<showquiz datas="{{$json}}" corr_amount="{{json_encode($corr_amount)}}"></showquiz>
@stop
