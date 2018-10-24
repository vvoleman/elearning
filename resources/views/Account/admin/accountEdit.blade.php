@extends('mains.account_main')
@section('title','Úprava účtu #'.$u->id_u.' |')
@section('content')
    <div>
    {!! Form::model($u->toArray(), ['route' => ['admin.saveEditAccount']]) !!}
        <div class="m-top col-lg-4 col-md-6 mx-auto login_form_div">
            <h1>Úprava účtu #{{$u->id_u}}</h1>
            {{Form::hidden('id_u')}}
            <div class="form-group">
                <label class="">Jméno</label>
                {{Form::text('firstname',null,["class"=>"form-control"])}}
                <!--<div class="bg-light form-control" data-toggle="tooltip" data-placement="right" title="Tuto položku není možno upravit.">{{$u->firstname}}</div>!-->
            </div>
            <div class="form-group">
                {{Form::label('surname','Příjmení')}}
                {{Form::text('surname',null,["class"=>"form-control"])}}
                <!--<div class="bg-light form-control" data-toggle="tooltip" data-placement="right" title="Tuto položku není možno upravit.">{{$u->surname}}</div>!-->
            </div>
            <div class="form-group">
                {{Form::label('email','Email')}}
                {{Form::email('email',null,["class"=>"form-control"])}}
                <!--<div class="bg-light form-control" data-toggle="tooltip" data-placement="right" title="Tuto položku není možno upravit.">{{$u->email}}</div>!-->
            </div>
            <div class="form-group">
                {{Form::label('role','Role')}}
                {{Form::select('role_id', $roles->pluck("name", 'id_r'), $u->role_id,["class"=>"form-control"])}}
            </div>
            <div class="form-group">
                <label class="">Zablokovat</label>
                {{Form::checkbox('deactivate','true',!empty($u->deact_date),["class"=>""])}}
                {{Form::textarea('deact_reason',null,["class"=>"form-control","placeholder"=>"Důvod"])}}
            </div>
            <input type="submit" class="btn btn-block btn-success">
        </div>
    {!! Form::close() !!}
    </div>
@stop
@section('customjs')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        if(!$("input[name=deactivate]").prop('checked')){
            $("textarea").toggle();
        }
        $("input[name=deactivate]").on('change',function(){
            $("textarea").toggle();
        });
    </script>
@stop