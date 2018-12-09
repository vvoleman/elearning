<html>
@include('../partials/_head')
<body>
@include('../partials/_nav-account')
@include('../partials/_flashmessages')
<div id="app" v-cloak>
    @yield('content')
</div>
@include('../partials/_basicjs')
@yield('customjs')
</body>
@include('../partials/_footer-public')
</html>