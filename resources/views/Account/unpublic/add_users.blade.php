@extends('mains/account_main')
@section('title','Přidání studentů |')
@section('content')
    <div class="container col-lg-4 col-md-6 m-top-2 mx-auto">
        <a href="{{route('admin.accounts')}}" class="no-a">< Zpět</a>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    <li>Pole obsahují nepodporované znaky!</li>
                </ul>
            </div>
        @endif
        <div>
            {!! Form::open(["route"=>"account.addSingleStudent"]) !!}
            <h3>
               Přidání pouze jednoho  @if(!$isAdmin)studenta: @else uživatele: @endif
            </h3>
                <hr>
            <div class="login_form_div">
                <div class="form-group">
                    <label class="label">Jméno</label>
                    <div class="d-flex align-items-center">
                        <input type="text" name="student_firstname" class="form-control">
                        <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">Příjmení</label>
                    <div class="d-flex align-items-center">
                        <input type="text" name="student_surname" class="form-control">
                        <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">Email</label>
                    <div class="d-flex align-items-center">
                        <input type="text" name="student_email" class="form-control">
                        <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
                    </div>
                </div>
                @if($isAdmin)
                    <div class="form-group">
                        <label class="label">Role</label>
                        {{Form::select('student_role', $roles->pluck("name", 'id_r'),null,["class"=>"form-control"])}}
                    </div>
                @endif
                <button class="btn btn-block btn-success">Přidat</button>
            </div>
            {!! Form::close() !!}
        </div>
        <div>
            {!! Form::open(["route"=>"account.addStudents","files"=>true]) !!}
                <h3>Přidání více @if(!$isAdmin)studentů: @else uživatelů: @endif</h3>
                <h5><small>Používejte .csv soubory se strukturou: <span class="badge badge-dark">Jméno;Příjmení;Email{{($isAdmin) ? ";Role" : ""}} </span></small></h5>
                <hr>
                <div class="login_form_div">
                    <div class="form-group">
                        <label class="label">Soubor</label>
                        <div class="d-flex justify-content-between">
                            <input type="file" accept=".csv" name="students_file">
                            <i data-toggle="tooltip" data-placement="right" title="Tato položka je povinná" class="fas fa-circle"></i>
                        </div>
                    </div>
                    <button class="btn btn-block btn-success">Přidat</button>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
@stop
@section('customjs')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    })
    $("form").first().validate({
        rules:{
            student_email:{
                required:true,
                email:true
            },
            student_firstname:{
                minlength:2,
                maxlength:32,
                required:true
            },
            student_surname:{
                minlength:2,
                maxlength:40,
                required:true
            }
        },
        messages:{
            student_email: {
                required:"Email je požadován pro registraci studenta!",
                email:"Toto není validní email!"
            },
            student_firstname: {
                required:"Jméno je požadováno pro registraci studenta!",
                min:"Jméno je příliš krátké!",
                max:"Jméno je příliš dlouhé!"
            },
            student_surname: {
                required:"Příjmení je požadováno pro registraci studenta!",
                min:"Příjmení je příliš krátké!",
                max:"Příjmení je příliš dlouhé!"
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
    $("form").last().validate({
        rules:{
            students_file:{
                required: true,
                extension: "xls|csv"
            }
        },
        messages:{
            students_file: {
                required:"Žádný soubor není obsažen!",
                extension:"Nepodporovaný formát souboru!"
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
    jQuery.validator.addMethod("extension", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, "Please enter a value with a valid extension.");
</script>
@endsection