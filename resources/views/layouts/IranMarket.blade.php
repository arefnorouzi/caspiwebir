<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#b91c1c"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="/template/assets/css/style.css" />
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <title>@yield('title') | {{site()->name}}</title>
    <meta name="description" content="@yield('meta')">
    @yield('page_meta')

    <style>
        .language-markup {
            direction: ltr;
            text-align: left;
            background-color: #e9e9e9;
            padding: .5rem;
            border-radius: .5rem;
        }
        .banner-1 img {
            height: 220px;
        }
        .pagination button.active {
            background: #333;
            color: #fff;
        }
        .custom-pagination button {
            border: 1px solid #ddd;
            border-radius: .3rem;
            padding: .5rem .8rem;
        }
        .product-image{max-height: 220px; width: 100%; object-fit: contain}

        .related-product-slide{
            height: auto;
            min-height: 230px;
            min-width: 300px;
        }
        .payment-method-icon{
            width: 50px;
            height: 50px;
        }
        .header-slider-image{
            width: 200px;
            height: 200px;
            align-content: center;
            align-items: center;
        }
        @media only screen and (max-width: 920px) {
            .payment-method-icon{
                width: 30px;
                height: 30px;
            }
            .payment-method-name{
                font-size: .7rem;
            }
            .header-slider-image{
                display: none;
            }
            .product-image{
                width: 100px;
                height: 200px;
            }
        }



        .search-results{
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin: 4px 0 0 0;
            padding: 0;
            list-style: none;
            border: 1px solid #ddd;
            background: #fff;
            max-height: 320px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            display: none; /* پیش‌فرض مخفی */
        }
        .search-results li{
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
        }
        .search-results li:last-child{ border-bottom: none; }
        .search-results li:hover,
        .search-results li.active{
            background: #f5f7fa;
        }
        .search-results .meta{
            font-size: 12px;
            color: #666;
        }

        .related-posts-img{width: 100px; height: 70px;}

        .posts-img{width: 200px; height: 150px;}
        #post-content p{
            font-family: VAZIR, Arial, sans-serif !important;
            line-height: 1.7rem;
            font-size: 1rem;
        }
        #post-content span{
            font-family: VAZIR, Arial, sans-serif !important;
            line-height: 1.7rem;
            font-size: .9rem;
        }
        #post-content strong{
            font-family: VAZIR, Arial, sans-serif !important;
        }
        #post-content h1{
            font-family: VAZIR, Arial, sans-serif !important;
            margin-top: 2rem;
        }

        #post-content h2{
            font-family: VAZIR, Arial, sans-serif !important;
            margin-top: 2rem;
        }

        #post-content h3{
            font-family: VAZIR, Arial, sans-serif !important;
            margin-top: 2rem;
        }

        #post-content h4{
            font-family: VAZIR, Arial, sans-serif !important;
            margin-top: 2rem;
        }

        #post-content h5{
            font-family: VAZIR, Arial, sans-serif !important;
            margin-top: 2rem;
        }
        #post-content h6{
            font-family: VAZIR, Arial, sans-serif !important;
            margin-top: 2rem;
        }

        .home-posts-img{width: 300px; height: 200px;}

        .plan-cart{
            min-width: 350px !important;
        }

        .swiper-slide{min-width: 300px;}
        .slider-img{
            width: 100%;
            height: auto;
            max-height: 200px;
        }

        .featured-slide{
            min-width: 280px;
        }
        .featured-slide img{
            width: 100%;
            height: 100%;
            max-height: 220px;
        }


        .product-slide-title{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-img{
            width: 75px;
            height: 75px;
        }

        .primary-btn{
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
        }


        .sale-timer {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
            padding: 8px;
            border-radius: 14px;
            text-align: center;
            margin-top: 5px;
        }

        .sale-text {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
            display: block;
        }

        .timer-box {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .timer-box div {
            background: rgba(255,255,255,0.15);
            padding: 8px 6px;
            border-radius: 10px;
            width: 100%;
        }

        .timer-box span {
            font-size: 14px;
            font-weight: bold;
            display: block;
        }

        .timer-box small {
            font-size: 12px;
            opacity: 0.9;
        }

        /* وقتی کمتر از 1 ساعت مونده */
        .sale-timer.urgent {
            animation: pulse 1s infinite;
            background: linear-gradient(135deg, #ff0000, #ff6a00);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }

        .bg-primary-gradient{
            background: linear-gradient(135deg, #ff0000, #ff6a00);
        }

        /* Badge اصلی */
        .discount-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: linear-gradient(135deg, #ff0000, #ff6a00);
            color: #fff;
            padding: 4px 6px;
            font-size: .75rem;
            font-weight: normal;
            border-radius: 20px;
            z-index: 10;
            animation: bounce 1.5s infinite;
        }

        /* انیمیشن ملایم */
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        body{
            color: rgb(60, 66, 74);
            background-color: rgb(244, 245, 246);
        }

        .text-primary{
            color: rgb(244, 90, 90);
        }
        @if(site())
             .text-primary{
                 color: <?=site()->primary_text;?>;
             }
            body{
                color: <?=site()->default_text;?>;
                background-color: <?=site()->bg_color;?>;
            }

        @endif

         @media only screen and (max-width: 1290px) {
            .payment-method-icon{
                width: 30px;
                height: 30px;
            }
            .payment-method-name{
                font-size: .7rem;
            }
            .header-slider-image{
                display: none;
            }
            .product-image{
                width: 120px;
                height: 120px;
            }

            .discount-badge {
                position: absolute;
                top: 3px;
                right: 3px;
                padding: 2px 5px;
                font-size: .8rem;
                font-weight: normal;
                border-radius: 20px;
                z-index: 10;
                animation: bounce 1.5s infinite;
            }
            .swiper-slide{min-width: 280px;}
            .slider-img{
                width: 100%;
                height: 170px;
            }

            .featured-slide{
                min-width: 280px;
            }
            .featured-slide img{
                width: 100%;
                height: 170px;
            }
        }

        @media only screen and (max-width: 920px) {
            .payment-method-icon{
                width: 30px;
                height: 30px;
            }
            .payment-method-name{
                font-size: .7rem;
            }
            .header-slider-image{
                display: none;
            }
            .product-image{
                width: 100%;
                height: 170px;
            }

            .swiper-slide{min-width: 200px;}
            .slider-img{
                width: 100%;
                height: 120px;
            }

            .featured-slide{
                min-width: 200px;
            }
            .featured-slide img{
                width: 100%;
                height: 170px;
            }

            .text-sm{
                font-size: .8rem;
            }

            .amazing-images{
                display: none;
            }
            .discount-badge {
                position: absolute;
                top: 3px;
                right: 3px;
                padding: 2px 5px;
                font-size: 11px;
                font-weight: normal;
                border-radius: 20px;
                z-index: 10;
                animation: bounce 1.5s infinite;
            }


            .sale-timer {
                padding: 3px;
                border-radius: 7px;
                text-align: center;
                margin-top: 3px;
            }

            .sale-text {
                font-weight: normal;
                font-size: .8rem;
                margin-bottom: 5px;
                display: block;
            }

            .timer-box {
                gap: 5px;
            }

            .timer-box div {
                padding: 4px 3px;
                border-radius: 5px;
                width: 100%;
            }
            .timer-box span{font-size: .8rem}
            .timer-box small{font-size: .75rem}
        }

        @media only screen and (max-width: 600px) {
            .payment-method-icon{
                width: 30px;
                height: 30px;
            }
            .payment-method-name{
                font-size: .7rem;
            }
            .header-slider-image{
                display: none;
            }
            .product-image{
                width: 100%;
                height: 150px;
            }

            .swiper-slide{min-width: 200px;}
            .slider-img{
                width: 100%;
                height: 100px;
            }

            .featured-slide{
                min-width: 200px;
            }
            .featured-slide img{
                width: 100%;
                height: 150px;
            }

            .text-sm{
                font-size: .75rem;
            }


            .amazing-images{
                display: none;
            }
            .discount-badge {
                position: absolute;
                top: 3px;
                right: 3px;
                padding: 2px 5px;
                font-size: 11px;
                font-weight: normal;
                border-radius: 20px;
                z-index: 10;
                animation: bounce 1.5s infinite;
            }

            .sale-timer {
                padding: 3px;
                border-radius: 7px;
                text-align: center;
                margin-top: 3px;
            }

            .sale-text {
                font-weight: normal;
                font-size: .75rem;
                margin-bottom: 4px;
                display: block;
            }

            .timer-box {
                gap: 3px;
            }

            .timer-box div {
                padding: 4px 3px;
                border-radius: 5px;
                width: 100%;
            }
            .timer-box span{font-size: .75rem}
            .timer-box small{font-size: .7rem}
        }

        .box-1 img {
            width: 100%;
            max-height: 100px;
        }
        .box-1{
            align-items: center;
            align-content: center;
        }

        .box-2 img {
            width: 100%;
            max-height: 100px;
        }
        .box-2{
            align-items: center;
            align-content: center;
        }
        .box-3 img {
            max-height: 200px;
            max-width: 200px;
        }
        .box-3{
            align-items: center;
            align-content: center;
            text-align: center;
        }

        .icon-box{
            color: rgb(60, 66, 74);
            background-color: white;
            text-align: center;
            border-radius: .3rem;
            height: 100%;
            align-content: center;

        }
        .icon-box-name{
            margin: .7rem .5rem;
        }
        .icon-box-content{
            color: #4a5568;
        }
        .icon-box-img{
            text-align: center;
            align-content: center;
            align-items: center;
            padding: .5rem;

        }
        .icon-box-img img{
            width: 150px;
            height: 100px;
            margin: .3rem auto;
            object-fit: contain;
        }

        .card.swiper-slide {
            border: 1px solid #ddd;
            border-radius: .5rem;
        }

        .slider-header {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 15px;
        }

        .swiper-custom-prev,
        .swiper-custom-next {
            cursor: pointer;
            padding: 5px 10px;
            color: #212121;
            border-radius: 8px;
            border: 1px solid #aaaaaa;
        }

        .footer-social-network{
            width: 50px;
            height: 50px;
        }

        .variant-image{
            width: 50px;
            height: 50px;
        }
    </style>

</head>
<body class="">

<!-- NAVBAR -->
<div>
    <!-- TOP -->
    <nav
        class="relative px-5 py-2 flex flex-wrap justify-between items-start pt-5 bg-white">
        <a class="order-2" href="/">
            <img class="w-36" src="{{site()->header_logo}}" alt="{{site()->name}}" />
        </a>
        <div class="order-3 w-full mt-3 lg:mt-0 lg:w-5/12 lg:mr-[10%]">
            <div class="relative">
                <input
                    type="search"
                    id="default-search"
                    class="sm:block w-full px-4 py-3 sm:pl-12 text-sm sm:text-base pl-8 text-red-900 placeholder:text-red-600 rounded-2xl text-right placeholder:text-sm focus:outline-red-400 border-2 border-red-400"
                    placeholder="جستجو محصول"
                    onfocus="showModalSearch()"/>
                <div
                    class="absolute inset-y-0 left-0 flex items-center pl-4">
                    <img class="w-5 h-5 text-gray-500" src="/template/assets/image/search.png" alt="" />
                </div>
                <div class="absolute w-full bg-gray-50 shadow-2xl h-auto mt-2 z-50 rounded-2xl hidden" id="showModalSearch">
                    <ul id="searchResults" class="search-results" role="listbox" aria-hidden="true"></ul>
                </div>
            </div>
        </div>
        <div class="order-4 hidden lg:flex">
          <span
              class="block relative"
              x-data="{showChildren:false}"
              @mouseenter="showChildren=true"
              @mouseleave="showChildren=false">
            <a
                href="/login"
                class="flex items-center h-10 leading-10 px-3 mx-1 transition rounded-xl hover:bg-red-50">
              <img class="ml-1 w-6" src="/template/assets/image/user.png" alt="" />
              <span
                  class="text-sm opacity-95"
              >
                ورود | ثبت نام
              </span>
              <span>
                <img class="w-4 mr-1" src="/template/assets/image/chevron-down-login.png" alt="" />
              </span>
            </a>
            <div
                class="bg-white rounded-2xl shadow-md border-gray-50 text-sm absolute top-auto right-0 w-64 z-30 mt-1"
                x-show="showChildren"
                x-transition:enter="transition ease duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease duration-300 transform"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                style="display: none"
                @mouseenter="showChildren=true"
                @mouseleave="showChildren=false">
              <div class="bg-white rounded-2xl w-full relative z-10 py-2 px-2">
                <ul class="list-reset">
                    @auth
                  <li
                      class="relative border-b-2 border-red-300 pb-2"
                      x-data="{showChildren:false}"
                      @mouseleave="showChildren=false"
                      @mouseenter="showChildren=true">
                    <a
                        href="/dashboard"
                        class="px-2 py-2 flex w-full items-start hover:bg-red-50 rounded-xl">
                      <span
                          class="flex justify-center items-center opacity-90"
                      ><img
                              class="w-8 ml-2"
                              src="/template/assets/image/userNotImage.png"
                              alt="" />{{auth()->user()->name ?? auth()->user()->mobile}}</span
                      >
                    </a>
                  </li>
                    @else
                        <li
                            class="relative border-b-2 border-red-300 pb-2"
                            x-data="{showChildren:false}"
                            @mouseleave="showChildren=false"
                            @mouseenter="showChildren=true">
                    <a
                        href="/login"
                        class="px-2 py-2 flex w-full items-start hover:bg-red-50 rounded-xl">
                      <span
                          class="flex justify-center items-center opacity-90"
                      ><img
                              class="w-8 ml-2"
                              src="/template/assets/image/userNotImage.png"
                              alt="" />ورود به حساب کاربری</span
                      >
                    </a>
                  </li>
                    @endauth
                  <li
                      class="relative pt-2"
                      x-data="{showChildren:false}"
                      @mouseleave="showChildren=false"
                      @mouseenter="showChildren=true">
                    <a
                        href="/dashboard/invoice"
                        class="px-4 py-2 flex w-full items-start hover:bg-red-50 rounded-xl">
                      <span class="flex justify-center items-center text-sm opacity-90"
                      ><img
                              class="w-5 ml-1"
                              src="/template/assets/image/package.png"
                              alt="" />سفارشات اخیر</span
                      >
                    </a>
                  </li>
                        @auth
                  <li
                      class="relative"
                      x-data="{showChildren:false}"
                      @mouseleave="showChildren=false"
                      @mouseenter="showChildren=true">
                    <a
                        href="/authentication/logout"
                        class="px-4 py-2 flex w-full items-start hover:bg-red-50 rounded-xl">
                      <span class="flex justify-center items-center text-sm opacity-90"
                      ><img class="w-5 ml-1" src="/template/assets/image/exit.png" alt="" />خروج
                        از حساب کاربری</span
                      >
                    </a>
                  </li>
                        @endauth
                </ul>
              </div>
            </div>
          </span>
            <span
                class="block relative">
            <a
                href="/cart"
                class="flex items-center h-10 leading-10 px-3 cursor-pointer no-underline hover:no-underline duration-100 mx-1 transition rounded-xl hover:bg-red-100">
              <img
                  class="inline ml-1 w-5"
                  src="/template/assets/image/shopping-cart.png"
                  alt="" />
              <span
                  class="text-sm text-neutral-800 hover:text-neutral-700 opacity-95">
                سبد خرید
              </span>

            </a>
          </span>
        </div>
        <div class="order-1 lg:hidden">
            <button class="navbar-burger flex items-center text-red-300 p-3">
                <svg
                    class="block h-4 w-4 fill-current"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </button>
        </div>
    </nav>
    <!-- DOWN -->
    <div class="w-full">
        <div class="py-2 px-5 bg-white shadow-stone-50 shadow-md hidden lg:block">
            <div class="-mx-1">
                <ul class="flex w-full flex-wrap items-center h-10">
                    @foreach(main_menu() as $header_menu_item)
                    <li class="block relative"
                    @if($header_menu_item->children && count($header_menu_item->children))
                        x-data="{showChildren:false}"
                        @click.away="showChildren=false"
                    @endif
                    >
                        <a
                            @if($header_menu_item->children && count($header_menu_item->children))

                                @click.prevent="showChildren=!showChildren"
                                @mouseenter="showChildren=true"
                                @mouseleave="showChildren=false"
                            @endif
                            href="{{$header_menu_item->slug}}"
                            class="flex items-center h-10 text-sm leading-10 px-4 mx-1 transition text-gray-700 hover:text-red-500">
                            <span class=" ">{{$header_menu_item->name}}</span>
                            @if($header_menu_item->children && count($header_menu_item->children))
                            <span>
                                <img class="w-4 mr-1" src="/template/assets/image/chevron-down-login.png" alt="" />
                            </span>
                            @endif
                        </a>
                        @if($header_menu_item->children && count($header_menu_item->children))
                        <div
                            class="bg-white rounded-2xl shadow-md text-sm  opacity-[0.97] absolute top-auto right-0 min-w-full w-56 z-30 mt-3"
                            x-show="showChildren"
                            x-transition:enter="transition ease duration-300 transform"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease duration-300 transform"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4"
                            @mouseenter="showChildren=true"
                            @mouseleave="showChildren=false"
                            style="display: none">
                            <div
                                class="bg-white rounded-2xl w-full relative z-10 py-2 px-2">
                                <ul class="list-reset">
                                    @foreach($header_menu_item->children as $menu_child)
                                    <li
                                        class="relative">
                                        <a
                                            href="{{$menu_child->slug}}"
                                            class="px-4 py-2 flex w-full items-start hover:bg-red-100 rounded-lg transition no-underline hover:no-underline duration-100 cursor-pointer">
                                            <span class="flex-1">{{$menu_child->name}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
    <!--MOBILE NAVBAR-->
    <div class="navbar-menu relative z-50 hidden">
        <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
        <nav
            class="fixed top-0 right-0 bottom-0 flex flex-col w-5/6 max-w-sm py-5 px-6 bg-white border-r overflow-y-auto">
            <div class="flex justify-center items-center mb-4">
                <a class="order-1" href="/">
                    <img class="w-32" src="/images/logo.png" alt="مارلیک افزار کاسپین" />
                </a>
            </div>
            <div>
                <ul class="space-y-3">
                    <li class="border-b">
                        <div class="mt-0 mb-3 text-center space-y-5">
                            <div>
                                <div
                                    class="md:flex justify-center align-middle lg:inline-block py-2 px-4 text-sm text-neutral-800 rounded-xl hover:text-neutral-700 hover:bg-red-100 transition">
                                    <a href="/cart">
                                        <img
                                            class="inline ml-1 w-5"
                                            src="/template/assets/image/shopping-cart.png"
                                            alt="" />سبد خرید</a
                                    >
                                </div>
                                <div
                                    class="md:flex justify-center align-middle lg:inline-block py-2 px-4 text-sm text-neutral-800 rounded-xl hover:text-neutral-700 hover:bg-red-100 transition">
                                    <a href="/login"
                                    ><img
                                            class="inline ml-1 w-5"
                                            src="/template/assets/image/user.png"
                                            alt="" />ورود | ثبت نام</a
                                    >
                                </div>
                            </div>
                        </div>
                    </li>
                    <li
                        class="relative flex">
                        <a
                            href="/"
                            class="flex justify-between items-center h-10 leading-10 text-sm opacity-90 px-3 cursor-pointer no-underline w-full hover:no-underline duration-100 mx-1 transition rounded-xl hover:bg-red-100">
                            خانه
                        </a>
                    </li>
                    <li
                        class="relative flex">
                        <a
                            href="/shop"
                            class="flex justify-between items-center h-10 leading-10 text-sm opacity-90 px-3 cursor-pointer no-underline w-full hover:no-underline duration-100 mx-1 transition rounded-xl hover:bg-red-100">
                            محصولات
                        </a>
                    </li>
                    <li
                        class="relative flex">
                        <a
                            href="/blog"
                            class="flex justify-between items-center h-10 leading-10 text-sm opacity-90 px-3 cursor-pointer no-underline w-full hover:no-underline duration-100 mx-1 transition rounded-xl hover:bg-red-100">
                            مقالات
                        </a>
                    </li>
                    <li
                        class="relative flex">
                        <a
                            href="/shop/featured"
                            class="flex justify-between items-center h-10 text-red-700 leading-10 text-sm opacity-90 px-3 cursor-pointer no-underline w-full hover:no-underline duration-100 mx-1 transition rounded-xl hover:bg-red-100">
                            فروش ویژه
                        </a>
                    </li>
                    <li
                        class="relative flex"
                        x-data="{showChildren:false}"
                        @click.away="showChildren=false">
                        <a
                            href="/dashboard"
                            class="flex justify-between items-center h-10 text-sm opacity-90 leading-10 px-3 cursor-pointer no-underline w-full hover:no-underline duration-100 mx-1 transition rounded-xl hover:bg-red-100"
                            @click.prevent="showChildren=!showChildren">
                            <span>حساب کاربری</span>
                            <span>
                    <img class="w-4 mr-1" src="/template/assets/image/chevron-down-login.png" alt="" />
                  </span>
                        </a>
                        <div
                            class="bg-white rounded-2xl shadow-lg border-1 border-gray-50 text-sm absolute top-full right-0 min-w-full w-56 z-30 mt-1"
                            x-show="showChildren"
                            x-transition:enter="transition ease duration-300 transform"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease duration-300 transform"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4"
                            style="display: none">
                            </span>
                            <div
                                class="bg-white rounded-2xl w-full relative z-10 py-2 px-2">
                                <ul class="list-reset">
                                    <li
                                        class="relative"
                                        x-data="{showChildren:false}"
                                        @mouseleave="showChildren=false"
                                        @mouseenter="showChildren=true">
                                        <a
                                            href="/login"
                                            class="px-4 py-2 flex w-full items-start hover:bg-red-100 rounded-lg transition no-underline hover:no-underline duration-100 cursor-pointer">
                                            <span class="flex-1">ورود / ثبت نام</span>
                                        </a>
                                    </li>
                                    <li
                                        class="relative"
                                        x-data="{showChildren:false}"
                                        @mouseleave="showChildren=false"
                                        @mouseenter="showChildren=true">
                                        <a
                                            href="/checkout"
                                            class="px-4 py-2 flex w-full items-start hover:bg-red-100 rounded-lg transition no-underline hover:no-underline duration-100 cursor-pointer">
                                            <span class="flex-1">تسویه حساب</span>
                                        </a>
                                    </li>
                                    <li
                                        class="relative"
                                        x-data="{showChildren:false}"
                                        @mouseleave="showChildren=false"
                                        @mouseenter="showChildren=true">
                                        <a
                                            href="/dashboard/invoice"
                                            class="px-4 py-2 flex w-full items-start hover:bg-red-100 rounded-lg transition no-underline hover:no-underline duration-100 cursor-pointer">
                                            <span class="flex-1">سفارشات اخیر</span>
                                        </a>
                                    </li>
                                    <li
                                        class="relative"
                                        x-data="{showChildren:false}"
                                        @mouseleave="showChildren=false"
                                        @mouseenter="showChildren=true">
                                        <a
                                            href="/dashboard"
                                            class="px-4 py-2 flex w-full items-start hover:bg-red-100 rounded-lg transition no-underline hover:no-underline duration-100 cursor-pointer">
                                            <span class="flex-1">پنل کاربری</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- OPACITY SCREEN FOR SEARCH INPUT FOCUS -->
    <div class="absolute w-full h-screen bg-gray-200 opacity-40 z-40 hidden" id="opacitiScreen" onclick="closeScreen()">
    </div>
</div>
<!-- BOTTOM NAVIGATION -->
<div class="px-4 bg-white shadow-2xl w-full border fixed bottom-0 left-1/2 -translate-x-1/2 md:hidden z-50">
    <div class="grid grid-cols-4">
        <div class="flex-1 group">
            <a href="/dashboard" class="flex items-end justify-center text-center mx-auto pt-2 w-full text-gray-800 group-hover:text-red-500">
            <span class="block pt-1 pb-1">
              <svg class="mx-auto fill-gray-800 group-hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="" viewBox="0 0 256 256"><path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path></svg>
              <span class="block text-xs py-1">پروفایل</span>
              <span class="block w-5 mx-auto h-1 group-hover:bg-red-500 rounded-full"></span>
            </span>
            </a>
        </div>

        <div class="flex-1 group">
            <a href="/" class="flex items-end justify-center text-center mx-auto pt-2 w-full text-red-500">
            <span class="block pt-1 pb-1">
              <svg class="mx-auto fill-red-600" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#000000" viewBox="0 0 256 256"><path d="M218.83,103.77l-80-75.48a1.14,1.14,0,0,1-.11-.11,16,16,0,0,0-21.53,0l-.11.11L37.17,103.77A16,16,0,0,0,32,115.55V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V160h32v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V115.55A16,16,0,0,0,218.83,103.77ZM208,208H160V160a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v48H48V115.55l.11-.1L128,40l79.9,75.43.11.1Z"></path></svg>
              <span class="block text-xs py-1">خانه</span>
              <span class="block w-5 mx-auto h-1 bg-red-500 rounded-full"></span>
            </span>
            </a>
        </div>
        <div class="flex-1 group">
            <a href="/shop" class="flex items-end justify-center text-center mx-auto pt-2 w-full text-gray-800 group-hover:text-red-500">
            <span class="block pt-1 pb-1">
              <svg class="mx-auto fill-gray-800 group-hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#000000" viewBox="0 0 256 256"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg>
              <span class="block text-xs py-1">محصولات</span>
              <span class="block w-5 mx-auto h-1 group-hover:bg-red-500 rounded-full"></span>
            </span>
            </a>
        </div>
        <div class="flex-1 group">
            <a href="/cart" class="flex items-end justify-center text-center mx-auto pt-2 w-full text-gray-800 group-hover:text-red-500">
            <span class="block pt-1 pb-1">
              <svg class="mx-auto fill-gray-800 group-hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#000000" viewBox="0 0 256 256"><path d="M222.14,58.87A8,8,0,0,0,216,56H54.68L49.79,29.14A16,16,0,0,0,34.05,16H16a8,8,0,0,0,0,16h18L59.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,152,204a28,28,0,1,0,28-28H83.17a8,8,0,0,1-7.87-6.57L72.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,222.14,58.87ZM96,204a12,12,0,1,1-12-12A12,12,0,0,1,96,204Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,192,204Zm4-74.57A8,8,0,0,1,188.1,136H69.22L57.59,72H206.41Z"></path></svg>
              <span class="block text-xs py-1">سبد خرید</span>
              <span class="block w-5 mx-auto h-1 group-hover:bg-red-500 rounded-full"></span>
            </span>
            </a>
        </div>
    </div>
</div>
<!-- MAIN -->
<div class="max-w-[1440px] mx-auto px-3">
   @yield('content')
</div>
<!-- FOOTER -->
<footer class="pt-5 shadow-xl bg-white">
    <!-- SERVICES -->

    <!-- MAIN -->
    <div class="flex items-center justify-between my-4 px-5">
        <a href="/" class="inline-block">
            <h1 class="font-bold text-2xl text-red-500">{{site()->name}}</h1>
        </a>
        <button type="button" class="flex items-center gap-x-1 border rounded-lg px-3 py-2 text-zinc-500 text-sm md:text-base" id="btn-back-to-top">
            برو به بالا
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#9c9c9c" viewBox="0 0 256 256"><path d="M128,26A102,102,0,1,0,230,128,102.12,102.12,0,0,0,128,26Zm0,192a90,90,0,1,1,90-90A90.1,90.1,0,0,1,128,218Zm44.24-78.24a6,6,0,1,1-8.48,8.48L128,112.49,92.24,148.24a6,6,0,0,1-8.48-8.48l40-40a6,6,0,0,1,8.48,0Z"></path></svg>
        </button>
    </div>
    <div class="mx-auto shadow-lg">
        <div class="flex flex-wrap">
            <div class="w-full px-4 sm:w-2/3 lg:w-4/12">
                <div class="mb-10 w-full">
                    <p class="mb-2 opacity-80">
                        درباره ما
                    </p>
                    <p class="mb-7 opacity-60 text-sm">
                        {{site()->meta}}
                    </p>
                </div>
            </div>
            <div class="w-full px-4 sm:w-1/2 lg:w-3/12">
                <div class="mb-10 w-full">
                    <h4 class="mb-2 opacity-80">لینک های مفید:</h4>
                    <ul class="grid gap-y-2">
                        @foreach(footer_menu() as $footer_menu_item)
                        <li>
                            <a
                                href="{{$footer_menu_item->slug}}"
                                class="mb-2 text-sm hover:text-red-600 transition opacity-60 hover:opacity-100"
                            >
                                {{$footer_menu_item->name}}
                            </a>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="w-full px-4 sm:w-1/2 lg:w-3/12">
                <div class="mb-10 w-full">
                    <h4 class="mb-2 opacity-80">ارتباط با ما:</h4>
                    <ul class="grid gap-y-2">

                        @if(site()->phone)
                        <li>
                            <div
                                class="mb-2 text-sm opacity-60"
                            >
                                تلفن: <a href="tel:{{site()->phone}}">{{site()->phone}}</a>
                            </div>
                        </li>
                        @endif
                            @if(site()->address)
                                <li>
                                    <div
                                        class="mb-2 text-sm opacity-60"
                                    >آدرس: {{site()->address}}</div>
                                </li>
                            @endif
                    </ul>
                </div>
            </div>
            <div class="w-full px-4 sm:w-1/2 lg:w-2/12">
                <div class="mb-10 w-full">
                    <h4 class="mb-2 text-center opacity-80">شبکه های اجتماعی:</h4>
                    <div class="mb-5 flex items-center justify-center">
                        @if(function_exists('footer_social_networks'))
                            @foreach(footer_social_networks() as $footer_social_network)
                                <a href="{{$footer_social_network->link}}" rel="nofollow"
                                   target="_blank" title="{{$footer_social_network->name}}"
                                   class="mx-1">
                                    <img src="{{$footer_social_network->image}}"
                                         alt="{{$footer_social_network->name}}" class="footer-social-network"
                                    @if(strpos($footer_social_network->image, '.png'))
                                        style="width: 40px; height: 40px;"
                                    @endif
                                    >
                                </a>
                            @endforeach
                        @endif
                    </div>
                    <div class="flex items-center justify-center gap-x-5">
                        <a href="/enamad">
                            <img class="w-28 h-auto" src="/images/enamad.png" alt="نماد اعتماد">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- COPYRIGHT -->
    <div class="px-4 grid grid-cols-1 sm:grid-cols-2 border-t-[1px] py-5 text-gray-400">
       <span class="text-xs text-center sm:text-right text-red-500">
          <a href="https://caspiweb.ir" target="_blank">طراحی شده با فروشگاه ساز مارلیک</a>
      </span>
    </div>
</footer>

<!--DROPDOWNS FOR NAVBAR-->
<script src="/template/assets/js/flowbite.bundle.js"></script>
<script src="/template/assets/js/alpine.js" defer></script>
<!--MOBILE NAVBAR-->
<script src="/template/assets/js/navbar.js"></script>
<!-- SHOW MODAL SEARCH -->
<script src="/template/assets/js/searchBox.js"></script>
<!-- SLIDER HERO -->


<!-- PRODUCT SLIDER -->
<script src="/template/assets/js/swiper-bundle.min.js"></script>
<script src="/template/assets/js/scriptSlider.style.js"></script>
<!-- BIG SLIDER -->
<script src="/template/assets/js/bigSlider.js"></script>
<!-- FOR TIMER OFF -->
<script src="/template/assets/js/jquery.min.js"></script>
<script src="/template/assets/js/main.js"></script>


@yield('script')
<script>
    function runSaleTimer(timer) {
        const end = new Date(timer.dataset.end).getTime();

        const daysEl = timer.querySelector('.days');
        const hoursEl = timer.querySelector('.hours');
        const minutesEl = timer.querySelector('.minutes');
        const secondsEl = timer.querySelector('.seconds');

        const interval = setInterval(() => {
            const now = new Date().getTime();
            let diff = end - now;

            if (diff <= 0) {
                clearInterval(interval);
                timer.innerHTML = '<strong>⛔ تخفیف به پایان رسید</strong>';
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            diff %= (1000 * 60 * 60 * 24);

            const hours = Math.floor(diff / (1000 * 60 * 60));
            diff %= (1000 * 60 * 60);

            const minutes = Math.floor(diff / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            daysEl.textContent = days.toString().padStart(2, '0');
            hoursEl.textContent = hours.toString().padStart(2, '0');
            minutesEl.textContent = minutes.toString().padStart(2, '0');
            secondsEl.textContent = seconds.toString().padStart(2, '0');

            // حالت اضطراری (کمتر از 1 ساعت)
            if (end - now < 3600000) {
                timer.classList.add('urgent');
            }

        }, 1000);
    }

    document.querySelectorAll('.sale-timer').forEach(timer => {
        runSaleTimer(timer);
    });

</script>
</body>
</html>
