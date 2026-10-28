@extends('layouts.IranMarket')

@section('title', 'مسیرهای یادگیری برنامه‌نویسی و طراحی وب | مارلیک افزار کاسپین')
@section('meta_description', 'مسیرهای یادگیری مارلیک افزار کاسپین؛ از پایتون، PHP و لاراول تا جاوااسکریپت، وردپرس، Docker، دیتابیس، لینوکس و سئو.')

@section('content')
<div dir="rtl" class="min-h-screen bg-slate-50 text-slate-800 mt-16">
    <section class="relative overflow-hidden border-b border-red-100 bg-white">
        <div aria-hidden="true" class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-red-100/80 blur-3xl"></div>
        <div aria-hidden="true" class="absolute -right-16 bottom-0 h-64 w-64 rounded-full bg-rose-50 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-14 text-center sm:px-6 sm:py-20 lg:px-8">
            <span class="inline-flex items-center gap-2 rounded-full border border-red-100 bg-red-50 px-4 py-2 text-xs font-bold text-red-700 sm:text-sm"><span class="h-2 w-2 rounded-full bg-red-600"></span>دانش را مرحله‌به‌مرحله بسازید</span>
            <h1 class="mx-auto mt-5 max-w-4xl text-3xl font-black leading-tight tracking-tight text-slate-950 sm:text-4xl lg:text-5xl">مسیر یادگیری مناسب خودت را پیدا کن</h1>
            <p class="mx-auto mt-5 max-w-3xl text-sm leading-8 text-slate-600 sm:text-lg">برای هر موضوع، پیش‌نیازها، ترتیب پیشنهادی مباحث، پروژه‌های تمرینی و پرسش‌های رایج را ببین و با برنامه روشن‌تری یادگیری را شروع کن.</p>
            <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ url('/shop/courses') }}" class="inline-flex items-center justify-center rounded-xl bg-red-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-red-600/20 transition hover:bg-red-700">مشاهده همه دوره‌ها</a>
                <a href="#paths" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-sm font-bold text-slate-700 transition hover:border-red-200 hover:text-red-700">انتخاب موضوع</a>
            </div>
        </div>
    </section>

    <section id="paths" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold text-red-700">کتابخانه مسیرها</p>
                <h2 class="mt-2 text-2xl font-black text-slate-950 sm:text-3xl">از کدام موضوع شروع می‌کنی؟</h2>
            </div>
            <p class="max-w-xl text-sm leading-7 text-slate-500">موضوعی را انتخاب کن که با هدف فعلی تو هماهنگ است؛ لازم نیست همه مسیرها را هم‌زمان دنبال کنی.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($paths as $path)
                <article class="group flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-900/5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex h-14 min-w-14 items-center justify-center rounded-2xl bg-red-50 px-3 text-lg font-black text-red-700 transition group-hover:bg-red-600 group-hover:text-white">{{ $path['icon'] }}</div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">مسیر یادگیری</span>
                    </div>
                    <h3 class="mt-5 text-xl font-black text-slate-900">{{ $path['title'] }}</h3>
                    <p class="mt-1 text-xs font-semibold text-red-700">{{ $path['english'] }}</p>
                    <p class="mt-4 flex-1 text-sm leading-7 text-slate-600">{{ $path['tagline'] }}</p>
                    <div class="mt-5 border-t border-slate-100 pt-4">
                        <a href="{{ route('learning-paths.show', $path['slug']) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 px-4 py-3 text-sm font-extrabold text-red-700 transition hover:bg-red-600 hover:text-white">
                            مشاهده نقشه راه <span aria-hidden="true" class="transition group-hover:-translate-x-1">←</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-5 rounded-3xl bg-slate-950 p-7 text-white sm:p-10 lg:flex-row lg:items-center">
            <div class="max-w-2xl">
                <h2 class="text-2xl font-black">هنوز نمی‌دانی کدام مسیر مناسب توست؟</h2>
                <p class="mt-3 text-sm leading-7 text-slate-300">از هدف نهایی شروع کن: طراحی رابط وب، توسعه بک‌اند، مدیریت سرور یا جذب مخاطب از طریق محتوا و سئو.</p>
            </div>
            <a href="{{ url('/shop/courses') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-red-600 px-6 py-3.5 text-sm font-extrabold text-white transition hover:bg-red-700">مرور دوره‌ها <span class="mr-2" aria-hidden="true">←</span></a>
        </div>
    </section>
</div>
@endsection
