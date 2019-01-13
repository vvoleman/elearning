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
                        <div class="d-md-flex flex-wrap">
                            @foreach($c->owners as $o)
                                    <div class="col-md-12 student_box d-flex align-items-center justify-content-between" style="margin-bottom:10px">
                                        <span>{{($o->id_u != Auth::user()->id_u) ? $o->getFullname() : "Vy"}}</span>
                                        @if($o->id_u != Auth::user()->id_u)
                                            <a class="no-a" href="{{route('messages.replies',["id"=>$o->id_u])}}"><i class="fas fa-envelope"></i></a>
                                        @endif
                                    </div>
                            @endforeach
                        </div>
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <h4>Založeno: </h4><span style="padding-left:5px">{{\Carbon\Carbon::parse($c->created_at)->format('d.m.Y')}}</span>
                </div>
            </div>
            <hr>
                <p>{{$c->desc}}</p>
            <hr>
        </div>
        <div>
            @if(Auth::user()->ownCourse($c->slug))
            <div class="d-flex justify-content-end mx-auto col-md-8">
                <a href="{{route('course.editCourse',[$c->slug])}}" class="no-a">
                    <i class="fas fa-cog" style="font-size:20px"></i>
                </a>
            </div>
            <hideable def_show="true">
                <span slot="head-text">Třídy</span>
                <div slot="body" class="d-md-flex col-md-12 flex-wrap">
                    @foreach($c->groups as $g)
                        <div class="col-md-4 st">
                            <a class="no-a" href="{{route('group.group',$g->slug)}}">
                                <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                    <span>{{$g->name}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </hideable>
            @endif
            <hideable def_show="true">
                <span slot="head-text">Moduly</span>
                <div slot="body"  class="d-md-flex col-md-12 flex-wrap">
                    @foreach($c->modules as $m)
                        <div class="col-md-4 st">
                            <a class="no-a" href="{{route('module.module',["slug"=>$c->slug,"order"=>$m->order])}}">
                                <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                    <span>{{$m->order}}. {{$m->name}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </hideable>
        </div>
    </div>
@stop
@section('customjs')
@stop