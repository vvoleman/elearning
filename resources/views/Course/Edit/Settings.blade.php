@extends('mains.editcourse')
@section('title','Nastavení kurzu "'.$c->name.'" | ')
@section('content')
    <div>
        {!! Form::open(["route"=>["course.postSettings",$c->slug]]) !!}
        <ecset datas="{{json_encode($c->prepare)}}"></ecset>
        {!! Form::close() !!}
    </div>
@stop