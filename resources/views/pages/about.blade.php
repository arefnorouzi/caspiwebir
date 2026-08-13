@extends('layouts.IranMarket')
@section('title', 'درباره ما')
@section('meta', 'ساخت انواع محصولات دکوراتیو و باکس گل')
@section('content')

    <section class="mt-4 md:mt-7 ">
        <div class="container mx-auto px-5 relative">
            <div class="flex flex-col justify-center items-center gap-5">
                <div class="max-w-md rounded-3xl p-px bg-gradient-to-b from-[var(--secend)] to-[var(--crayola)] ">
                    <div class="rounded-[calc(1.5rem-1px)] py-2 px-5 bg-white">
                        <span class="text-gray-500 font-ligh text-sm md:text-base">درباره ما</span>
                    </div>
                </div>
                <h2 class="font-extrabold text-2xl md:text-5xl md:w-[700px] leading-[40px] md:leading-[75px] mx-auto text-center text-slate-900">معرفی مارلیک افزار کاسپین</h2>
                <p class="md:w-3/5 text-[#4F4F4F] text-center text-sm md:text-base leading-7 md:leading-7">مارلیک افزار کاسپین یک پلتفرم کامل برای مدیریت کسب و کار آنلاین شما ارایه می کند. خدماتی همچون میزبانی وبسایت، طراحی و کدنویسی، سئو و دیجیتال مارکتینگ، نرم افزارهای مدیریت انبار و حسابداری و ... . </p>
            </div>
        </div>
    </section>


    <section class="mt-7 md:mt-16 ">
        <div class="container mx-auto px-5 relative">
            <div class="flex items-center justify-center gap-4 md:gap-4">

                <a href="https://instagram.com/candlegift.nora"><img class="transition duration-500 hover:-translate-y-2 w-[70px] md:w-auto" src="/icons/instagram.svg"></a>
                <a href="https://t.me/Bahar_ashoorzade"><img class="transition duration-500 hover:-translate-y-2 w-[70px] md:w-auto" src="/icons/telegram.svg"></a>
                <a href="https://wa.me/989362008146"><img class="transition duration-500 hover:-translate-y-2 w-[70px] md:w-auto" src="/icons/whatsapp.svg"></a>
            </div>
        </div>
    </section>



@endsection
