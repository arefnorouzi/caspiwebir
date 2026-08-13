<section class=" mt-16 md:mt-36 mb-16 md:mb-32">
    <div class="container mx-auto px-5">
        <div class="flex flex-col items-center">
            <div class=" w-fit rounded-3xl p-px bg-gradient-to-b from-[var(--secend)] to-[var(--crayola)]">
                <div class="rounded-[calc(1.5rem-1px)] py-2 px-5 bg-white">
                    <span class="text-gray-500 font-ligh text-sm md:text-base">بلاگ</span>
                </div>
            </div>
            <h3 class="text-lg md:leading-[50px] md:text-[40px] text-[#333] font-bold mt-5 nd:mt-7 text-center">اخبار، آموزش و مقالات</h3>
        </div>
        <div class="mt-5 md:mt-10">
            <div class="owl-carousel owl-theme articles" dir="ltr">
                @foreach($posts as $post)
                <div class="item pr-1">
                    <div class="p-4 rounded-2xl border border-[#BDBDBD] flex flex-col items-end hover:bg-white transition hover:shadow-xl">
                        <a href="/blog/article/{{$post->id}}" target="_blank" class="w-full"><img class="!h-[200px] sm:!h-[240px] rounded-xl object-cover" src="{{$post->image ?? '/images/article.svg'}}"></a>
                        <a href="/blog/article/{{$post->id}}" target="_blank"><h4 class="text-base md:text-lg text-[#333] font-bold text-right mt-6">{{$post->name}}</h4></a>
                        <p class="text-sm text-right leading-6 text-[#4F4F4F] mt-4 mb-8">{{$post->meta}}</p>
                        <div class="flex gap-3">
                            <div class="flex flex-col text-right gap-1">
                                <span class="text-sm text-[#4F4F4F]">{{$post?->author?->name}}</span>
                                <span class="text-sm text-[#828282]">{{verta($post->published_at)->format('%d %B  %Y')}}</span>
                            </div>
                            <img src="/images/profile.png" alt="{{$post->author->name}}" class="!w-[45px] !h-[45px]">
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
