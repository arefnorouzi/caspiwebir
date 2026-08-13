@extends('layouts.Main')
@section('title', 'طراحی سایت | میزبانی وب | طراحی اتوماسیون')
@section('meta', 'مارلیک افزار کاسپین ارایه دهنده خدمات طراحی و اجرای نرم افزارهای وب و موبایل، طراحی اتوماسیون، طراحی و اجرای پلتفرم های WEB3.')
@section('content')

    @include('components.home.header')

    @include('components.home.benefit')

    @include('components.home.best-choise')

   @include('components.home.pricing')


{{--   @include('components.home.reviews')--}}


    @include('components.home.faq')


    @include('components.home.blog', ['posts' => $posts])
@endsection
