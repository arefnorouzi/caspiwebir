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

    <!-- torob robot meta data start -->
    <meta name="product_price" content="{{$product->active_price}}">
    <meta name="availability" content="{{ $product->stock ? 'instock' : 'outofstock' }}">
    <meta name="product_name" content="{{$product->name}}">
    <meta name="product_id" content="{{$product->id}}">
    <meta name="guarantee" content="{{$product->guarantee}}">
    <!-- torob robot meta data end -->
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
        <div class="p-3 w-full mx-auto rounded-2xl" >
            <div class="lg:flex" >
                <div class="w-full lg:w-2/3 flex flex-wrap">
                    <div class="lg:w-1/3">
                        <div>
                            <div class="max-w-[300px] mx-auto">
                                <img class="mySlides rounded-xl md:rounded-3xl" src="{{$product->image}}"
                                     style="width:100%">
                                @foreach($product->galleries as $gallery)
                                    <img class="mySlides rounded-xl md:rounded-3xl"
                                         src="{{$gallery->image}}" style="width:100%;display:none">

                                @endforeach

                            </div>
                            <div class="flex justify-around gap-x-4 mt-3">
                                <div class="max-w-[80px]">
                                    <img class="rounded-xl opacity-70 hover:opacity-100 transition"
                                         src="{{$product->image}}" onclick="currentDiv(1)">
                                </div>
                                <?php $gallery_counter = 1 ?>
                                @foreach($product->galleries as $gallery)
                                        <?php $gallery_counter++;?>
                                    <div class="max-w-[80px]">
                                        <img class="rounded-xl opacity-70 hover:opacity-100 transition"
                                             src="{{$gallery->image}}" onclick="currentDiv({{$gallery_counter}})">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-2/3 sm:pr-7">
                        <div class="opacity-80 text-lg font-semibold">
                            {{$product->name}}
                        </div>
                        <div class="opacity-50 text-xs mt-2 mb-4">
                            {{$product->sub_title}}
                        </div>
                        <div class="">

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
                    </div>

                    <!-- TABS -->
                    <div class="lg:w-1/1 w-full mt-10">
                        <div class="border-b border-gray-200 mb-4">
                            <ul class="flex justify-center flex-wrap -mb-px text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2" id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false">درباره محصول</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 active" id="test-tab" data-tabs-target="#test" type="button" role="tab" aria-controls="test" aria-selected="true">بررسی تخصصی</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 " id="details-tab" data-tabs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">مشخصات</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 " id="comments-tab" data-tabs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">نظرات</button>
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
                            <div class="bg-gray-50 p-4 rounded-xl " id="test" role="tabpanel" aria-labelledby="test-tab">
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
                            <div class="bg-gray-50 p-4 rounded-xl hidden" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                              <span class="border-b-red-500 border-b">
                                پرسش های محصول
                              </span>
                                <p class="text-gray-500 text-sm">
                                <div class="flex flex-col py-4 px-4 mx-auto my-6 max-w-7xl rounded-2xl bg-white">
                                    <!-- UO COMMENTS -->
                                    <div>
                                        <div>نظرات</div>
                                        <div class="pr-5 opacity-70 text-xs">{{count($product->confirmed_comments)}} نظر</div>
                                    </div>
                                    @foreach($product->confirmed_comments as $comment)
                                    <!-- COMMENT -->
                                    <div class="bg-gray-50 rounded-xl px-5 py-3 my-2">
                                        <div class="flex items-center">
                                            <div>
                                                <img class="w-10" src="/template/assets/image/userNotImage.png" alt="{{$comment?->user?->name}}">
                                            </div>
                                            <div class="text-sm opacity-60 pr-1">
                                                نوشته شده توسط: {{$comment?->user?->name ?? "کاربر $comment->user_id"}}
                                            </div>
                                        </div>
                                        <div class="opacity-60 text-sm py-3">
                                          {{$comment->description}}
                                        </div>

                                        @if($comment->support_reply)
                                        <!-- RESPONSE -->
                                        <div class="bg-gray-100 rounded-xl pl-2 pr-5 sm:pr-8 py-3">
                                            <div class="flex items-center">
                                                <div>
                                                    <img class="w-10" src="/template/assets/image/userNotImage.png" alt="{{$comment?->support?->name}}">
                                                </div>
                                                <div class="text-sm opacity-60 pr-1">
                                                    پاسخ داده شده: {{$comment?->support?->name}}
                                                </div>
                                            </div>
                                            <div class="opacity-60 text-sm py-3">
                                                {{$comment->support_reply}}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach

                                    @auth
                                    <!-- BOX SENT COMMENT -->
                                    <div class="mb-4">
                                        <label for="mailTicket" class="inline-block mb-2 ml-1 font-semibold text-xs text-slate-700">نظر شما:</label>
                                        <textarea id="comment_input" cols="30" rows="3" placeholder="نظر خود را بنویسید" class="text-sm block w-full rounded-lg border border-gray-400 bg-white px-3 py-2 font-normal text-gray-700 outline-none focus:border-red-300"></textarea>
                                    </div>
                                    <button
                                        onclick="sendComment()"
                                        class="inline-block px-8 py-2 ml-auto font-semibold text-center text-white bg-red-500 rounded-lg shadow-md text-xs">ارسال نظر</button>
                                    @endauth
                                </div>
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="w-full lg:w-1/3 mt-5 md:mt-0" id="vueapp">

                    <div class="md:flex sm:pr-7">


                        <div class="w-full mt-5 md:mt-0">
                            <div>
                                <!-- Aparat video position -->
                            </div>
                            <div class="p-3 border rounded-xl mx-auto divide-y lg:block">
                                @if($product->offer_end_date && $product->offer_price)
                                    <div class="sale-timer"
                                         data-end="{{ $product->offer_end_date }}">

                                        <span class="sale-text">🔥 فرصت محدود!</span>

                                        <div class="timer-box" style="direction: ltr">
                                            <div><span class="days">00</span><small>روز</small></div>
                                            <div><span class="hours">00</span><small>ساعت</small></div>
                                            <div><span class="minutes">00</span><small>دقیقه</small></div>
                                            <div><span class="seconds">00</span><small>ثانیه</small></div>
                                        </div>
                                    </div>
                                @endif
                                @if($product->guarantee)
                                    <div class="flex gap-x-1 items-center text-zinc-600 text-sm pb-3 pt-3">
                                        <div>
                                            <img src="/icons/license.svg" style="width: 30px; height: 30px; border-radius: .3rem">
                                        </div>
                                        <div>
                                            {{$product->guarantee}}
                                        </div>
                                    </div>
                                @endif
                                @if($product->warranty)
                                    <div class="flex gap-x-1 items-center text-zinc-600 text-sm pb-3 pt-3">
                                        <div>
                                            <img src="/icons/cashback.svg" style="width: 30px; height: 30px; border-radius: .3rem">
                                        </div>
                                        <div>
                                            {{$product->warranty}}
                                        </div>
                                    </div>
                                @endif
                                @if($product->duration)
                                    <div class="flex gap-x-1 items-center text-zinc-600 text-sm pb-3 pt-3">
                                        <div>
                                            <img src="/icons/video.svg" style="width: 30px; height: 30px; border-radius: .3rem">
                                        </div>
                                        <div>
                                            تعداد جلسات: {{$product->duration}} جلسه
                                        </div>
                                    </div>
                                @endif
                                @if($product->course_time)
                                    <div class="flex gap-x-1 items-center text-zinc-600 text-sm pb-3 pt-3">
                                        <div>
                                            <img src="/icons/clock.svg" style="width: 30px; height: 30px; border-radius: .3rem">
                                        </div>
                                        <div>
                                            مدت دوره: {{$product->course_time}}
                                        </div>
                                    </div>
                                @endif
                                    @if($product->source)
                                        <div class="flex gap-x-1 items-center text-zinc-600 text-sm pb-3 pt-3">
                                            <div>
                                                <img src="/icons/source.svg" style="width: 30px; height: 30px; border-radius: .3rem">
                                            </div>
                                            <div>
                                                سورس کد: دارد
                                            </div>
                                        </div>
                                    @endif
                                    @if($product->user_id && isset($product->user))
                                        <div class="flex gap-x-1 items-center text-zinc-600 text-sm pb-3 pt-3">
                                            <div>
                                                <img src="/icons/teacher.svg" style="width: 30px; height: 30px; border-radius: .3rem">
                                            </div>
                                            <div>
                                                مدرس: {{$product?->user?->name}}
                                            </div>
                                        </div>
                                    @endif

                                <div class="flex flex-col justify-center py-5">
                                    <div class="text-zinc-600 text-center">
                                        @if($product->offer_price && $product->price > $product->offer_price)
                                            <s class="font-semibold text-sm mx-1">{{number_format($product->price)}}</s>
                                        @endif
                                        <span class="font-semibold text-red-600 text-xl px-1 mx-1 product-price">{{number_format($product->offer_price > 0 ? $product->offer_price : $product->price)}}</span>

                                        <span class="text-xs px-1 mx-1">تومان</span>
                                    </div>
                                </div>

                                    <div v-if="variants && variants.length > 0" class="flex flex-col justify-center py-5">
                                        <ul class="grid w-full gap-1 grid-cols-2">
                                            <li v-for="(variant, v) in variants" :key="v" @click="changeVariant(variant)">
                                                <input type="radio" :id="`variant-${variant.id}`" v-model="product.product_variant_id" name="variant"
                                                       :value="variant.id" class="hidden peer shipping-radio">
                                                <label :for="`variant-${variant.id}`"
                                                       class="flex items-center justify-start gap-x-2 p-2 text-gray-600 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-400 peer-checked:text-red-400 hover:text-gray-600 hover:bg-gray-100">
                                                    <img v-if="variant.image" :src="variant.image"
                                                         class="variant-image"
                                                    >
                                                    <div class="text-center">
                                                        <span class="text-xs">@{{ variant.name }} </span><br />
                                                        <span class="text-xs text-red-500">@{{ variant.active_price.toLocaleString() }} </span><br />
                                                    </div>
                                                </label>
                                            </li>
                                        </ul>
                                        <div v-if="variant_meta" class="my-2 p-2 border bg-indigo-100 text-indigo-600 text-sm rounded-md">
                                            <p>@{{variant_meta}}</p>
                                        </div>
                                    </div>
                                    <div style="display: none;" class="flex flex-wrap justify-items-center justify-center py-5">
                                        <label class="text-gray-900 p-2">تعداد</label>
                                        <input type="number" v-model="product.stock"
                                               placeholder="1"
                                               class="p-2 text-gray-900 text-center w-1/2 border-gray-300 rounded-lg">
                                    </div>
                                @if($product->buyable)
                                    @if($product->pre_order)
                                        <p class="p-2 bg-red-200 mb-2 text-red-500 rounded-md text-sm">
                                       <span>
                                        مشتری عزیز با توجه به نوسانات قیمتی کلیه درگاه ها برای این محصول مسدود شده و فقط می‌توانید ثبت سفارش کنید . در صورت تایید واحد فروش درگاه باز خواهد شد
                                       </span>
                                        </p>
                                    @endif

                                    <button @click="addToCart()" class="mx-auto w-full px-2 py-3 text-sm bg-red-500 hover:bg-red-400 transition text-gray-100 rounded-lg primary-btn">
                                        افزودن به سبد خرید
                                    </button>
                                @else
                                    <p class="p-2 bg-red-200 mb-2 text-red-500 rounded-md text-sm">
                                        فروش این محصول بصورت موقت متوقف شده است
                                    </p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="my-2 bg-white rounded-2xl py-3">
                <?php $lesson_counter = 0;?>
                @foreach($courses as $course)

                    <div class="shadow-sm">
                        <!-- header -->
                        <div class="accordion-header cursor-pointer transition flex space-x-5 px-5 items-center h-auto min-h-[64px] py-2 sm:h-16 border rounded-xl my-2"
                        @if($lesson_counter == 0)
                            id="first_course"
                        @endif
                        >
                            <h2 class="opacity-80">{{$course->name}}</h2>
                        </div>
                        <!-- Content -->
                        <div class="accordion-content transition-all px-5 pt-0 overflow-hidden max-h-0">
                            @foreach($course->lessons as $lesson)
                                    <?php $lesson_counter++;?>
                            <div class="lesson-box bg-gray-100 flex justify-between mb-5 px-2 py-4 border shadow-sm rounded-lg">
                                <div class="">
                                    <span class="">{{$lesson_counter}}: </span>
                                    {{$lesson->name}}
                                </div>
                                <div class="flex gap-2">
                                        <div>
                                            {{$lesson->lesson_time}}
                                        </div>
                                    @if($lesson->free)
                                        <div>
                                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.4086 9.35258C23.5305 10.5065 23.5305 13.4935 21.4086 14.6474L8.59662 21.6145C6.53435 22.736 4 21.2763 4 18.9671L4 5.0329C4 2.72368 6.53435 1.26402 8.59661 2.38548L21.4086 9.35258Z" fill="#1C274C"></path> </g></svg>
                                            </div>
                                    @else
                                        <div>
                                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 14.5V16.5M7 10.0288C7.47142 10 8.05259 10 8.8 10H15.2C15.9474 10 16.5286 10 17 10.0288M7 10.0288C6.41168 10.0647 5.99429 10.1455 5.63803 10.327C5.07354 10.6146 4.6146 11.0735 4.32698 11.638C4 12.2798 4 13.1198 4 14.8V16.2C4 17.8802 4 18.7202 4.32698 19.362C4.6146 19.9265 5.07354 20.3854 5.63803 20.673C6.27976 21 7.11984 21 8.8 21H15.2C16.8802 21 17.7202 21 18.362 20.673C18.9265 20.3854 19.3854 19.9265 19.673 19.362C20 18.7202 20 17.8802 20 16.2V14.8C20 13.1198 20 12.2798 19.673 11.638C19.3854 11.0735 18.9265 10.6146 18.362 10.327C18.0057 10.1455 17.5883 10.0647 17 10.0288M7 10.0288V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V10.0288" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                            </div>
                                    @endif

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach


            </div>

            <!-- SLIDER -->
            <div class="bg-white rounded-2xl pt-10">
                <!-- TOP SLIDER -->
                <div class="flex justify-between px-5 md:px-10 items-center">
                    <div class="border-b-2 border-red-500 pb-1">محصولات مرتبط</div>
                    <a href="/shop"><div class="transition px-4 py-2 rounded-xl flex justify-center items-center text-red-500 hover:text-red-600">دیدن همه<img class="w-4" src="/template/assets/image/arrow-left.png" alt=""></div></a>
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
    <script src="/js/faq.js"></script>

    <script>
        async function sendComment(){
            const comment = {
                description: '',
                product_id: {{$pk}}
            }
            comment.description = document.getElementById('comment_input').value
            await $.ajax({
                url: '/comment/product', // مسیر لاراولی که پایین تعریف می‌کنیم
                method: 'POST',
                data: comment,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // مطمئن شو meta تو head هست
                },
                success: function(res){
                    alert("نظر شما با موفقیت ارسال شد. پس از تایید در سایت نمایش داده خواهد شد")
                },
                error: function(){
                    alert("خطایی در ثبت نظر شما رخ داد")
                }
            });
        }
    </script>

    <script src="/js/vue.global.js"></script>

    <script>
        const { createApp, ref } = Vue

        const csrf_token = document.querySelector('meta[name="csrf-token"]').content

        createApp({
            data(){
                return{
                    product: {
                        product_id: {{$pk}},
                        qty: 1,
                        product_variant_id: null
                    },
                    variants: <?=$variants;?>,
                    comment: {
                      description: '',
                      product_id: {{$pk}}
                    },
                    show_comment: true,
                    stock: <?=$product->stock?>,
                }
            },
            mounted(){
                let first_course = document.getElementById('first_course');
                if(first_course)
                {
                    first_course.click();
                }
            },
            methods:{
                changeVariant(variant){
                    this.product.product_variant_id = variant.id;
                    this.variant_meta = variant.meta;
                },
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
                        if (!response.ok) {
                            // وضعیت خطا (۴xx یا ۵xx)
                            this.show_toast(data.message || 'خطا در افزودن محصول به سبد خرید', 'error');
                            return; // از ادامه کد خارج میشویم
                        }
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
