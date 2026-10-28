@extends('layouts.IranMarket')

@section('title', $path['seo_title'])
@section('meta_description', $path['seo_description'])

@section('content')
<div dir="rtl" class="min-h-screen bg-slate-50 text-slate-800 mt-16">
    <section class="relative isolate overflow-hidden border-b border-red-100 bg-white">
        <div aria-hidden="true" class="absolute -left-24 -top-32 h-80 w-80 rounded-full bg-red-100/70 blur-3xl"></div>
        <div aria-hidden="true" class="absolute -right-24 top-10 h-72 w-72 rounded-full bg-rose-50 blur-3xl"></div>
        <div class="relative mx-auto grid max-w-7xl items-center gap-10 px-4 py-12 sm:px-6 sm:py-16 lg:grid-cols-[1.15fr_.85fr] lg:px-8 lg:py-20">
            <div>
                <div class="mb-5 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                    <a href="{{ url('/') }}" class="transition hover:text-red-700">خانه</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('learning-paths.index') }}" class="transition hover:text-red-700">مسیرهای یادگیری</a>
                    <span aria-hidden="true">/</span>
                    <span class="font-medium text-slate-700">{{ $path['title'] }}</span>
                </div>

                <p class="mb-3 inline-flex items-center gap-2 rounded-full border border-red-100 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 sm:text-sm">
                    <span class="h-2 w-2 rounded-full bg-red-600"></span>{{ $path['eyebrow'] }}
                </p>
                <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight text-slate-950 sm:text-4xl lg:text-5xl">
                    {{ $path['title'] }}
                    <span class="mt-2 block text-xl font-extrabold text-red-700 sm:text-2xl">{{ $path['english'] }}</span>
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">{{ $path['tagline'] }}</p>
                <p class="mt-4 max-w-2xl text-sm leading-8 text-slate-600 sm:text-base">{{ $path['intro'] }}</p>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                    <a href="{{ url($path['courses_url']) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-red-600/20 transition hover:-translate-y-0.5 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200">
                        مشاهده دوره‌های مرتبط <span aria-hidden="true">←</span>
                    </a>
                    <a href="#roadmap" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-bold text-slate-700 transition hover:border-red-200 hover:text-red-700 focus:outline-none focus:ring-4 focus:ring-slate-100">
                        دیدن نقشه راه یادگیری
                    </a>
                </div>
                <div class="mt-7 flex flex-wrap gap-x-5 gap-y-2 text-xs font-medium text-slate-500 sm:text-sm">
                    <span class="inline-flex items-center gap-2"><span class="text-red-600">✓</span> مسیر مرحله‌به‌مرحله</span>
                    <span class="inline-flex items-center gap-2"><span class="text-red-600">✓</span> پروژه‌های تمرینی</span>
                    <span class="inline-flex items-center gap-2"><span class="text-red-600">✓</span> مناسب برای خودآموزی</span>
                </div>
            </div>

            <div class="mx-auto w-full max-w-lg">
                <div class="relative overflow-hidden rounded-[2rem] border border-red-100 bg-gradient-to-br from-white via-rose-50 to-red-100 p-5 shadow-xl shadow-red-950/5 sm:p-7">
                    <div aria-hidden="true" class="absolute -right-8 -top-8 h-36 w-36 rounded-full border-[18px] border-red-200/60"></div>
                    <div aria-hidden="true" class="absolute -bottom-10 -left-6 h-40 w-40 rounded-full bg-red-200/40 blur-2xl"></div>
                    <div class="relative rounded-2xl border border-white/80 bg-white/90 p-5 shadow-sm sm:p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-500">نقشه راه</p>
                                <p class="mt-1 text-lg font-black text-slate-900">از یادگیری تا اجرا</p>
                            </div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-600 text-lg font-black text-white shadow-lg shadow-red-600/20">{{ $path['icon'] }}</div>
                        </div>
                        <div class="mt-5 space-y-3">
                            @foreach(array_slice($path['roadmap'], 0, 4) as $index => $step)
                                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white p-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-sm font-black text-red-700">{{ sprintf('%02d', $index + 1) }}</span>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-slate-800">{{ $step['title'] }}</p>
                                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-red-500" style="width: {{ 90 - ($index * 15) }}%"></div></div>
                                    </div>
                                    <span class="text-red-600" aria-hidden="true">✓</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-xs leading-6 text-slate-500">هر مرحله را با تمرین عملی تکمیل کنید و سپس به مرحله بعد بروید.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-6 px-4 py-12 sm:px-6 lg:grid-cols-3 lg:px-8">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-xl text-red-700">◎</div>
            <h2 class="text-lg font-extrabold text-slate-900">این مسیر برای چه کسانی است؟</h2>
            <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-600">
                @foreach($path['audience'] as $item)
                    <li class="flex gap-2"><span class="mt-1 text-red-600">•</span><span>{{ $item }}</span></li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-xl text-red-700">⌁</div>
            <h2 class="text-lg font-extrabold text-slate-900">پیش‌نیازها</h2>
            <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-600">
                @foreach($path['prerequisites'] as $item)
                    <li class="flex gap-2"><span class="mt-1 text-red-600">•</span><span>{{ $item }}</span></li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-xl text-red-700">↗</div>
            <h2 class="text-lg font-extrabold text-slate-900">در پایان چه چیزی یاد می‌گیرید؟</h2>
            <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-600">
                @foreach($path['outcomes'] as $item)
                    <li class="flex gap-2"><span class="mt-1 text-red-600">✓</span><span>{{ $item }}</span></li>
                @endforeach
            </ul>
        </div>
    </section>

    <section id="roadmap" class="scroll-mt-24 border-y border-slate-200 bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold text-red-700">نقشه راه پیشنهادی</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">چه مراحلی را طی کنید؟</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600 sm:text-base">این ترتیب کمک می‌کند مفاهیم را روی هم بسازید؛ سرعت پیشرفت به میزان تمرین و پیش‌زمینه شما بستگی دارد.</p>
            </div>
            <div class="relative mx-auto mt-10 grid max-w-5xl gap-4 md:grid-cols-2">
                @foreach($path['roadmap'] as $index => $step)
                    <article class="relative rounded-2xl border border-slate-200 bg-slate-50 p-6 transition hover:-translate-y-1 hover:border-red-200 hover:bg-white hover:shadow-lg hover:shadow-slate-900/5">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-red-600 text-lg font-black text-white shadow-md shadow-red-600/20">{{ sprintf('%02d', $index + 1) }}</span>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900">{{ $step['title'] }}</h3>
                                <p class="mt-2 text-sm leading-7 text-slate-600">{{ $step['text'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-[1fr_.85fr] lg:px-8">
        <div>
            <p class="text-sm font-bold text-red-700">یادگیری عملی</p>
            <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">با چه پروژه‌هایی تمرین کنید؟</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600">هر مبحث را با یک خروجی واقعی تثبیت کنید. لازم نیست از ابتدا پروژه‌ای بزرگ بسازید؛ نسخه ساده را کامل کنید و بعد قابلیت‌های بیشتری اضافه کنید.</p>
            <div class="mt-6 space-y-3">
                @foreach($path['projects'] as $index => $project)
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-sm font-black text-red-700">{{ $index + 1 }}</span>
                        <p class="text-sm font-bold leading-6 text-slate-800">{{ $project }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <aside class="rounded-3xl bg-slate-950 p-6 sm:p-8">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-600 text-xl font-black">{{ $path['icon'] }}</div>
            <h2 class="mt-5 text-xl font-black">مطالبی که بهتر است در کنار آموزش بخوانید</h2>
            <p class="mt-2 text-sm leading-7 text-slate-300">این موضوع‌ها می‌توانند برای مقاله‌های مکمل یا تمرین‌های کوتاه شما استفاده شوند.</p>
            <ul class="mt-5 space-y-3">
                @foreach($path['articles'] as $article)
                    <li class="flex gap-3 text-sm leading-6 text-slate-200"><span class="text-red-400">↗</span><span>{{ $article }}</span></li>
                @endforeach
            </ul>
            <a href="{{ url($path['courses_url']) }}" class="mt-7 inline-flex w-full items-center justify-center rounded-xl bg-white px-5 py-3.5 text-sm font-extrabold text-red-700 transition hover:bg-red-50">مشاهده دوره‌های مرتبط</a>
        </aside>
    </section>

    <section class="border-t border-slate-200 bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-sm font-bold text-red-700">پرسش‌های متداول</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">پیش از شروع بدانید</h2>
            </div>
            <div class="mt-8 space-y-3">
                @foreach($path['faq'] as $faq)
                    <details class="group rounded-2xl border border-slate-200 bg-slate-50 p-5 open:border-red-200 open:bg-white">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-sm font-extrabold leading-7 text-slate-900 sm:text-base">
                            <span>{{ $faq['q'] }}</span>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-lg text-red-700 shadow-sm transition group-open:rotate-45">+</span>
                        </summary>
                        <p class="mt-3 border-t border-slate-100 pt-3 text-sm leading-8 text-slate-600">{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 rounded-3xl bg-gradient-to-l from-red-700 to-red-600 p-7 text-white shadow-xl shadow-red-900/15 sm:p-10 lg:flex-row lg:items-center">
            <div class="max-w-2xl">
                <p class="text-sm font-bold text-red-100">قدم بعدی</p>
                <h2 class="mt-2 text-2xl font-black sm:text-3xl">یادگیری را با یک پروژه شروع کنید</h2>
                <p class="mt-3 text-sm leading-7 text-red-50 sm:text-base">موضوع‌ها را به ترتیب جلو ببرید، هر مرحله را تمرین کنید و برای عمیق‌تر شدن سراغ دوره‌های مرتبط بروید.</p>
            </div>
            <a href="{{ url($path['courses_url']) }}" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-white px-6 py-3.5 text-sm font-extrabold text-red-700 transition hover:bg-red-50">مشاهده آموزش‌ها <span class="mr-2" aria-hidden="true">←</span></a>
        </div>
    </section>
</div>

@php
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(function ($faq) {
            return [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
            ];
        }, $path['faq']),
    ];
@endphp
<script type="application/ld+json">@json($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
@endsection
