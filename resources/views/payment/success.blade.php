@extends('layouts.IranMarket')
@section('title', 'پرداخت موفق')
@section('content')

    <section class="mt-4 md:mt-7 ">
        <div class="container mx-auto px-5 relative">
            <div class="flex flex-col justify-center items-center gap-5">
                <div class="max-w-md rounded-3xl p-px bg-gradient-to-b from-[var(--secend)] to-[var(--crayola)] ">
                    <div class="rounded-[calc(1.5rem-1px)] py-2 px-5 bg-white">
                        <span class="text-gray-500 font-ligh text-sm md:text-base">پرداخت موفق</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="mt-7 md:mt-7 mb-5">
        <div class="container mx-auto px-5 relative">
            <div class="bg-white  rounded-lg py-5 px-3 text-gray-800" style="line-height: 2rem;">
                <p>از خرید شما صمیمانه متشکریم.</p>
                <hr class="my-5">
                @if(isset($invoice))
                <div class="">
                    <p class="border border-gray-300 rounded-md p-2 mb-2">
                        <span>شماره فاکتور: </span> <strong>{{$invoice->id}}</strong>
                    </p>
                    <p class="border border-gray-300 rounded-md p-2 mb-2">
                        <span>شناسه فاکتور: </span> <span>{{$invoice->uuid}}</span>
                    </p>
                    <p class="border border-gray-300 rounded-md p-2 mb-2">
                        <span>کد پیگیری پرداخت: </span> <span>{{$invoice->bank_invoice_token}}</span>
                    </p>
                    <p class="border border-gray-300 rounded-md p-2 mb-2">
                        <span>مبلغ فاکتور: </span> <strong>{{number_format($invoice->amount)}} تومان</strong>
                    </p>
                    <p class="border border-gray-300 rounded-md p-2 mb-2">
                        <span>تاریخ ایجاد: </span> <span>{{verta($invoice->created_at)->format('Y/m/d')}}</span>
                    </p>
                    @if($invoice->purchased_at)
                    <p class="border border-gray-300 rounded-md p-2 mb-2">
                        <span>تاریخ پرداخت: </span> <span>{{verta($invoice->purchased_at)->format('Y/m/d')}}</span>
                    </p>
                    @endif
                </div>

                <hr class="my-5">
                @endif
                <a href="/dashboard/invoice" class="p-2 rounded-lg bg-blue-500 text-center text-white">مشاهده جزئیات خرید</a>
            </div>

        </div>
    </section>


@endsection
