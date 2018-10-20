@extends('../mains/main')
@section('title','Home |')
@section('content')
<div style="height:300px;background:#2B3038;color:white;" class="col-12 d-flex justify-content-center align-items-center">
    <div class="big_text">
        <span>Projekt</span><span><b id="blink">|</b></span>
    </div>
</div>
@endsection
@section('customjs')
    <script>
        setInterval(function(){
            var res = "hidden";
            if($("#blink").css("visibility") == "hidden"){
                res = "visible";
            }
            $("#blink").css("visibility",res);
        },500);
    </script>
@endsection