<html>
@include('../partials/_head')
<body>
<div id="app">
    @include('../partials/_nav-public')
    @include('../partials/_flashmessages')
    @yield('content')
</div>
@include('../partials/_basicjs')
@yield('customjs')
</body>
@include('../partials/_footer-public')
</html>