                                                                                                                                                                                                                                                 @extends('mains/account_main')
@section('title','Výsledky testu | ')
@section('content')
    <div>
        <openresults quiz="{{$quiz}}" quests="{{json_encode($questions)}}" res="{{json_encode($results)}}" act="{{$act}}"></openresults>
    </div>
@stop
