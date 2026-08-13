<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | مارلیک افزار</title>
    <meta name="description" content="@yield('meta')">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="@yield('author')">
    <!-- CSS -->
    <link rel="stylesheet" href="/theme/css/tailwind.css">
    <link rel="stylesheet" href="/theme/css/style.css">
    <link rel="stylesheet" href="/theme/tailwind/tailwind.css">
    <link rel="stylesheet" href="/theme/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/theme/css/owl.theme.default.min.css">

    <style>
        .services-icon{
            width: 120px;
            height: 120px;
        }
    </style>

    @yield('page_meta')

</head>



<body class="bg-[#FAFAFA]">

<header class="py-2 lg:py-5 sticky top-0 bg-[#FAFAFA] shadow z-100">
    @include('layouts.Main.Header')
</header>



<!-- MobileMenu -->
@include('layouts.Main.MobileMenu')

<main>

    @yield('content')

</main>



<footer class="bg-gradient-to-r from-[#fed7ce] to-[#fff1e6] pt-10 pb-5 md:pt-20 md:pb-8">
    @include('layouts.Main.Footer')
</footer>


<!-- Scripts -->

<script src="/theme/script/jquery-3.7.1.min.js"></script>
<script src="/theme/script/owl.carousel.min.js"></script>
<script src="/theme/script/script.js"></script>
</body>

</html>
