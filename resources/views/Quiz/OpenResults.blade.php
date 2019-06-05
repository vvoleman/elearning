@extends('mains.account_main')
@section('title','Výsledky třídy | ')
@section('content')
    <div>
        <openresults quiz="{{$quiz}}" res="{{json_encode($results)}}" quests="{{json_encode($questions)}}"></openresults>
    </div>
@stop
