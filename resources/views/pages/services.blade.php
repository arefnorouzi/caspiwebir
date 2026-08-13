@extends('layouts.IranMarket')
@section('title', 'خدمات ما')
@section('meta', 'خدمات مارلیک افزار کاسپین در حوزه های طراحی سایت، طراحی اپلیکیشن، میزبانی وب، سئو و دیجیتال مارکتینگ، طراحی اتوماسیون و بلاکچین میباشد.')
@section('content')

    <section class=" mt-4 md:mt-7 ">
        <div class="container mx-auto px-5">
            <div class="flex flex-col items-center">
                <div class=" w-fit rounded-3xl p-px bg-gradient-to-b from-[var(--secend)] to-[var(--crayola)]">
                    <div class="rounded-[calc(1.5rem-1px)] py-2 px-5 bg-white">
                        <span class="text-gray-500 font-ligh text-sm md:text-base">خدمات ما</span>
                    </div>
                </div>
                <h3 class="text-lg md:leading-[60px] md:text-[40px] text-[#333] font-bold mt-5 nd:mt-7 text-center">خدمات مارلیک افزار کاسپین</h3>
            </div>
        </div>
    </section>


    <section class="my-14 md:my-24">
        <div class="container mx-auto px-5 relative">
            <div class="grid gap-4 mt-7 md:mt-12 md:grid-cols-2 grid-cols-1">
                <a href="/dashboard">
                    <div class="rounded-3xl bg-[#F4F4F4] px-5 py-5 md:py-8 hover:bg-[#FDA765] transition">
                        <div class="flex items-center gap-5">
                            <div class="bg-white rounded-2xl p-2">
                                <img src="/theme/images/customer-support 1.png" alt="سئو و مارکتینگ مارلیک افزار" class="bg-gradient-to-r from-[#FBBC6B] to-[#FF834E] rounded-full p-2">
                            </div>
                            <h6 class="font-bold text-base md:text-xl">مارکتینگ و بازاریابی حرفه ای</h6>
                        </div>
                        <div class="border-t border-[#828282] py-5 mt-5">
                            <p class="text-[#333] !leading-8 text-sm md:text-base  text-justify">پلتفرم های مارلیک افزار به نرم‌افزارهای حسابداری پرطرفدار مثل هلو و سپیدار، این امکان را فراهم می‌کند که اطلاعات مالی و حسابداری به صورت خودکار در سیستم CRM به‌روز شود. این همگام‌سازی دوطرفه به کسب‌وکارها کمک می‌کند تا جریان‌های مالی خود را با دقت بیشتری مدیریت کرده و گزارش‌های مالی جامع و دقیقی از فعالیت‌های مشتریان خود تهیه کنند. نتیجه‌ی این یکپارچگی، افزایش بهره‌وری و بهبود فرآیندهای مالی در سازمان خواهد بود. </p>
                        </div>
                    </div>
                </a>
                <a href="/dashboard">
                    <div class="rounded-3xl bg-[#F4F4F4] px-5 py-5 md:py-8 hover:bg-[#FDA765] transition">
                        <div class="flex items-center gap-5">
                            <div class="bg-white rounded-2xl p-2">
                                <img src="/theme/images/board 1.png" alt="طراحی سایت مارلیک افزار" class="bg-gradient-to-r from-[#FBBC6B] to-[#FF834E] rounded-full p-2">
                            </div>
                            <h6 class="font-bold text-base md:text-xl">طراحی و پیکربندی وبسایت</h6>
                        </div>
                        <div class="border-t border-[#828282] py-5 mt-5">
                            <p class="text-[#333] !leading-8 text-sm md:text-base  text-justify">طراحی انواع سایت شرکتی، فروشگاهی، اتوماسیون با بالاترین کیفیت. طراحی قالب و پنل مدیریت اختصاصی. قابلیت اتصال به درگاه های پرداخت داخلی و بین المللی. امکان اتصال به نرم افزارهای حسابداری مانند هلو و سپیدار. پشتیبانی و میزبانی دائمی.</p>
                        </div>
                    </div>
                </a>
                <a href="/dashboard">
                    <div class="rounded-3xl bg-[#F4F4F4] px-5 py-5 md:py-8 hover:bg-[#FDA765] transition">
                        <div class="flex items-center gap-5">
                            <div class="bg-white rounded-2xl p-2">
                                <img src="/theme/images/voip 1.png" alt="میزبانی وب مارلیک افزار" class="bg-gradient-to-r from-[#FBBC6B] to-[#FF834E] rounded-full p-2">
                            </div>
                            <h6 class="font-bold text-base md:text-xl">میزبانی وب</h6>
                        </div>
                        <div class="border-t border-[#828282] py-5 mt-5">
                            <p class="text-[#333] !leading-8 text-sm md:text-base  text-justify">میزبانی سایت و نرم افزارهای آنلاین بر روی بستر ابری. ارایه پلن های متنوع هاستینگ قدرتمند و امن با پشتیبانی رایگان. ارایه خدمات هاست و سرور مجازی و ابری ایرانی و خارجی.</p>
                        </div>
                    </div>
                </a>
                <a href="/dashboard">
                    <div class="rounded-3xl bg-[#F4F4F4] px-5 py-5 md:py-8 hover:bg-[#FDA765] transition">
                        <div class="flex items-center gap-5">
                            <div class="bg-white rounded-2xl p-2">
                                <img src="/theme/images/engineering 1.png" alt="طراحی و اجرای اتوماسیون توسط مارلیک افزار" class="bg-gradient-to-r from-[#FBBC6B] to-[#FF834E] rounded-full p-2">
                            </div>
                            <h6 class="font-bold text-base md:text-xl">اتوماسیون اداری و خودکارسازی فرایندهای سازمانی</h6>
                        </div>
                        <div class="border-t border-[#828282] py-5 mt-5">
                            <p class="text-[#333] !leading-8 text-sm md:text-base  text-justify">طراحی و اجرای اتوماسیون اداری و تجاری. اتوماسیون مراکز درمانی، هتل و ... . امکان اتصال به نرم افزارهای third-party. میزبانی ابری و پشتیبانی 24 ساعته. امکان تعریف سطوح مختلف کاربری.</p>
                        </div>
                    </div>
                </a>
                <a href="/dashboard">
                    <div class="rounded-3xl bg-[#F4F4F4] px-5 py-5 md:py-8 hover:bg-[#FDA765] transition">
                        <div class="flex items-center gap-5">
                            <div class="bg-white rounded-2xl p-2">
                                <img src="/theme/images/idea 1.png" alt="طراحی سامانه آموزشی توسط مارلیک افزار" class="bg-gradient-to-r from-[#FBBC6B] to-[#FF834E] rounded-full p-2">
                            </div>
                            <h6 class="font-bold text-base md:text-xl">سیستم های آموزشی </h6>
                        </div>
                        <div class="border-t border-[#828282] py-5 mt-5">
                            <p class="text-[#333] !leading-8 text-sm md:text-base  text-justify">طراحی و اجرای سامانه های آموزش آنلاین. سطوح کاربری مختلف با دسترسی های متفاوت. امکان تعریف کلاس درس و مدیریت دانشجوها. برگزاری آنلاین کلاس و امتحان. اشتراک آنلاین مستندات، منابع، پادکست و ویدیو. میزبانی ابری و پشتیبانی رایگان. </p>
                        </div>
                    </div>
                </a>
                <a href="/dashboard">
                    <div class="rounded-3xl bg-[#F4F4F4] px-5 py-5 md:py-8 hover:bg-[#FDA765] transition">
                        <div class="flex items-center gap-5">
                            <div class="bg-white rounded-2xl p-2">
                                <img src="/theme/images/slack 1.png" alt="خدمات رمزارز توسط مارلیک افزار کاسپین" class="bg-gradient-to-r from-[#FBBC6B] to-[#FF834E] rounded-full p-2">
                            </div>
                            <h6 class="font-bold text-base md:text-xl">خدمات رمزارز</h6>
                        </div>
                        <div class="border-t border-[#828282] py-5 mt-5">
                            <p class="text-[#333] !leading-8 text-sm md:text-base  text-justify">طراحی و اجرای پلتفرم های حوزه WEB3 و بلاکچین. راه اندازی سیستم های پرداخت بر پایه رمزارز. اجرای کلیه فرایندهای مربوط به قراردادهای هوشمند: اتریوم، پالیگان، سولانا و ... . برای مشاوره رایگان با پشتیبانی تماس بگیرید. </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Packages -->


@endsection
