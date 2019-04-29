@extends('mains.account_main')
@section('title','Výsledek nenalezen | ')
@section('content')
    <div class="m-top-2 col-md-8 mx-auto">
        <h1 class="text-center">@if($user->id_u == Auth::user()->id_u) Tento test jste nevyplnil @else Test nebyl uživatelem vyplněn @endif</h1>
    </div>
@stop
