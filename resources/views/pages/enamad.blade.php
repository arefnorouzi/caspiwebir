@extends('layouts.IranMarket')
@section('title', 'مجوزهای کسب و کار')
@section('meta', 'نماد اعتماد')
@section('page_meta')
    <link rel="canonical" href="/page/{{$model->slug}}">
    <meta name="googlebot" content="index">
    <meta name="robots" content="index">
@endsection
@section('content')

    <section class=" mt-4 md:mt-7 mb-20">
        <div class="container mx-auto px-5">

            <section>
                <div class="flex flex-col items-center">
                    <div class=" w-fit rounded-3xl p-px bg-gradient-to-b from-[var(--secend)] to-[var(--crayola)]">
                        <div class="rounded-[calc(1.5rem-1px)] py-2 px-5 bg-white">
                            <span class="text-gray-500 font-ligh text-sm md:text-base">مجوزهای کسب و کار</span>
                        </div>
                    </div>
                    <h3 class="text-lg md:leading-[60px] md:text-[40px] text-[#333] font-bold mt-5 nd:mt-7 text-center xl:w-[400px] ">مجوزهای مارلیک افزار</h3>
                    <p>برای مشاهده مجوزها، لطفا فیلترشکن خود را خاموش نمایید.</p>
                </div>
                <div class="flex justify-center gap-6 xl:gap-28 mt-8 md:mt-14 flex-col xl:flex-row">

                    <div class="w-full xl:w-1/3">
                        <div class="h-full justify-center border b-[#BDBDBD] rounded-3xl flex flex-col items-center py-[50px] md:py-[60px] gap-8 md:gap-10 hover:bg-[#F5EDED] transition hover:-translate-y-5 duration-500 ">

                            <h4 class="text-lg font-bold">نماد اعتماد</h4>

                            <hr class="my-4">
                            {!! $enamad_code !!}
                        </div>
                    </div>

                </div>
            </section>



        </div>
    </section>




@endsection
