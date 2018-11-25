@extends('mains/account_main')
@section('title','Dashboard |')
@section('content')
    <div class="dashboard m-top">
        <div class="col-md-8 mx-auto text-center dash-head">
            <h1>Úvodní obrazovka</h1>
            <hr>
            <span>{{Auth::user()->getFullname()}}, {{ucfirst(__('roles.'.Auth::user()->role->name))}}</span>
        </div>
        <div class=" d-flex mx-auto justify-content-center col-md-8 col-sm-10 dash-shorts">
            <div class="short-block col-md-3">
                <i class="fas fa-tasks"></i>
                <div class="circle">5</div>
                Aktivní úkoly
            </div>
            <div class="short-block col-md-3">
                <i class="fas fa-envelope"></i>
                <div class="circle">5</div>
                Nové zprávy
            </div>
            <div class="short-block col-md-3">
                <i class="fas fa-bell"></i>
                <div class="circle">5</div>
                Nové upozornění
            </div>
        </div>
        <
    </div>
@stop