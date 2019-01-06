@extends('mains/account_main')
@section('title','Nastavení účtu |')
@section('content')
    <link rel="stylesheet" href="css/animations.css">
    <div class="m-top container" v-cloak>

        <div class="col-md-8 mx-auto text-center dash-head">
            <h1>Nastavení</h1>
            <hr>
        </div>
        <tabs class="settings col-md-8 mx-auto">
            <div class="tab_item tab_active mx-auto">
                <h3 class="tab_name">Změna emailu</h3>
                {!! Form::open(["route"=>"account.settings"]) !!}
                <emailver em_name="email" em_addr="{{Auth::user()->email}}"></emailver>
                {!! Form::close() !!}
            </div>
            <div class="tab_item mx-auto">
                <h3 class="tab_name">Změna hesla</h3>
                {!! Form::open(["route"=>"account.settings"]) !!}
                    <div class="m-top col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="label">Stávající heslo</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="label">Nové heslo</label>
                            <input type="password" name="newpass" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="label">Nové heslo znovu</label>
                            <input type="password" name="newpass2" class="form-control">
                        </div>
                        <button class="btn btn-gray btn-block">Změnit</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </tabs>
    </div>
@stop
@section('customjs')
    <script src="js/tabs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
    <script>
        $("form").eq(1).validate({
            rules:{
                password:{
                    required:true
                },
                newpass:{
                    required:true,
                    minlength:8,
                    maxlength:32
                },
                newpass2:{
                    required:true,
                    equalTo: "[name=newpass]"
                }
            },
            errorPlacement: function(error, element) {
                var el = $(element).parent().children(".label");
                $(el).removeClass('correct');
                $(el).addClass('bad');
            },
            success: function(label,element) {
                var el = $(element).parent().children(".label");
                $(el).removeClass('bad');
                $(el).addClass('correct');
            }
        });
    </script>
@stop