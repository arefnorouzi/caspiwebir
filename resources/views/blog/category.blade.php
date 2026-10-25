@extends('layouts.IranMarket')
@section('title', "مقالات دسته $category_model->name")
@section('page_meta')
    <link rel="canonical" href="/blog/category/{{$category_model->slug}}">
    <meta name="googlebot" content="index, follow">
    <meta name="robots" content="index">
@endsection
@section('css')
    <style>
        .posts-image{
            max-height: 150px;
        }
    </style>
@endsection
@section('content')

    <div class="my-5 lg:my-10 p-1 md:p-3">
        <h1 class="text-2xl">مقالات دسته {{$category_model->name}}</h1>
        <div class="md:flex w-full mt-14 gap-x-7">
            <div class="w-full md:w-8/12 lg:w-9/12">
                @foreach($posts as $post)
                    <a href="/blog/article/{{$post->slug}}"
                       target="_blank"
                       class="flex flex-col sm:flex md:flex-row items-center shadow-sm p-2 mx-auto my-6 max-w-md md:max-w-full rounded-2xl bg-white ">
                        <div class="md:ml-6 mb-3 md:mb-0">
                            <img class="hover:scale-105 transition rounded-xl w-full md:w-auto posts-img mx-auto max-h-56"
                                 src="{{$post->image}}" alt="{{$post->name}}" />
                        </div>
                        <div class="grid gap-y-5 w-full">
                            <div class="text-lg opacity-80 mx-auto md:mx-0 md:h-10 pt-3 flex justify-start items-center">{{$post->name}}</div>
                            <div class="text-sm opacity-80 md:h-16 flex justify-start items-start">{{$post->meta}}</div>
                            <div class="flex justify-end text-xs opacity-75 md:gap-x-2 mx-auto md:mx-0">
                                <div>{{$post->author->name}}</div>
                                <div>{{verta($post->published_at)->format('Y/m/d')}}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="mt-8">
                    <div class="flex justify-center mb-12">{{$posts->links('vendor.pagination.tailwind')}}</div>
                </div>
            </div>
            <div class="w-full md:w-4/12 lg:w-3/12 max-w-xl mx-auto">
                <div class="lg:block p-3 space-y-4 mx-2 md:ml-3 bg-white rounded-2xl">
                    <div class="opacity-90 border-b pb-3">
                        دسته بندی مقالات:
                    </div>
                    @foreach($categories as $category)
                        <a href="/blog/category/{{$category->slug}}" target="_blank" class="flex flex-row items-center p-1">
                            <div class="md:ml-3  mb-3 md:mb-0">
                                <img class="hover:scale-105 transition rounded-lg related-posts-img"
                                     src="{{$category->image}}" alt="{{$category->name}}" />
                            </div>
                            <div class="w-full px-3 md:px-0">
                                <div class="mx-auto text-sm h-10 opacity-90">{{$category->name}} ({{$category->posts_count}})</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
