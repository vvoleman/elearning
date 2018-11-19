@extends('mains/account_main')
@section('title','Nastavení účtu |')
@section('content')
    <link rel="stylesheet" href="css/animations.css">
    <div class="m-top container" id="app" v-cloak>
        <div class="col-md-8 mx-auto text-center dash-head">
            <h1>Nastavení</h1>
            <hr>
        </div>
        <tabs class="settings">
            <div class="tab_item tab_active col-md-8 mx-auto">
                <h3 class="tab_name">Změna emailu</h3>
                {!! Form::open(["route"=>"account.settings"]) !!}
                <emailver em_name="email" em_addr="{{Auth::user()->email}}"></emailver>
                {!! Form::close() !!}
            </div>
            <div class="tab_item col-md-8 mx-auto">
                <h3 class="tab_name">Změna hesla</h3>
            </div>
        </tabs>
    </div>
    <script type="text/javascript" src="js/app.js"></script>
    <script src="js/tabs.js"></script>
@stop