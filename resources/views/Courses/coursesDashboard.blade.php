@extends('mains/account_main')
@section('title','Kurzy |')
@section('content')
    <div class="m-top">
        <div>
            <div>
                <div class="text-center">
                    <h1>
                        @switch(Auth::user()->role->name)
                            @case("student")
                                Dostupné
                            @break
                            @case("teacher")
                                Vlastněné
                            @break
                            @default
                                @break
                        @endswitch
                        Kurzy
                    </h1>
                </div>
                @if(Auth::user()->role->name != "student")
                <div class="col-md-6 mx-auto">
                    <button class="btn btn-gray">Nový kurz</button>
                </div>
                @endif
            </div>
            <div>
                <hideable>
                    <span slot="head-text">Český jazyk 3. ročník</span>
                    <div slot="body">

                    </div>
                </hideable>
            </div>
        </div>
        <div>

        </div>
    </div>
@stop