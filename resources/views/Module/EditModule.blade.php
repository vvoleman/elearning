@extends('mains.account_main')
@section('title','Úprava modulu '.$module->name.' | ')
@section('content')
    {{Form::open(["route"=>["module.postEditModule",$c->slug,$module->order]])}}
    <modulecreate datas="{{json_encode($data)}}" name="{{$module->name}}" desc="{{$module->desc}}"></modulecreate>
    {{Form::close()}}
@stop