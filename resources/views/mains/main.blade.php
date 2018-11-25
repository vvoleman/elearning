<html>
@include('../partials/_head')
<body>
@include('../partials/_nav-public')
@include('../partials/_flashmessages')
<div id="app">
@yield('content')
</div>
@include('../partials/_basicjs')
@yield('customjs')
</body>
@include('../partials/_footer-public')
</html>