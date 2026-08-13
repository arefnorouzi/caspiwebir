<!-- START SIMPLE PRODUCT SLIDER 1 -->
@if(isset($products) && count($products))
    <div class="rounded-2xl pt-5 shadow-xl my-10"
        style="background-color: {{$bg_color ?? 'white'}}">
    <!-- TOP SLIDER -->
    <div class="flex justify-between px-5 md:px-10 items-center">
        <div class="border-b-2 border-red-500 pb-1">
            <a href="/shop/{{$link}}" class="hover:text-red-600"> {{$slider_name}}</a>
        </div>
        <div class="slider-header">
            <div class="swiper-custom-prev">❮</div>
            <div class="swiper-custom-next">❯</div>
        </div>
    </div>

    <!-- SLIDER -->
    <div class="containerPSlider swiper" >
        <div class="slide-container1 px-2">
            <div class="card-wrapper swiper-wrapper py-4">
                @foreach($products as $product)
                    <a href="/shop/product/{{$product->slug}}"
                       class="card swiper-slide my-2 p-2 md:p-3 ">
                        <div class="image-box mb-6 ">
                            @if($product->offer_price && $product->offer_price < $product->price)
                                <div class="discount-badge">
                                    {{ round((($product->price - $product->offer_price) / $product->price) * 100) }}٪ تخفیف
                                </div>
                            @endif
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
<!-- END SIMPLE PRODUCT SLIDER 1 -->
