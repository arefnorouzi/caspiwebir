@extends('layouts.IranMarket')
@section('title', $model->name)
@section('meta', $model->meta)
@section('page_meta')
    <link rel="canonical" href="/contact">
    <meta name="googlebot" content="index">
    <meta name="robots" content="index">
@endsection
@section('content')


    <div class="max-w-[1440px] mx-auto px-3">
        <div class="mt-0 mb-5 lg:mt-10 lg:mb-8 p-1 md:p-3">
            <div class="md:flex w-full gap-x-7">
                <div class="w-full md:w-8/12 lg:w-9/12">
                    <div class="flex flex-col py-2 px-3 mt-6 lg:mt-0 max-w-5xl rounded-2xl bg-white">
                        <div>
                            <h1 class="text-2xl opacity-95 py-3 font-bold text-red-500">{{$model->name}}</h1>
                            <div class="pb-3 leading-6 text-sm" id="post-content">
                                {!! $model->description !!}
                            </div>

                        </div>
                    </div>
                    <!-- BOX COMMENTS -->
                </div>
            </div>
        </div>
    </div>

@endsection

