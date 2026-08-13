@extends('layouts.IranMarket')
@section('title', 'آموزش برنامه نویسی | طراحی سایت | سئو')
@section('meta', 'خدمات برنامه نویسی، طراحی سایت، میزبانی و سئو سایت. آموزش برنامه نویسی پایتون، php, javascript.')

@section('content')
    <!-- HERO SLIDER -->
    @if(isset($sliders) && count($sliders))
    <div class="md:w-[100%] mx-auto md:mt-5 md:block">
        <div dir="ltr" class="owl-carousel">
            @foreach($sliders as $slide)
            <div class="box-border">
                <a href="{{$slide->link}}"
                ><img class="rounded-md md:rounded-3xl md:px-2 box-border"
                      src="{{$slide->image}}" alt="{{$slide->name}}" /></a>
            </div>
            @endforeach

        </div>
    </div>
    @endif

    @if(isset($categories) && count($categories))
        <!-- GOOD CATEGORYS -->
        <div class="rounded-2xl py-6 shadow-xl my-10 bg-white">
            <div class="flex justify-between px-5 pb-5 md:px-10 items-center">
                <div class="border-b-2 border-red-500 pb-1">دسته بندی ها</div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-x-4 gap-y-4 md:gap-x-8 2xl:gap-x-10 px-3 md:px-8 lg:px-28">
                @foreach($categories as $category)
                    <a href="/shop/category/{{$category->slug}}" target="_blank"
                       class="flex justify-center items-center flex-col gap-y-3 hover:scale-105 transition">
                        <img src="{{$category->image}}" class="rounded-xl object-fit" alt="{{$category->name}}">
                        <div class="text-sm opacity-90 text-gray-900">{{$category->name}}</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif



    @if(isset($page_blocks) && count($page_blocks) > 0)
        @foreach($page_blocks as $page_block)
            @if(isset($page_block['boxes']) && count($page_block['boxes']))
                <div class="flex flex-wrap justify-center my-5 rounded-3xl py-3" style="background-color: {{$page_block['settings']['background_color']}}">
                    @if($page_block['settings']['show_name'])
                    <div class="w-full grid grid-cols-1 text-center mb-3 mt-5">
                        <h2 class="text-xl text-red-500">{{$page_block['settings']['name']}}</h2>
                    </div>
                    @endif
                    <div class="w-full grid grid-cols-{{$page_block['settings']['xs_columns']}}
                    sm:grid-cols-{{$page_block['settings']['sm_columns']}}
                      lg:grid-cols-{{$page_block['settings']['lg_columns']}}
                        md:grid-cols-{{$page_block['settings']['md_columns']}}
                        xl:grid-cols-{{$page_block['settings']['xl_columns']}}
                        gap-{{$page_block['settings']['gap']}}">
                        @foreach($page_block['boxes'] as $box)
                            <a href="{{$box->link}}" class="box-{{$box->position}}">
                                <div class="icon-box shadow-xl">
                                    <div class="icon-box-img text-center ">
                                        <img src="{{$box->image}}" alt="{{$box->name}}">
                                    </div>
                                    <div class="icon-box-name">
                                        <h4>{{$box->name}}</h4>
                                    </div>
                                    <div class="icon-box-content">
                                        {{$box->meta}}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                </div>
            @endif
            @foreach($page_block['sliders'] as $key => $product_slider)
                @if($key == 'amazing')
                    @include('components.home.amazing-slider', ['products' => $product_slider['products'], 'slider_name' => $product_slider['name'], 'link' => $product_slider['link'], 'bg_color' => $product_slider['bg_color'], 'text_color' => $product_slider['text_color']])
{{--                @elseif($key == 'featured')--}}
{{--                    @include('components.home.featured-products-slider', ['products' => $product_slider['products'], 'slider_name' => $product_slider['name'], 'link' => $product_slider['link'], 'bg_color' => $product_slider['bg_color'], 'text_color' => $product_slider['text_color']])--}}
                @elseif($key == 'limitted_offer')
                    @include('components.home.timer-slider', ['products' => $product_slider['products'], 'slider_name' => $product_slider['name'], 'link' => $product_slider['link'], 'bg_color' => $product_slider['bg_color'], 'text_color' => $product_slider['text_color']])
                @else
                    @include('components.home.products-slider', ['products' => $product_slider['products'], 'slider_name' => $product_slider['name'], 'link' => $product_slider['link'], 'bg_color' => $product_slider['bg_color'], 'text_color' => $product_slider['text_color']])
                @endif
            @endforeach
            @if(isset($page_block['banners']) && count($page_block['banners']))
                <div class="grid grid-cols-1 @if(count($page_block['banners']) > 1) sm:grid-cols-2 @endif  lg:grid-cols-{{count($page_block['banners'])}} gap-5">
                    @foreach($page_block['banners'] as $banner)
                    <div class="my-2">
                        <a href="{{$banner->link}}" class="banner-{{$banner->position}}">
                            <img class="rounded-xl w-full" src="{{$banner->image}}" alt="{{$banner->name}}">
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        @endforeach

    @endif


{{--    <!-- BLOG -->--}}
{{--    <div class="bg-white rounded-2xl py-8 shadow-xl my-10">--}}
{{--        <div class="flex justify-between px-5 md:px-10 items-center">--}}
{{--            <div class="text-red-500">آخرین مقالات</div>--}}
{{--            <a href="/blog"><div class="transition px-4 py-2 rounded-xl flex justify-center items-center text-red-500 hover:text-red-600">مطالب بیشتر<img class="w-4" src="/template/assets/image/arrow-left.png" alt=""></div></a>--}}
{{--        </div>--}}
{{--        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 px-10 gap-5">--}}
{{--            @foreach($posts as $post)--}}
{{--            <a href="/blog/article/{{$post->slug}}"--}}
{{--               target="_blank"--}}
{{--               class="shadow-lg rounded-3xl p-4 hover:text-red-600 transition">--}}
{{--                <div>--}}
{{--                    <img class="rounded-xl hover:scale-105 home-posts-img transition"--}}
{{--                         src="{{$post->image}}" alt="{{$post->name}}">--}}
{{--                </div>--}}
{{--                <div class="text-sm opacity-90 py-5">--}}
{{--                    {{$post->name}}--}}
{{--                </div>--}}
{{--            </a>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
@section('script')

    <script src="/template/assets/js/owl.carousel.min.js"></script>
    <script src="/template/assets/js/sliderHero.js"></script>



@endsection
