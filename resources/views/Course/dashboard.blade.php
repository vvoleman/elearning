@extends('mains.account_main')
@section('title','Dashboard |')
@section('content')
    <div class="dashboard m-top">
        <div>
            <div class="col-md-8 mx-auto text-center dash-head">
                <h1>Úvodní obrazovka</h1>
                <hr>
                <span>{{Auth::user()->getFullname()}}, {{ucfirst(__('roles.'.Auth::user()->role->name))}}</span>
            </div>
            <div class=" d-flex mx-auto justify-content-center col-md-8 col-sm-10 dash-shorts no-a">
                <div class="short-block col-md-3">
                    <i class="fas fa-tasks"></i>
                    <div class="circle">5</div>
                    Úkoly
                </div>
                <div class="short-block col-md-3">
                    <a href="{{route('messages.index')}}">
                        <i class="fas fa-envelope"></i>
                        @if($msgs_count>0)
                        <div class="circle">{{$msgs_count}}</div>
                        @endif
                        Zprávy
                    </a>
                </div>
                <div class="short-block col-md-3">
                    <i class="fas fa-bell"></i>
                    <div class="circle">5</div>
                    Upozornění
                </div>
            </div>
        </div>
        <div style="margin-top:50px;">
            <hideable def_show="true"> <!-- Kurzy !-->
                <span slot="head-text">
                    @switch(Auth::user()->role->name)
                        @case("teacher")
                        Vaše kurzy
                            @break
                        @case("user")
                        Aktivní kurzy
                        @break
                        @case("admin")
                        Kurzy
                        @break
                    @endswitch
                    <a href="{{route('course.newCourse')}}" title="Vytvořit nový kurz" style="color:inherit"><i class="plusbtn fas fa-plus"></i></a>
                </span>
                <div slot="body" class="d-md-flex col-md-12 box_body" style="flex-wrap: wrap;">
                    @foreach($c as $course)
                        <div class="col-md-4 st">
                            <a class="no-a" href="{{route("course.course",["id"=>$course->slug])}}">
                                <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                    <span>{{$course->name}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </hideable>
            <hideable def_show="true">
                <span slot="head-text">
                    @switch(Auth::user()->role->name)
                        @case("teacher")
                        Vaše třídy
                        @break
                        @case("user")
                        Ve třídách
                        @break
                        @case("admin")
                        Třídy
                        @break
                    @endswitch
                </span>
                <div slot="body" class="d-md-flex col-md-12">
                    @foreach($c->groups as $g)
                    <div class="col-md-4 st">
                        <a class="no-a" href="">
                            <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                <span>{{$g->name}}</span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </hideable>
        </div>
    </div>
@stop