@extends('mains.account_main')
@section('title',$c->name." | ")
@section('content')
    <div class="m-top-2">
        <div class="col-md-8 mx-auto">
            <div>
                <h1 class="text-center">{{$c->name}}</h1>
            </div>
            <div class="col-12 mx-auto m-top-2 d-md-flex justify-content-around align-items-start">
                <div class="d-flex">
                    <h4>Lektoři:</h4>
                    <ul>
                        @foreach($c->owners as $o)
                            <a href="{{route('messages.replies',["id"=>$o->id_u])}}"><li>{{($o->id_u != Auth::user()->id_u) ? $o->getFullname() : "Vy"}}</li></a>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <h4>Založeno: </h4><span style="padding-left:5px">{{\Carbon\Carbon::parse($c->created_at)->format('d.m.Y')}}</span>
                </div>

            </div>
            <hr>
                <p>{{$c->desc}}</p>
            <hr>
            @if(Auth::user()->role->name == "admin")
            @endif
        </div>
        <div>
            <div class="d-flex justify-content-end mx-auto col-md-8">
                <i class="fas fa-cog" style="font-size:20px"></i>
            </div>
            <hideable def_show="true">
                <span slot="head-text">Moduly</span>
                <div slot="body">
                    baf
                </div>
            </hideable>
        </div>
    </div>
@stop
@section('customjs')
@stop