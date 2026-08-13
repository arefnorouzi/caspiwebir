@extends('layouts.IranMarket')
@section('title', 'سوالات متداول')
@section('meta', 'سوالات متداول ')
@section('content')

    <div class="max-w-[1440px] mx-auto px-3">
        <div class="bg-white shadow-xl my-5 lg:my-10 rounded-xl md:rounded-2xl p-3 md:p-5">
            <div class="grid place-items-center">
                <div class="w-full md:w-11/12 mx-auto rounded">
                    <div class="bg-white px-2 py-5 md:p-10">
                        <h3 class="text-lg font-medium text-gray-800">سوالات پرتکرار</h3>
                        <p class="text-sm font-light text-gray-600 my-3">
                            اگه سوال مورد نظرتون رو پیدا نکردید به
                            <a class="hover:text-red-600 text-red-500 transition" href="/contact">پشتیبانی</a>
                            پیام بدید
                        </p>
                        <div>
                            <!-- header -->
                            <div class="accordion-header cursor-pointer transition flex space-x-5 px-5 items-center h-auto min-h-[64px] py-2 sm:h-16 border rounded-xl my-2">
                                <h2 class="opacity-80">عضویت </h2>
                            </div>
                            <!-- Content -->
                            <div class="accordion-content transition-all px-5 pt-0 overflow-hidden max-h-0">
                                <p class="leading-6 font-light pl-9 text-justify opacity-70 pt-2">
                                    با مراجعه به
                                    <a href="/login">صفحه ورود یا ثبت نام</a>
                                    به سادگی با وارد کردن شماره موبایل و دریافت پیامک تایید میتوانید ثبت نام کنید یا وارد حساب کاربری خود شوید.
                                </p>
                            </div>
                        </div>
                        <div>
                            <!-- header -->
                            <div class="accordion-header cursor-pointer transition flex space-x-5 px-5 items-center h-auto min-h-[64px] py-2 sm:h-16 border rounded-xl my-2">
                                <h2 class="opacity-80">چطور در سایت سفارش ثبت کنم؟</h2>
                            </div>
                            <!-- Content -->
                            <div class="accordion-content transition-all px-5 pt-0 overflow-hidden max-h-0">
                                <p class="leading-6 font-light pl-9 text-justify opacity-70 pt-2">
                                    از بین محصولات، محصول مورد نظر خود را انتخاب نمایید و به سبد خود اضافه کنید. سپس سفارش خود را تکمیل نمایید و هزینه را پرداخت نمایید.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script src="/js/faq.js"></script>
@endsection
