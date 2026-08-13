@if(isset($products) && count($products))
    <div class="bg-white rounded-2xl pt-5 shadow-xl my-10">
        <!-- TOP SLIDER -->
        <div class="flex justify-between px-5 md:px-10 items-center">
            <div class="border-b-2 border-red-500 pb-1">
                <a href="/shop/{{$link}}" class="hover:text-red-600">{{$slider_name}}</a>
            </div>
            <div class="slider-header">
                <div class="swiper-custom-prev">❮</div>
                <div class="swiper-custom-next">❯</div>
            </div>
        </div>
        <!-- SLIDER -->
        <div class="containerPSlider swiper">
            <div class="slide-container1 px-2">
                <div class="card-wrapper swiper-wrapper py-4 ">
                    @foreach($products as $product)
                        <a href="/shop/product/{{$product->slug}}"
                           class="card swiper-slide my-2 p-2 md:p-3">
                            <div class="sale-timer"
                                 data-end="{{ $product->offer_end_date }}" data-pid="{{$product->id}}">

                                <span class="sale-text">🔥 فرصت محدود!</span>

                                <div class="timer-box" id="timer-box-{{$product->id}}" style="direction: ltr">
                                    <div><span class="days" id="days-{{$product->id}}">00</span><small>روز</small></div>
                                    <div><span class="hours" id="hours-{{$product->id}}">00</span><small>ساعت</small></div>
                                    <div><span class="minutes" id="minutes-{{$product->id}}">00</span><small>دقیقه</small></div>
                                    <div><span class="seconds" id="seconds-{{$product->id}}">00</span><small>ثانیه</small></div>
                                </div>
                            </div>

                            <div class="image-box my-3 ">

                                <img class="hover:scale-105 transition rounded-3xl slider-img mx-auto"
                                     style="object-fit: contain"
                                     src="{{$product->image}}" alt="{{$product->name}}" />
                            </div>
                            <div class="space-y-3 text-center">
                                <div class="text-sm opacity-80 mb-2">
                                    <div>
                                        {{$product->name}}
                                    </div>
                                </div>
                                @if($product->offer_price && $product->offer_price < $product->price)
                                    <div class="flex justify-center text-xs gap-1 opacity-75">
                                        <div class="line-through">{{number_format($product->price)}}</div>
                                        <div class="">تومان</div>
                                    </div>
                                @endif
                                <div class="flex justify-center text-red-500 gap-1 mt-1 mb-2 text-sm">
                                    <div>{{$product->offer_price ? number_format($product->offer_price) : number_format($product->price)}}</div>
                                    <div>تومان</div>
                                </div>
                            </div>

                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
