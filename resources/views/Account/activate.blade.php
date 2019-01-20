@extends('mains.main')
@section('title','Aktivace účtu |')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    {{$e}}
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-lg-4 col-md-6 mx-auto">
        <h3>Aktivace účtu</h3>
        <div class="login_form_div m-top">
        {!! Form::open(["route"=>"account.saveActivation"]) !!}
            <input type="hidden" name="reg_token" value="{{$user->reg_token}}">
            <div class="form-group">
                <label class="label">Jméno</label>
                <span class="low_opacity form-control">{{$user->firstname}}</span>
            </div>
            <div class="form-group">
                <label class="label">Příjmení</label>
                <span class="low_opacity form-control">{{$user->surname}}</span>
            </div>
            <div class="form-group">
                <label class="label">Email</label>
                <span class="low_opacity form-control">{{$user->email}}</span>
            </div>
            <div class="form-group">
                <label class="label">Heslo</label>
                <div class="d-flex align-items-center">
                    <input class="form-control" type="password" name="new_pass">
                    <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="label">Heslo znovu:</label>
                <div class="d-flex align-items-center">
                    <input id="password2" class="form-control" type="password" name="new_pass2">
                    <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
                </div>
            </div>
            <button class="btn btn-block btn-success">Aktivovat</button>
        {!! Form::close() !!}
     </div>
    </div>
@stop
@section('customjs')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $("form").validate({
            rules:{
                new_pass:{
                    minlength:8,
                    maxlength:32,
                    required:true
                },
                new_pass2:{
                    equalTo:"[name=new_pass]"
                }
            },
            messages:{
                new_pass: {
                    required:"Zadejte prosím heslo!",
                    minlength: "Heslo musí mít minimálně 8 znaky!",
                    maxlength: "Heslo musí mít maximálně 32 znaků!"
                },
                new_pass2:{
                    equalTo: "Hesla se musí shodovat!"
                }
            },
            errorPlacement: function(error, element) {
                var el = $(element).parent().children("i");
                $(el).removeClass('fa-check-circle');
                $(el).removeClass('fa-circle');
                $(el).addClass('fa-exclamation-circle');
                $(el).attr('data-original-title', error[0].innerText).tooltip('show');
                setTimeout(function(){
                    $(el).tooltip('hide');
                },1600);
            },
            success: function(label,element) {
                var el = $(element).parent().children("i");
                if($(el).css('visibility') == "hidden") {
                    $(el).css('visibility','visible');
                }
                $(el).removeClass('fa-exclamation-circle');
                $(el).removeClass('fa-circle');
                (el).addClass('fa-check-circle');
            }
        });
    </script>
@endsection