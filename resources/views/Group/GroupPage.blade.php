@extends('mains.account_main')
@section('title', $g->name.' | ')
@section('content')
    <div class="m-top-2">
        <div class="col-md-8 mx-auto">
            <div>
                <h1 class="text-center">{{$g->name}}</h1>
            </div>
            <div class="col-12 mx-auto m-top-2 d-md-flex justify-content-around align-items-start">
                <div class="d-flex">
                    <h4>Správce třídy:</h4>
                    <ul>
                        <span>{{(Auth::user()->id_u == $g->owner->id_u) ? "Vy" : $g->owner->getFullname()}}</span>
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <h4>Založeno: </h4><span style="padding-left:5px">{{\Carbon\Carbon::parse($g->created_at)->format('d.m.Y')}}</span>
                </div>

            </div>
            <hr>
        </div>
        <div>

            <hideable def_show="true">
                <div slot="head-text">
                    <span>Studenti</span>
                    @if(Auth::user()->ownGroup($g->slug))
                    <a href="{{route('group.editStudent',$g->slug)}}"><i style="font-size:18px;color:#ccc" class="fas fa-cog"></i></a>
                    @endif
                </div>
                <div slot="body">
                    <div class="d-md-flex flex-wrap">
                        @foreach($g->students as $s)
                            <div class="col-md-4 st">
                                <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                    <span>{{$s->getFullname()}}</span>
                                    <a href="{{route('messages.replies',["id"=>$s->id_u])}}" class="no-a">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </hideable>
            <hideable def_show="true">
                <span slot="head-text">V kurzech</span>
                <div slot="body">
                    <div class="d-md-flex flex-wrap">
                        @foreach($g->courses as $c)
                            <div class="col-md-4 st">
                                <a href="{{route('course.course',$c->slug)}}" class="no-a">
                                    <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                        <span>{{$c->name}}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </hideable>
        </div>
    </div>
@stop