@extends('mains.account_main')
@section('title','Seznam výsledků | ')
@section('content')
    <div class="col-md-10 mx-auto m-top-2">
        <h1 class="text-center">Seznam výsledků</h1>
        <hr>
        <table class="table col-md-10 mx-auto table-striped" style="overflow:auto">
            <thead class="thead-dark">
                <tr>
                    <th>Test</th>
                    <th>Kurz</th>
                    <th>Datum odevzdání</th>
                    <th>Procenta</th>
                    <th>Odkaz</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $r)
                    <tr>
                        <td>{{$r->quiz->quiz->name}}</td>
                        <td>{{$r->quiz->quiz->course->name}}</td>
                        <td>{{$r->submitted_at->format('d. m. Y H:i')}}</td>
                        <td>{{$r->percentage}}%</td>
                        <td><a href="{{route('quiz.getQuizResult',["open_id"=>$r->open_id])}}">Přejít</a></td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>
@stop
