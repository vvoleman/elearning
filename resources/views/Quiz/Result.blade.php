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
                    <h6>Odevzdáno: {{date("d. m. Y H:i",$result->started_at->timestamp)}}</h6>
                    <h6>Potřebná doba: {{((floor($time/60) < 10) ? "0" :"").floor($time/60)}}:{{((floor($time%60) < 10) ? "0" :"").floor($time%60)}}</h6>
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
