@extends('../mains/main')
@section('title','Home |')
@section('content')
    <div>
        <div style="height:300px;background:#2B3038;color:white;" class="col-12 d-flex justify-content-center align-items-center">
            <div class="big_text">
                <span>Projekt</span><span><b id="blink">|</b></span>
            </div>
        </div>
        <div class="d-md-flex justify-content-around col-10 mx-auto m-top-3 align-content-stretch">
            <div class="col-md-4">
                <div class="shadow">
                    <div class="infobox_head"><span>O projektu</span></div>
                    <div class="infobox_body">
                        <p>
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Fusce consectetuer risus a nunc. Aenean placerat.
                            Praesent dapibus. Fusce consectetuer risus a nunc. In enim a arcu imperdiet malesuada. Duis condimentum augue id
                            magna semper rutrum. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam. Etiam ligula pede, sagittis quis,
                            interdum ultricies, scelerisque eu. Aliquam id dolor. Morbi imperdiet, mauris ac auctor dictum, nisl ligula egestas nulla,
                            et sollicitudin sem purus in lacus. In convallis. Morbi imperdiet, mauris ac auctor dictum, nisl ligula egestas nulla,
                            et sollicitudin sem purus in lacus. In convallis.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="shadow">
                    <div class="infobox_head col-12"><span>V číslech</span></div>
                    <div class="infobox_body d-flex justify-content-between flex-wrap">
                        <div class="col-md-5 mx-auto">
                            <div class="d-flex align-items-center infobox_stat">
                                <i class="fas fa-chalkboard"></i>
                                <span>{{$courses}}</span>
                            </div>
                        </div>
                        <div class="col-md-5 mx-auto">
                            <div class="d-flex align-items-center infobox_stat">
                                <i class="fas fa-book"></i>
                                <span>{{$modules}}</span>
                            </div>
                        </div>
                        <div class="col-md-5 mx-auto">
                            <div class="d-flex align-items-center infobox_stat">
                                <i class="fas fa-question"></i>
                                <span>{{$quizes}}</span>
                            </div>
                        </div>
                        <div class="col-md-5 mx-auto">
                            <div class="d-flex align-items-center infobox_stat">
                                <i class="fas fa-users"></i>
                                <span>{{$users}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="shadow">
                    <div class="infobox_head"><span>Kontaktujte nás</span></div>
                    <div class="infobox_body">
                        <div class="d-flex align-items-center infobox_stat">
                            <i class="fas fa-at"></i>
                            <span>info@projekt.cz</span>
                        </div>
                        <div class="d-flex align-items-center infobox_stat">
                            <i class="fas fa-phone-alt"></i>
                            <span>123 456 789</span>
                        </div>
                    </div>
                </div>
            </div>
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
