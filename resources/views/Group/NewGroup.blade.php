@extends('mains.account_main')
@section('title','Nová třída | ')
@section('content')
    <div>
        {!! Form::open(["route"=>'group.postNewGroup',"files"=>true]) !!}
        <newgroup selective="{{Auth::user()->hasRole('admin')}}"></newgroup>
        {!! Form::close() !!}
    </div>
@stop