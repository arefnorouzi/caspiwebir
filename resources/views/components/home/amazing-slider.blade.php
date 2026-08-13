@if(isset($products) && count($products))
    <!-- BIG SLIDER -->
    <div class="swiper mySwiper bg-red-500 rounded-3xl my-10">
        <div class="swiper-wrapper py-5 px-1">
{{--            <div class="card swiper-slide amazing-images flex flex-col justify-center items-center">--}}
{{--                <img src="/template/assets/image/FeaturedPromos.svg" style="max-width: 100px" alt="پیشنهاد ویژه">--}}
{{--                <img style="max-width: 150px;" src="/template/assets/image/box.webp" alt="پیشنهاد ویژه">--}}
{{--            </div>--}}

            @foreach($products as $product)
                <a href="/shop/product/{{$product->slug}}"
                   class="card swiper-slide featured-slide my-2 p-2 md:p-3 bg-white rounded-xl">
                    <div class="image-box mb-6 ">
                        <div>
                            @if($product->offer_price && $product->offer_price < $product->price)
                                <div class="discount-badge">
                                    {{ round((($product->price - $product->offer_price) / $product->price) * 100) }}٪ تخفیف
                                </div>
                            @endif
                            <img class="hover:scale-105 transition rounded-3xl w-full mx-auto"
                                 src="{{$product->image}}" alt="{{$product->name}}" />
                        </div>
                    </div>
                    <div class="space-y-2 text-right">
                        <div class="text-sm opacity-80 mb-4">
                            <div style="font-size: .77rem">{{$product->name}}</div>
                        </div>
                        <div class="flex justify-end mt-1 gap-1 mb-1 text-sm text-red-500">
                            <div>{{$product->offer_price ? number_format($product->offer_price) : number_format($product->price)}}</div>
                            <div>تومان</div>
                        </div>
                        @if($product->offer_price && $product->offer_price < $product->price)
                            <div class="flex justify-end text-xs gap-1 opacity-75">
                                <div class="line-through">{{number_format($product->price)}}</div>
                                <div class="">تومان</div>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
