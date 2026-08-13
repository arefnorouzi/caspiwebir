@extends('layouts.IranMarket')
@section('title', $post->name)
@section('meta', $post->meta ?? $post->name)
@section('content')

    <div class="max-w-[1440px] mx-auto px-3">
        <div class="mt-0 mb-5 lg:mt-10 lg:mb-8 p-1 md:p-3">
            <div class="md:flex w-full gap-x-7">
                <div class="w-full md:w-8/12 lg:w-9/12">
          <div class="flex flex-col py-2 px-3 mt-6 lg:mt-0 max-w-5xl rounded-2xl bg-white">
            <div>
              <div class="flex flex-wrap gap-x-3 text-xs opacity-75 py-1">
                <div class="flex">
                  <div>تاریخ: </div>
                  <div>{{verta($post->published_at)->format('Y/m/d')}}</div>
                </div>
                <div class="flex">
                  <div>نویسنده: </div>
                  <div>{{$post->author->name}}</div>
                </div>
                <div class="flex">
                  <div>دسته بندی: </div>
                  <div>{{$post->category->name}}</div>
                </div>

              </div>
            </div>
            <img class="rounded-2xl my-3"
                 src="{{$post->image}}" alt="{{$post->name}}">
            <div>
              <h1 class="text-2xl opacity-95 py-3">{{$post->name}}</h1>
              <div class="opacity-70 pb-3 leading-6 text-sm" id="post-content">
                  {!! $post->description !!}
              </div>

            </div>
          </div>
                    <!-- BOX COMMENTS -->
    </div>
            <div class="w-full md:w-4/12 lg:w-3/12 max-w-xl mx-auto">
                <div class="lg:block p-3 space-y-4 mx-2 md:ml-3 bg-white rounded-2xl">
                    <div class="opacity-90 border-b pb-3">
                        مقالات مرتبط:
                    </div>
                    @foreach($related_posts as $related_post)
                    <a href="/blog/article/{{$related_post->slug}}"
                       target="_blank"
                       class="flex flex-row items-center p-1">
                        <div class="md:ml-3  mb-3 md:mb-0">
                            <img class="hover:scale-105 transition rounded-md related-posts-img"
                                 src="{{$related_post->image}}" alt="{{$related_post->name}}" />
                        </div>
                        <div class="w-full px-3 md:px-0">
                            <div class="mx-auto text-sm opacity-90">{{$related_post->name}}</div>
                            <div class="text-xs md:flex mt-2 justify-start opacity-75 mx-auto md:mx-0 pb-3">
                                <div>{{verta($related_post->published_at)->format('Y/m/d')}}</div>
                            </div>
                        </div>
                    </a>
                    @endforeach

                </div>
            </div>
            </div>
        </div>
    </div>

@endsection
