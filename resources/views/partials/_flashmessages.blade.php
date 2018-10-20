<div class="flash-message position-absolute col-12" style="padding:0;border-radius:0">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has($msg))
            <div class="alert fade text-center show alert-{{ $msg }}">
                <span>{{ Session::get($msg) }}</span>
            </div>
        @endif
    @endforeach
</div>
<script>
    setTimeout(function(){
        $('.alert').fadeOut(400, function () {
            $('.alert').remove();
        });
    },2000);
</script>