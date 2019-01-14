@extends('../mains/main')
@section('title','Login |')
@section('content')
{!! Form::open(['route'=>'login.verifyLogin'],['id'=>"test"]) !!}
<div class="col-md-6 col-lg-3 mx-auto login_form_div m-top-2">
    <h3>Přihlášení</h3>
    <div class="m-top">
        <div class="form-group">
            <label>Email:</label>
            <div class="d-flex align-items-center">
                <input type="email" name="email" class="form-control">
                <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
            </div>
        </div>
        <div class="form-group">
            <label>Heslo:</label>
            <div class="d-flex align-items-center">
                <input type="password" name="password" class="form-control">
                <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
            </div>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" value="1" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember">Zapamatovat</label>
        </div>
        <button class="btn btn-block btn-success">Přihlásit</button>
        <hr>
        <div>
            <a href="#">Zapomněli jste heslo?</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
@section('customjs')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $("form").validate({
        rules:{
            email:{
                required:true,
                email:true
            },
            password:{
                required:true
            }
        },
        messages:{
            email: {
                required:"Email je požadován pro úspěšné přihlášení!",
                email:"Toto není validní email!"
            },
            password: {
                required:"Heslo je požadováno pro úspěšné přihlášení!"
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