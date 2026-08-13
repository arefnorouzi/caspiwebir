<section class=" mt-16 md:mt-20">
    <div class="container mx-auto px-2">
        <div class="flex flex-col items-center">

            <h3 class="text-lg md:leading-[50px] md:text-[40px] text-[#333] font-bold mt-6 text-center">تعرفه فروشگاه ساز</h3>
        </div>

        <div class="flex justify-center gap-3 md:mt-16 flex-col xl:flex-row items-start">
            @foreach($plans as $plan)
            <div class="mt-10  @if($plan->pinned) border-primary @else border border-[var(--main)] @endif pt-10 pb-10 md:pb-20 shadow-2xl rounded-2xl w-full md:w-4/5 xl:w-[470px]  bg-white">
                <div class="flex flex-col items-center">
                    @if($plan->pinned)
                        <span class="border border-[var(--secend)] text-[var(--secend)] rounded-full px-5 py-1">{{$plan->name}}</span>
                    @else
                        <span class="border border-[var(--main)] text-[var(--main)] rounded-full px-5 py-1">{{$plan->name}}</span>
                    @endif
                    @if($plan->offer_price)
                            <div class="flex flex-col items-center gap-3 mt-6 mb-10">
                                <span class="text-[#292D32] text-base">قیمت</span>
                                <span class="font-extrabold text-2xl text-[var(--secend)]">{{number_format($plan->offer_price)}}</span>
                                <s class="font-bold text-gray text-xl">{{number_format($plan->price)}}</s>
                                <span class="text-[#292D32] text-base">تومان</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center gap-3 mt-6 mb-10">
                                <span class="text-[#292D32] text-base">قیمت</span>
                                @if($plan->price == 0)
                                    <span class="font-extrabold text-[var(--secend)] text-2xl">رایگان</span>
                                @else
                                    <span class="font-extrabold text-2xl">{{number_format($plan->price)}}</span>
                                    <span class="text-[#292D32] text-base">تومان</span>

                                @endif

                            </div>
                    @endif

                    <div>
                        <ul class="flex flex-col gap-6">
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">فضای میزبانی نامحدود</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">پهنای باند نامحدود</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">بینهایت برند و دسته بندی</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">بینهایت محصول</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">خرید نقدی / آنلاین / اقساطی</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">سبد خرید / فاکتور / حواله</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">سیستم تخفیف تکی و گروهی</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">قابلیت اتصال به هلو و سپیدار</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">اتصال به ترب / ایمالز / ذره بین</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">امکان پیش سفارش</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">خرده فروشی / عمده فروشی</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">پنل کاربری / پنل همکار</p>
                            </li>
                            <li class="flex gap-4 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="44" viewBox="0 0 45 44" fill="none">
                                    <g opacity="0.2">
                                        <rect x="44" y="43" width="43" height="42" rx="11" transform="rotate(-180 44 43)" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.6974" y1="4.71673" x2="4.69736" y2="40.7167" stroke="#334679" stroke-width="2"/>
                                        <line x1="41.3225" y1="39.7355" x2="3.32253" y2="4.73555" stroke="#334679" stroke-width="2"/>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 22C11 18.8174 12.2643 15.7652 14.5147 13.5147C16.7652 11.2643 19.8174 10 23 10C26.1826 10 29.2348 11.2643 31.4853 13.5147C33.7357 15.7652 35 18.8174 35 22C35 25.1826 33.7357 28.2348 31.4853 30.4853C29.2348 32.7357 26.1826 34 23 34C19.8174 34 16.7652 32.7357 14.5147 30.4853C12.2643 28.2348 11 25.1826 11 22ZM22.3152 27.136L29.224 18.4992L27.976 17.5008L22.0848 24.8624L17.912 21.3856L16.888 22.6144L22.3152 27.136Z" fill="#1D7873"/>
                                </svg>
                                <p class="text-base text-[#161C2D]">میزبانی و پشتیبانی رایگان</p>
                            </li>
                        </ul>
                        <div class="flex justify-center mt-10">
                            <a href="/dashboard" class="text-base font-base inline-flex items-center ">
                                <span class="bg-white border border-[var(--secend)] text-[var(--secend)] w-full mx-auto px-7 md:px-0 md:w-[180px] justify-center py-3 rounded-lg text-center hover:bg-[var(--secend)] hover:text-white transition-all ease-in duration-100">همین حالا امتحان کن
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>
