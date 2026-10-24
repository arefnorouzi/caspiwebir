@extends('layouts.IranMarket')
@section('title', $post->name)
@section('meta', $post->meta ?? $post->name)
@section('content')
    <style>
        /* محفظه اصلی کد */
        #post-content .code-block-wrapper {
            position: relative;
            direction: ltr;
            margin: 24px 0;
            overflow: hidden;
            border-radius: 12px;
            background: #0d1117;
            border: 1px solid #30363d;
        }

        /* محفظه کد Quill */
        #post-content .ql-code-block-container {
            direction: ltr;
            text-align: left;
            background: #0d1117;
            color: #f7d774;

            margin: 0;
            padding: 50px 18px 18px;

            overflow-x: auto;
            white-space: pre;
            tab-size: 4;

            font-family: Consolas, Monaco, "Courier New", monospace;
            font-size: 14px;
            line-height: 1.8;
        }

        /* خطوط کد */
        #post-content .ql-code-block {
            direction: ltr;
            text-align: left;
            white-space: pre;
            font-family: inherit;
            color: inherit;
            min-height: 1.8em;
        }

        /* دکمه کپی */
        #post-content .copy-code-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;

            background: #21262d;
            color: #fff;
            border: 1px solid #484f58;
            border-radius: 6px;

            padding: 6px 12px;
            font-size: 12px;
            cursor: pointer;
        }

        #post-content .copy-code-btn:hover {
            background: #30363d;
        }

        @media (max-width: 640px) {
            #post-content .ql-code-block-container {
                font-size: 12px;
                padding: 48px 12px 14px;
            }
        }
    </style>
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
                                    <div>{{$post?->author?->name}}</div>
                                </div>
                                <div class="flex">
                                    <div>دسته بندی: </div>
                                    <div>{{$post?->category?->name}}</div>
                                </div>

                            </div>
                        </div>
                        <img class="rounded-2xl my-3"
                             src="{{$post->image}}" alt="{{$post->name}}">
                        <div>
                            <h1 class="text-2xl py-3">{{$post->name}}</h1>
                            <div class="pb-3 leading-6 text-sm" id="post-content">
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
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const containers = document.querySelectorAll(
                '#post-content .ql-code-block-container'
            );

            containers.forEach(function (container) {
                // جلوگیری از ایجاد دکمه تکراری
                if (container.parentElement.classList.contains('code-block-wrapper')) {
                    return;
                }

                // ساخت محفظه بیرونی
                const wrapper = document.createElement('div');
                wrapper.className = 'code-block-wrapper';

                container.parentNode.insertBefore(wrapper, container);
                wrapper.appendChild(container);

                // ساخت دکمه کپی
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'copy-code-btn';
                button.textContent = 'کپی کد';
                button.setAttribute('aria-label', 'کپی کد برنامه‌نویسی');

                wrapper.insertBefore(button, container);

                button.addEventListener('click', async function () {
                    // هر div داخلی معمولاً یک خط کد است
                    const lines = Array.from(
                        container.querySelectorAll('.ql-code-block')
                    );

                    const code = lines.length
                        ? lines.map(line => line.textContent).join('\n')
                        : container.textContent;

                    try {
                        await copyText(code);

                        button.textContent = 'کپی شد ✓';

                        setTimeout(function () {
                            button.textContent = 'کپی کد';
                        }, 2000);
                    } catch (error) {
                        button.textContent = 'کپی ناموفق بود';
                    }
                });
            });

            async function copyText(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    try {
                        await navigator.clipboard.writeText(text);
                        return;
                    } catch (error) {
                        // استفاده از روش جایگزین
                    }
                }

                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';

                document.body.appendChild(textarea);
                textarea.select();

                const success = document.execCommand('copy');
                textarea.remove();

                if (!success) {
                    throw new Error('Copy failed');
                }
            }
        });
    </script>
@endsection
