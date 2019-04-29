@extends('mains.account_main')
@section('title','Informace o "'.$q->name.'" | ')
@section('content')
    <div>
        <div class="m-top-2 login_form_div col-md-6 mx-auto">
            <h1>{{$q->name}}</h1>
            <ul>
                <li>Časový limit: <b>{{$q->minutesAvailable}} minut</b></li>
                <li>Počet otázek: <b>{{$q->questions->count()}}</b></li>
                <li>Třída: <a href="{{route('group.group',["slug"=>$open->group->slug])}}">{{$open->group->name}}</a></li>
                <li>Kurz: <a href="{{route('course.course',["slug"=>$q->course->slug])}}">{{$q->course->name}}</a></li>
                @if(!empty($q->referencesModule))<li>Test pro modul: <a href="{{route("module.module",["slug"=>$q->course->slug,"order"=>$q->referencesModule->order])}}">{{$q->referencesModule->name}}</a></li>@endif
            </ul>
            <div>
                {!! Form::open(["route"=>["quiz.postInfoQuiz",$q->uuid,$open->id_qo]]) !!}
                @csrf
                @if($canAccess)
                <button>Spustit test</button>
                @else
                <div class="alert alert-danger col-12">
                    Tento test pro vás není přístupný!
                </div>
                @endif
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
