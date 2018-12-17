@extends('mains/editcourse')
@section('title',' Lektoři kurzu "'.$c->name.'" | ')
@section('content')
    <div>
        <editlectors datas="{{json_encode($c->owners)}}" course="{{$c->id_c}}"></editlectors>
        {{$c->id_c}}
    </div>
@stop