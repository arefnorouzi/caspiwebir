@extends('layouts.IranMarket')
@section('title', $model->name)
@section('meta', $model->meta)
@section('page_meta')

@endsection
@section('content')


    <section class="mt-4 md:mt-7 ">
        <div class="container mx-auto px-5 relative">
            <div class="flex flex-col justify-center items-center gap-5">
                <div class="max-w-md rounded-3xl p-px bg-gradient-to-b from-[var(--secend)] to-[var(--crayola)] ">
                    <div class="rounded-[calc(1.5rem-1px)] py-2 px-5 bg-white">
                        <span class="text-gray-500 font-ligh text-sm md:text-base">{{$model->name}}</span>
                    </div>
                </div>
                <h2 class="font-extrabold text-2xl md:text-5xl md:w-[700px] leading-[40px] md:leading-[75px] mx-auto text-center text-slate-900">
                    {{$model->name}}</h2>
                <p class="md:w-3/5 text-[#4F4F4F] text-center text-sm md:text-base leading-7 md:leading-7">
                    {{$model->meta}}
                </p>

        </div>
    </section>


    <section class="mt-7 md:mt-16 ">
        <div class="container mx-auto px-5 relative">
            {!! $model->description !!}
        </div>
    </section>


@endsection

