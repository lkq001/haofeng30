<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.meta')
@yield('css')
<body>
@include('admin.layouts.header')
@include('admin.layouts.aside')

<article class="page-container">
    <section class="Hui-article-box">
        @yield('content')
    </section>

</article>
@include('admin.layouts.footer')
@yield('javascript')
</body>
</html>