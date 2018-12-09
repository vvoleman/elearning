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
                    Aktivní úkoly
                </div>
                <div class="short-block col-md-3">
                    <a href="{{route('messages.index')}}">
                        <i class="fas fa-envelope"></i>
                        <div class="circle">5</div>
                        Nové zprávy
                    </a>
                </div>
                <div class="short-block col-md-3">
                    <i class="fas fa-bell"></i>
                    <div class="circle">5</div>
                    Nové upozornění
                </div>
            </div>
        </div>
        <div style="margin-top:50px;">
            <hideable>
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
                <div slot="body" class="d-md-flex justify-content-between col-md-12" style="flex-wrap: wrap;">
                    <div class="col-md-4 wrap">
                        <div class="course_shortcut ">
                            <a href="{{route("course.course",["id"=>1])}}">
                            <h5>Český jazyk 3.ročník</h5>
                            </a>
                        </div>

                    </div>
                    <div class="col-md-4 wrap">
                        <div class="course_shortcut ">
                            <h5>ČJ3R</h5>
                        </div>
                    </div>
                    <div class="col-md-4 wrap">
                        <div class="course_shortcut ">
                            <h5>ČJ3R</h5>
                        </div>
                    </div>
                    <div class="col-md-4 wrap">
                        <div class="course_shortcut ">
                            <h5>ČJ3R</h5>
                        </div>
                    </div>
                    <div class="col-md-4 wrap">
                        <div class="course_shortcut ">
                            <h5>ČJ3R</h5>
                        </div>
                    </div>
                    <div class="col-md-4 wrap">
                        <div class="course_shortcut ">
                            <h5>ČJ3R</h5>
                        </div>
                    </div>
                </div>
            </hideable>
        </div>
    </div>
@stop