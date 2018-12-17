<html>
@include('../partials/_head')
<body>
@include('../partials/_nav-account')
@include('../partials/_flashmessages')
<div id="app">
    <div class="editc">
        @include('../partials/_editcourse_sidebar')
        <div class="col-md-9 col-lg-10 offset-md-3 offset-lg-2 workplace">
            @yield('content')
        </div>
    </div>
</div>
@include('../partials/_basicjs')
@yield('customjs')
</body>
</html>