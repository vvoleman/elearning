<div class="flash-message position-absolute col-12" style="padding:0;border-radius:0;z-index:999">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has($msg))
            <alert type="{{$msg}}" msg="{{Session::get($msg)}}" count="5"></alert>
        @endif
    @endforeach
</div>