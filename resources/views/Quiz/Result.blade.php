@extends('mains.account_main')
@section('title','Výsledek testu" | ')
@section('content')
    <div class="col-md-10 mx-auto m-top-2">
        <a href="{{route('course.course',["slug"=>$o->quiz->course->slug])}}" class="no-a d-flex align-items-center"><i class="fas fa-chevron-left"></i>
            Kurz
        </a>
        <div>
            <h1 class="text-center">{{$o->quiz->name}}</h1>
            <hr>
            <div class="d-md-flex justify-content-between">
                <div>
                    <h6>Třída: {{$o->group->name}}</h6>
                    <h6>Odevzdáno: {{$result->started_at}}</h6>
                    <h6>Potřebná doba: {{$result->submitted_at->diffInMinutes($result->started_at)}} minut</h6>
                </div>
                <div class="d-flex align-items-end justify-content-start">
                    <div class="result_perc align-items-end d-flex">
                        <div class="perc_cont" style="height:{{$result->percentage}}%;">

                        </div>
                    </div>
                    <div>
                        <h6>Body: {{$result->points}}/{{$o->quiz->maxPoints()}}</h6>
                        <h6>Úspěšnost: {{$result->percentage}}%</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
