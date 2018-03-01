<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.meta')
@yield('css')
<body>
@include('admin.layouts.header')
@include('admin.layouts.aside')

<article class="page-container">
    @yield('content')
</article>
@include('admin.layouts.footer')
@yield('javascript')
</body>
</html>