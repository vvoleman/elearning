@extends('mains.editcourse')
@section('title','Třídy kurzu "'.$c->name.'" | ')
@section('content')
    <div>
        <editgroups datas="{{json_encode($c->groups)}}" course="{{$c->id_c}}"></editgroups>
    </div>
@stop