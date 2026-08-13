@extends('layouts.IranMarket')
@section('title', $product->name)
@section('meta', $product->meta ?? $product->name)
@section('page_meta')
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ $product->meta ?? $product->name }}">
    <meta property="og:image" content="{{ $product->image }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="{{ $product->meta ?? $product->name }}">
    <meta name="twitter:image" content="{{ $product->image }}">

    <!-- Product specific SEO -->
    <meta property="product:price:amount" content="{{ $product->offer_price && $product->offer_price > 0 ? $product->offer_price * 10 : $product->price * 10 }}">
    <meta property="product:price:currency" content="IRR">
    <meta property="product:availability" content="{{ $product->stock ? 'in stock' : 'out of stock' }}">


    <script type="application/ld+json">
        {!! json_encode($product_schema, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>


@endsection
@section('content')

    <div class="flex gap-x-2 px-10 mt-5 md:mt-10">
        <div>
            <a href="/" class="hover:text-red-500 transition text-sm opacity-70">خانه</a>
        </div>
        <div class="opacity-70">/</div>
        <div>
            <a href="/shop" class="hover:text-red-500 transition text-sm opacity-70">محصولات</a>
        </div>
        <div class="opacity-70">/</div>
        <div>
            <a href="{{url()->current()}}" class="hover:text-red-500 transition text-sm opacity-70">{{$product->name}}</a>
        </div>
    </div>
    <div class="bg-white shadow-xl my-5 md:my-10 rounded-xl md:rounded-2xl p-3 md:p-5">
        <div class="p-3 w-full mx-auto rounded-2xl">
            <div class="lg:flex">
                <div class="w-full lg:w-1/3">

                    <div>
                        <div class="max-w-[300px] mx-auto">
                            <img class="mySlides rounded-xl md:rounded-3xl" src="{{$product->image}}" style="width:100%">
                        </div>
                        <div class="flex justify-around gap-x-4 mt-3">
                            <div class="max-w-[80px]">
                                <img class="rounded-xl opacity-70 hover:opacity-100 transition"
                                     src="{{$product->image}}" onclick="currentDiv(1)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-2/3 mt-5 md:mt-0">
                    <div class="opacity-80 text-lg font-semibold">
                        {{$product->name}}
                    </div>
                    <div class="opacity-50 text-xs mt-2 mb-4">
                        {{$product->sub_title}}
                    </div>
                    <div class="md:flex sm:pr-7">
                        <div class="md:w-3/5">

                            <div>
                                <div class="mt-4 mb-2 opacity-80 text-sm font-semibold">
                                    ویژگی های محصول:
                                </div>
                                <div class="flex flex-col gap-2 text-xs">
                                    @foreach($product->properties->where('pinned', true) as $property)
                                        <div class="flex flex-wrap bg-gray-100 mb-2 p-2 rounded-md" style="max-width: 350px;">
                                            <h3 class="opacity-60 ml-1">
                                                {{$property->property_name}}:
                                            </h3>
                                            <div class="opacity-80">
                                                <div class="text-right">
                                                    {{$property->property_value}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="md:w-2/5 mt-5 md:mt-0" id="vueapp">
                            <div class="pb-5 rounded-2xl shadow-xl border">
                                <div class="flex justify-between px-3 py-5">
                                    <div class="text-right opacity-80 text-sm flex flex-col gap-y-6">
                                        <div>
                                            پشتیبانی:
                                        </div>
                                        <div>
                                            ضمانت:
                                        </div>
                                        <div>
                                            قیمت:
                                        </div>
                                    </div>
                                    <div class="text-center opacity-70 text-sm flex flex-col gap-y-6">
                                        <div>
                                            {{$product->guarantee}}
                                        </div>
                                        <div>
                                            {{$product->warranty}}
                                        </div>
                                        @if($product->price > 0)
                                            <div class="flex text-lg">
                                                @if($product->offer_price && $product->offer_price < $product->price)
                                                    <s class="text-slate-700">
                                                        {{number_format($product->price)}}
                                                    </s>
                                                    <div class="text-red-500 mx-1">
                                                        {{number_format($product->offer_price)}}
                                                    </div>
                                                @else
                                                    <div class="text-red-500 mx-1">
                                                        {{number_format($product->price)}}
                                                    </div>
                                                @endif
                                                <div class="text-red-500">
                                                    تومان
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex text-lg">
                                                <div class="text-red-500">
                                                    تماس بگیرید
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                @if($product->price > 0)


                                    <div class="my-3 p-2">
                                        @if(isset($variants) && count($variants))
                                            {{-- colors --}}
                                            <div class="mb-6">
                                                <p class="mb-2 font-medium">رنگ</p>
                                                <div class="flex flex-wrap gap-3">
                                                    @foreach ($variants['colors'] as $color)
                                                        <input
                                                            type="radio"
                                                            name="color_id"
                                                            id="color-{{ $color['id'] }}"
                                                            value="{{ $color['id'] }}"
                                                            class="hidden color-radio"
                                                        >

                                                        <label
                                                            for="color-{{ $color['id'] }}"
                                                            class="px-4 py-2 border-2 rounded-lg cursor-pointer text-gray-700 transition"
                                                        >
                                                            {{ $color['name'] }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            {{-- sizes --}}
                                            <div>
                                                <p class="mb-2 font-medium">سایز</p>
                                                <div class="flex gap-3">
                                                    @foreach ($variants['sizes'] as $size)
                                                        <input
                                                            type="radio"
                                                            name="size_id"
                                                            id="size-{{ $size['id'] }}"
                                                            value="{{ $size['id'] }}"
                                                            class="hidden size-radio"
                                                        >

                                                        <label
                                                            for="size-{{ $size['id'] }}"
                                                            class="px-4 py-2 border-2 rounded-lg cursor-pointer text-gray-700 transition"
                                                        >
                                                            {{ $size['name'] }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex justify-center items-center opacity-90">
                                        <button @click="addToCart()"
                                                class="px-7 py-4 text-center text-white bg-red-500 align-middle border-0 rounded-lg shadow-md text-sm">افزودن به سبد خرید</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- TABS -->
            <div class="mx-auto mt-10">
                <div class="border-b border-gray-200 mb-4">
                    <ul class="flex justify-center flex-wrap -mb-px text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2" id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false">درباره محصول</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 active" id="test-tab" data-tabs-target="#test" type="button" role="tab" aria-controls="test" aria-selected="true">بررسی تخصصی</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2" id="details-tab" data-tabs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">مشخصات</button>
                        </li>


                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="bg-gray-50 p-4 rounded-xl hidden" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <h4 class="mb-3">
                            <span class="border-b-red-500 border-b">
                                معرفی محصول
                            </span>
                        </h4>
                        <div class="text-gray-500 text-sm leading-7 mt-3">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl" id="test" role="tabpanel" aria-labelledby="test-tab">
                        <div class="flex flex-col items-start gap-y-4">
                            <span class="border-b-red-500 border-b">
                              بررسی تخصصی محصول
                            </span>
                        </div>
                        <div class="md:flex gap-3 text-gray-500 text-sm leading-7 mt-3">
                            {!! $product->excerpt_review !!}
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl hidden" id="details" role="tabpanel" aria-labelledby="details-tab">
                      <span class="border-b-red-500 border-b">
                        مشخصات فنی محصول
                      </span>
                        <div class="text-gray-500 text-sm grid grid-cols-1 gap-x-3 md:grid-cols-2">
                            @foreach($product->properties as $property)
                                <div class="flex items-center justify-between bg-gray-100 p-3 w-full my-3 mx-auto rounded-xl">
                                    <div class="text-xs opacity-80">
                                        {{$property->property_name}}:
                                    </div>
                                    <div class="text-xs opacity-70">
                                        {{$property->property_value}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- SLIDER -->
            <div class="bg-white rounded-2xl pt-10">
                <!-- TOP SLIDER -->
                <div class="flex justify-between px-5 md:px-10 items-center">
                    <div class="border-b-2 border-red-500 pb-1">محصولات مرتبط</div>
                    <a href="/brand/{{$product->brand->slug}}"><div class="transition px-4 py-2 rounded-xl flex justify-center items-center text-red-500 hover:text-red-600">دیدن همه<img class="w-4" src="/template/assets/image/arrow-left.png" alt=""></div></a>
                </div>
                <!-- SLIDER -->
                <div class="containerPSlider swiper">
                    <div class="slide-container1 px-2">
                        <div class="card-wrapper swiper-wrapper py-4">
                            @foreach($related_products as $related_product)
                                <div class="card swiper-slide related-product-slide border rounded-md hover:shadow-xl my-2 p-2 md:p-3 ">
                                    <div class="image-box mb-3 ">
                                        <a href="/shop/product/{{$related_product->slug}}">
                                            <img class="hover:scale-105 transition rounded-3xl slider-img mx-auto"
                                                 src="{{$related_product->image}}" alt="{{$related_product->name}}" />
                                        </a>
                                    </div>
                                    <div class="space-y-3 text-center">
                                        @if($related_product->brand_id && isset($related_product->brand))
                                            <div
                                                class="bg-red-500 rounded-full mb-2 px-2 py-1 text-white flex items-center gap-x-1 text-xs">
                                                {{$related_product?->brand?->name}}
                                            </div>
                                        @endif
                                        <span class="text-sm opacity-80 mb-2 h-8 md:h-10">
                                  <a href="/shop/product/{{$related_product->slug}}" target="_blank">{{$related_product->name}}</a>
                                </span>
                                        @if($related_product->offer_price && $related_product->offer_price < $related_product->price)
                                            <div class="flex justify-center text-xs opacity-75">
                                                <div class="line-through mx-1">{{number_format($related_product->price)}}</div>
                                                <div class="">تومان</div>
                                            </div>
                                        @endif
                                        <div class="flex justify-center mt-1 mb-2 text-sm text-red-500">
                                            <div class="mx-1">{{$related_product->offer_price && $related_product->offer_price < $related_product->price ? number_format($related_product->offer_price) : number_format($related_product->price)}}</div>
                                            <div>تومان</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="swiper-button-next swiper-navBtn"></div>
                    <div class="swiper-button-prev swiper-navBtn"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="/template/assets/js/toastify.js"></script>
    <script src="/template/assets/js/showImageSingleProduct.js"></script>

    <script src="/js/vue.global.js"></script>

    <script>
        const { createApp, ref } = Vue

        const csrf_token = document.querySelector('meta[name="csrf-token"]').content

        createApp({
            data(){
                return{
                    product: {
                        product_id: {{$pk}},
                        qty: 1
                    },
                    stock: <?=$product->stock?>,
                }
            },
            mounted(){
            },
            methods:{
                async decQty(){
                    if(this.product.qty > 1)
                    {
                        this.product.qty--;
                    }
                },
                async incQty(){
                    if(this.product.qty < this.stock)
                    {
                        this.product.qty++;
                    }
                },
                async addToCart(){
                    try {
                        const response = await fetch('/cart', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf_token
                            },
                            body: JSON.stringify(this.product)
                        })
                        const data = await response.json()
                        //alert(data.message || 'محصول با موفقیت افزوده شد!')
                        this.show_toast(data.message || 'محصول با موفقیت افزوده شد!', 'success');
                        await this.sleep(500)
                        location.replace('/cart');

                    } catch (error) {
                        this.show_toast('خطا در افزودن محصول به سبد خرید', 'error');
                    }
                },
                async sleep(ms){
                    return new Promise(resolve => setTimeout(resolve, ms));
                },
                show_toast(message, type = "success") {
                    const colors = {
                        success: '#16a34a', // green-600
                        error:   '#dc2626', // red-600
                        info:    '#0ea5e9', // sky-500
                        warning: '#f59e0b'  // amber-500
                    };

                    const icons = {
                        success: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>`,
                        error:   `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M12 9v4m0 4h.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.73 3h16.9a2 2 0 0 0 1.73-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="white" stroke-width="0" fill="rgba(255,255,255,0.06)"/>
              </svg>`,
                        info:    `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M12 8h.01M11 12h1v4h1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>`,
                        warning: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.73 3h16.9a2 2 0 0 0 1.73-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 9v4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>`
                    };

                    const bg = colors[type] ?? colors.info;
                    const icon = icons[type] ?? icons.info;

                    // create toast wrapper
                    const toast = document.createElement('div');
                    toast.setAttribute('role', 'status');
                    toast.style.position = 'fixed';
                    toast.style.top = '20px';
                    toast.style.left = '20px';
                    toast.style.zIndex = 99999;
                    toast.style.minWidth = '220px';
                    toast.style.maxWidth = '360px';
                    toast.style.color = '#fff';
                    toast.style.backgroundColor = bg;              // inline color => avoids class override
                    toast.style.padding = '12px 14px';
                    toast.style.borderRadius = '10px';
                    toast.style.boxShadow = '0 8px 24px rgba(0,0,0,0.15)';
                    toast.style.display = 'flex';
                    toast.style.flexDirection = 'column';
                    toast.style.gap = '8px';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(10px)';
                    toast.style.transition = 'opacity .25s ease, transform .25s ease';

                    // inner content (icon + message)
                    const row = document.createElement('div');
                    row.style.display = 'flex';
                    row.style.alignItems = 'center';
                    row.style.gap = '10px';

                    const iconWrapper = document.createElement('div');
                    iconWrapper.innerHTML = icon;
                    iconWrapper.style.flex = '0 0 18px';
                    iconWrapper.style.display = 'flex';
                    iconWrapper.style.alignItems = 'center';

                    const msg = document.createElement('div');
                    msg.style.flex = '1';
                    msg.style.fontSize = '14px';
                    msg.style.lineHeight = '1.3';
                    msg.innerText = message;

                    row.appendChild(iconWrapper);
                    row.appendChild(msg);
                    toast.appendChild(row);

                    // progress bar
                    const progress = document.createElement('div');
                    progress.style.height = '4px';
                    progress.style.width = '100%';
                    progress.style.background = 'rgba(255,255,255,0.18)';
                    progress.style.borderRadius = '4px';
                    progress.style.overflow = 'hidden';

                    const progressInner = document.createElement('div');
                    progressInner.style.height = '100%';
                    progressInner.style.width = '0%';
                    progressInner.style.background = 'rgba(255,255,255,0.95)';
                    progressInner.style.transition = 'width linear';
                    progressInner.style.borderRadius = '4px';

                    progress.appendChild(progressInner);
                    toast.appendChild(progress);

                    document.body.appendChild(toast);

                    // show
                    requestAnimationFrame(() => {
                        toast.style.opacity = '1';
                        toast.style.transform = 'translateY(0)';
                    });

                    // animate progress fill over duration
                    const duration = 3000; // ms
                    setTimeout(() => {
                        progressInner.style.transitionDuration = duration + 'ms';
                        progressInner.style.width = '100%';
                    }, 50);

                    // hide after duration
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateY(10px)';
                        // remove after transition
                        setTimeout(() => toast.remove(), 300);
                    }, duration + 200);
                }
            }
        }).mount('#vueapp')
    </script>
@endsection
