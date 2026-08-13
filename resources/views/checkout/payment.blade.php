@extends('layouts.ModKala')
@section('title', 'پرداخت فاکتور')
@section('content')

    <main class="max-w-[1500px] mx-auto px-3 md:px-5 mt-44 md:mt-32">
        <!-- top cart -->
        <div class="container mx-auto w-full h-full pt-9">
            <div class="relative pl-3 h-full">
                <div class="flex pt-3 *:border-2 md:*:border-4">
                    <div class="border-opacity-90 border-green-500 w-1/4"></div>
                    <div class="border-opacity-90 border-green-500 w-1/4"></div>
                    <div class="border-opacity-90 border-gray-300 w-1/4"></div>
                    <div class="border-opacity-90 border-gray-300 w-1/4"></div>
                </div>
                <!-- text -->
                <div class="absolute -top-10 inline-flex w-full justify-between">
                    <!-- not -->
                    <div class="">
                        <div class="w-8 h-8">
                        </div>
                    </div>
                    <!-- 1 -->
                    <div class="flex items-center">
                        <div class="z-20 flex items-center order-1">
                            <h1 class="mx-auto md:font-semibold text-zinc-500 pr-6 text-xs md:text-base">سبد خرید</h1>
                        </div>
                    </div>
                    <!-- 2 -->
                    <div class="flex items-center">
                        <div class="z-20 flex items-center order-1">
                            <h1 class="mx-auto md:font-semibold text-zinc-700 pr-4 text-xs md:text-base">جزئیات پرداخت</h1>
                        </div>
                    </div>
                    <!-- 3 -->
                    <div class="flex items-center">
                        <div class="z-20 flex items-center order-1">
                            <h1 class="mx-auto md:font-semibold text-zinc-500 pr-1 pl-2 text-xs md:text-base">تکمیل سفارش</h1>
                        </div>
                    </div>
                    <!-- not -->
                    <div class="pl-3">
                        <div class="w-8 h-8">
                        </div>
                    </div>
                </div>
                <!-- dots -->
                <div class="absolute top-0 md:-top-1 inline-flex w-full justify-between">
                    <!-- not -->
                    <div class="flex items-center *:w-6 *:h-6 md:*:w-8 *:md:h-8">
                        <div class="z-20 flex items-center order-1 bg-gray-200 shadow-box-md rounded-full">
                            <h1 class="mx-auto font-semibold text-lg text-zinc-700"></h1>
                        </div>
                    </div>
                    <!-- 1 -->
                    <div class="flex items-center *:w-6 *:h-6 md:*:w-8 *:md:h-8">
                        <div class="z-20 flex items-center order-1 bg-white shadow-box-md rounded-full">
                            <h1 class="mx-auto font-semibold text-base md:text-lg text-zinc-700">1</h1>
                        </div>
                    </div>
                    <!-- 2 -->
                    <div class="flex items-center *:w-6 *:h-6 md:*:w-8 *:md:h-8">
                        <div class="z-20 flex items-center order-1 bg-green-400 shadow-box-md rounded-full">
                            <h1 class="mx-auto font-semibold text-base md:text-lg text-white">2</h1>
                        </div>
                    </div>
                    <!-- 3 -->
                    <div class="flex items-center *:w-6 *:h-6 md:*:w-8 *:md:h-8">
                        <div class="z-20 flex items-center order-1 bg-white shadow-box-md rounded-full">
                            <h1 class="mx-auto font-semibold text-base md:text-lg text-zinc-700">3</h1>
                        </div>
                    </div>
                    <!-- not -->
                    <div class="flex items-center pl-3 *:w-6 *:h-6 md:*:w-8 *:md:h-8">
                        <div class="z-20 flex items-center order-1 bg-gray-200 shadow-box-md rounded-full">
                            <h1 class="mx-auto font-semibold text-lg text-zinc-700"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main -->
        <div id="vueapp" class="my-8 lg:my-10 py-5 lg:px-20 md:flex gap-5">
            <div class="md:w-8/12 bg-white shadow-box-md rounded-xl py-5 px-2 sm:px-6">
                <!-- name -->
                <div class="text-zinc-800 text-lg font-semibold">
                    جزئیات پرداخت
                </div>
                <!-- inputs -->
                <div class="sm:flex gap-x-5 mt-5">
                    <div class="sm:w-1/2 mb-2 sm:mb-0 flex flex-col gap-y-1">
                        <label class="text-sm text-zinc-700 flex">
                            نام و نام خانوادگی
                            <svg class="fill-red-500" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#4d4d4d" viewBox="0 0 256 256"><path d="M210.23,101.57l-72.6,29,51.11,65.71a6,6,0,0,1-9.48,7.36L128,137.77,76.74,203.68a6,6,0,1,1-9.48-7.36l51.11-65.71-72.6-29a6,6,0,1,1,4.46-11.14L122,119.14V40a6,6,0,0,1,12,0v79.14l71.77-28.71a6,6,0,1,1,4.46,11.14Z"></path></svg>
                        </label>
                        <input type="text" name="name" v-model="form.name" class="focus:shadow-primary-outline text-sm leading-5.6 block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-red-300 focus:outline-none">
                    </div>
                    <div class="sm:w-1/2 flex flex-col gap-y-1">
                        <label class="text-sm text-zinc-700 flex">
                            شماره موبایل (11 رقمی)
                            <svg class="fill-red-500" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#4d4d4d" viewBox="0 0 256 256"><path d="M210.23,101.57l-72.6,29,51.11,65.71a6,6,0,0,1-9.48,7.36L128,137.77,76.74,203.68a6,6,0,1,1-9.48-7.36l51.11-65.71-72.6-29a6,6,0,1,1,4.46-11.14L122,119.14V40a6,6,0,0,1,12,0v79.14l71.77-28.71a6,6,0,1,1,4.46,11.14Z"></path></svg>
                        </label>
                        <input type="text" name="mobile" v-model="form.mobile" class="focus:shadow-primary-outline text-sm leading-5.6 block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-red-300 focus:outline-none">
                    </div>
                </div>
                <div class="sm:flex gap-x-5 mt-7">
                    <div class="sm:w-1/2 mb-2 sm:mb-0 flex flex-col gap-y-1">
                        <label class="text-sm text-zinc-700 flex">
                            استان
                            <svg class="fill-red-500" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#4d4d4d" viewBox="0 0 256 256"><path d="M210.23,101.57l-72.6,29,51.11,65.71a6,6,0,0,1-9.48,7.36L128,137.77,76.74,203.68a6,6,0,1,1-9.48-7.36l51.11-65.71-72.6-29a6,6,0,1,1,4.46-11.14L122,119.14V40a6,6,0,0,1,12,0v79.14l71.77-28.71a6,6,0,1,1,4.46,11.14Z"></path></svg>
                        </label>
                        <select name="province_id" v-model="form.province_id" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                            <option value="{{null}}" selected>انتخاب استان</option>
                            @foreach($provinces as $province)
                                <option @if($province->id == $user?->province_id) selected @endif
                                value="{{$province->id}}">{{$province->name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="sm:w-1/2 flex flex-col gap-y-1">
                        <label class="text-sm text-zinc-700 flex">
                            شهر
                            <svg class="fill-red-500" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#4d4d4d" viewBox="0 0 256 256"><path d="M210.23,101.57l-72.6,29,51.11,65.71a6,6,0,0,1-9.48,7.36L128,137.77,76.74,203.68a6,6,0,1,1-9.48-7.36l51.11-65.71-72.6-29a6,6,0,1,1,4.46-11.14L122,119.14V40a6,6,0,0,1,12,0v79.14l71.77-28.71a6,6,0,1,1,4.46,11.14Z"></path></svg>
                        </label>
                        <input type="text" name="city" v-model="form.city" class="focus:shadow-primary-outline text-sm leading-5.6 block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-red-300 focus:outline-none">

                    </div>
                </div>
                <div class="mt-7">
                    <div class="flex flex-col gap-y-1">
                        <label class="text-sm text-zinc-700 flex">
                            آدرس تحویل گیرنده
                            <svg class="fill-red-500" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#4d4d4d" viewBox="0 0 256 256"><path d="M210.23,101.57l-72.6,29,51.11,65.71a6,6,0,0,1-9.48,7.36L128,137.77,76.74,203.68a6,6,0,1,1-9.48-7.36l51.11-65.71-72.6-29a6,6,0,1,1,4.46-11.14L122,119.14V40a6,6,0,0,1,12,0v79.14l71.77-28.71a6,6,0,1,1,4.46,11.14Z"></path></svg>
                        </label>
                        <input type="text" v-model="form.address" name="address" minlength="2" maxlength="250" class="focus:shadow-primary-outline text-sm leading-5.6 block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-red-300 focus:outline-none">
                    </div>
                </div>

                <div class="sm:flex gap-x-5 mt-7">
                    <div class="sm:w-1/2 mb-2 sm:mb-0 flex flex-col gap-y-1">
                        <label class="text-sm text-zinc-700 flex">
                            کد پستی
                            <svg class="fill-red-500" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#4d4d4d" viewBox="0 0 256 256"><path d="M210.23,101.57l-72.6,29,51.11,65.71a6,6,0,0,1-9.48,7.36L128,137.77,76.74,203.68a6,6,0,1,1-9.48-7.36l51.11-65.71-72.6-29a6,6,0,1,1,4.46-11.14L122,119.14V40a6,6,0,0,1,12,0v79.14l71.77-28.71a6,6,0,1,1,4.46,11.14Z"></path></svg>
                        </label>
                        <input type="text" name="zip_code" v-model="form.zip_code" minlength="10" maxlength="10"
                               class="focus:shadow-primary-outline text-sm leading-5.6 block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-red-300 focus:outline-none">

                    </div>
                    <div class="sm:w-1/2 flex flex-col gap-y-1">
                        <label class="text-sm text-zinc-700 flex">
                            یادداشت مشتری
                        </label>
                        <textarea placeholder="نکاتی درباره نحوه تحویل محصول" name="mailTicket" cols="30" rows="7" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-red-400 focus:outline-none"></textarea>

                    </div>
                </div>

                <div class="sm:flex gap-x-5 mt-7">
                    <table class="text-right w-full table-auto min-w-max text-sm text-gray-600">
                        <thead>
                        <tr>
                            <th class="p-2 border border-slate-300 bg-slate-50">ردیف</th>
                            <th class="p-2 border border-slate-300 bg-slate-50">محصول</th>
                            <th class="p-2 border border-slate-300 bg-slate-50 text-center">تعداد</th>
                            <th class="p-2 border border-slate-300 bg-slate-50 text-center">قیمت</th>
                        </tr>
                        </thead>
                        <tbody v-if="cart_items">
                        <tr v-for="(item, i) in cart_items" :key="i">
                            <td class="p-2 border border-slate-200">@{{ i + 1 }}</td>
                            <td class="p-2 border border-slate-200">@{{ item.name }}</td>
                            <td class="p-2 border border-slate-200 text-center">@{{ item.qty }}</td>
                            <td class="p-2 border border-slate-200 text-center">@{{ Number(item.unit_price).toLocaleString() }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>
            <div class="md:w-4/12 mt-8 md:mt-0">
                <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm mb-5">
                    <div class="flex gap-x-1 items-center text-zinc-700 border-b pb-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#d02525" viewBox="0 0 256 256"><path d="M232,96v96a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V96Z" opacity="0.2"></path><path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z"></path></svg>
                        نحوه پرداخت
                    </div>
                    <ul class="grid w-full gap-3">
                        <li v-for="(payment_method, pm) in payment_methods" :key="pm" @click="changePaymentMethod(payment_method)">
                            <input type="radio" :id="`pm-${payment_method.id}`" v-model="form.payment_method_id" name="pey" :value="payment_method.id" class="hidden peer" required>
                            <label :for="`pm-${payment_method.id}`" class="flex items-center justify-start gap-x-2 w-full p-2 text-gray-600 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-400 peer-checked:text-red-400 hover:text-gray-600 hover:bg-gray-100">
                                <svg class="max-w-12" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#d02525" viewBox="0 0 256 256"><path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z"></path></svg>
                                <div class="text-center">
                                    <span class="text-sm">@{{ payment_method.name }} </span>
                                </div>
                            </label>
                        </li>
                    </ul>
                    <div v-if="payment_description" class="my-2 p-2 border bg-blue-100 text-blue-600 text-sm rounded-md">
                        @{{ payment_description }}
                    </div>
                </div>
                <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm">
                    <div class="flex gap-x-1 items-center text-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#d02525" viewBox="0 0 256 256"><path d="M223.92,208H32.08a8,8,0,0,1-8-8.93l14.25-120a8.06,8.06,0,0,1,8-7.07H209.67a8.06,8.06,0,0,1,8,7.07l14.25,120A8,8,0,0,1,223.92,208Z" opacity="0.2"></path><path d="M239.89,198.12l-14.26-120a16,16,0,0,0-16-14.12H176a48,48,0,0,0-96,0H46.33a16,16,0,0,0-16,14.12l-14.26,120A16,16,0,0,0,20,210.6a16.13,16.13,0,0,0,12,5.4H223.92A16.13,16.13,0,0,0,236,210.6,16,16,0,0,0,239.89,198.12ZM128,32a32,32,0,0,1,32,32H96A32,32,0,0,1,128,32ZM32,200,46.33,80H80v24a8,8,0,0,0,16,0V80h64v24a8,8,0,0,0,16,0V80h33.75l14.17,120Z"></path></svg>            سبد شما
                    </div>
                    <div class="flex gap-x-1 justify-between items-center text-zinc-600 mt-5 bg-gray-100 rounded-lg px-2 py-3 text-sm">
                        <div>
                            قیمت کالاها (
                            {{ count($invoice->items) }}
                            )
                        </div>
                        <div class="flex gap-x-1">
                            <div>
                                {{number_format($invoice->sub_total)}}
                            </div>
                            <div>
                                تومان
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-x-1 justify-between items-center text-zinc-600 mt-3 bg-gray-100 rounded-lg px-2 py-3 text-sm">
                        <div>
                            تخفیف
                        </div>
                        <div class="flex gap-x-1">
                            <div>
                                {{number_format($invoice->discount)}}
                            </div>
                            <div>
                                تومان
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-x-1 justify-between items-center text-zinc-600 mt-3 bg-gray-100 rounded-lg px-2 py-3 text-sm">
                        <div>
                            هزینه ارسال
                        </div>
                        <div class="flex gap-x-1">
                            <div>
                                {{number_format($invoice->shipping_cost)}}
                            </div>
                            <div>
                                تومان
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-x-1 justify-between items-center text-zinc-800 mt-3 bg-gray-100 rounded-lg px-2 py-3 text-sm">
                        <div>
                            قابل پرداخت
                        </div>
                        <div class="flex gap-x-1">
                            <div>
                                {{number_format($invoice->amount)}}
                            </div>
                            <div>
                                تومان
                            </div>
                        </div>
                    </div>
                    <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm">
                        <div v-if="validation_errors" class="border border-red-200 bg-red-100 rounded-md text-red-500 p-2">
                            <p class="mb-1 font-bold">اطلاعات وارد شده برای فیلدهای زیر نادرست است. لطفا بعداز اصلاح مجدد درخواست ارسال نمایید.</p>

                            <p v-for="(validation_error, key) in validation_errors" :key="key"
                               class="mb-2">@{{validation_error[0]}}</p>
                        </div>
                    </div>
                    <button
                        @click="generateOrder"
                        class="mx-auto w-full px-2 py-3 mt-5 text-sm bg-red-500 hover:bg-red-400 transition text-gray-100 rounded-lg">
                        تایید و پرداخت
                    </button>
                </div>
            </div>
            <div v-else class="md:w-4/12 mt-8 md:mt-0">
                <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm mb-5">
                    <div class="flex gap-x-1 items-center text-zinc-700 border-b pb-2 mb-4">
                        سبد خرید خالی است
                    </div>

                </div>
                <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm mb-5">
                    <div class="my-2 p-2 border border-red-500 text-red-600 text-sm rounded-md">
                        هیچ محصولی در سبد خریدت وجود نداره. به صفحه فروشگاه برگرد و محصولات مورد نظرتو به سبد خریدت اضافه کن
                    </div>
                </div>
                <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm">
                    <a href="/shop">
                        <button
                            class="mx-auto w-full px-2 py-3 mt-5 text-sm bg-green-600 hover:bg-green-500
                             transition text-gray-100 rounded-lg">
                            بازگشت به فروشگاه
                        </button>
                    </a>

                </div>
            </div>

    </main>


@endsection
@section('script')
    <script src="/js/vue.global.js"></script>
    <script>
        const { createApp, ref } = Vue

        const csrf_token = document.querySelector('meta[name="csrf-token"]').content

        createApp({
            data(){
                return{
                    payment_description: '',
                    validation_errors: null,
                    form: {
                        payment_method_id: {{$invoice->payment_method_id ?? 1}},
                        invoice_id: {{$invoice->id}}
                    }
                }
            },
            mounted(){

            },
            methods:{
                changePaymentMethod(payment_method){
                    this.form.payment_method_id = payment_method.id;
                    this.payment_description = payment_method.description;
                },
                async generateOrder(){
                    this.validation_errors = null
                    const requestOptions = {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json", "Accept": "application/json",
                            "X-CSRF-TOKEN": csrf_token
                        },
                        body: JSON.stringify(this.form)
                    };

                    fetch("{{route('generate_order')}}", requestOptions)
                        .then(async response => {
                            const data = await response.json()
                            // check for error response
                            if (response.ok) {
                                this.show_toast('فاکتور با موفقیت ایجاد شد. درحال انتقال به صفحه پرداخت', 'success');
                                await this.sleep(2000);
                                window.location.replace("/checkout/" + data.uuid)
                            }
                            else {
                                if (data?.errors)
                                {
                                    this.validation_errors = data?.errors
                                }
                                this.show_toast('خطا در صدور فاکتور رخ داد. لطفا دوباره تلاش نمایید.', 'error');
                            }

                        })
                        .catch(error => {
                            console.log(error)
                            if (error?.response?.data?.errors)
                            {
                                this.validation_errors = error.response.data.errors
                            }
                            this.show_toast('خطا در صدور فاکتور رخ داد. لطفا دوباره تلاش نمایید.', 'error');
                        });
                },
                show_toast(message, type = "success") {
                    const colors = {
                        success: '#16a34a', // green-600
                        error:   '#dc2626', // red-600
                        info:    '#0ea5e9', // sky-500
                        warning: '#f59e0b'  // amber-500
                    };

                    const icons = {
                        success: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>`,
                        error:   `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M12 9v4m0 4h.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.73 3h16.9a2 2 0 0 0 1.73-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="white" stroke-width="0" fill="rgba(255,255,255,0.06)"/>
              </svg>`,
                        info:    `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M12 8h.01M11 12h1v4h1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>`,
                        warning: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.73 3h16.9a2 2 0 0 0 1.73-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 9v4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>`
                    };

                    const bg = colors[type] ?? colors.info;
                    const icon = icons[type] ?? icons.info;

                    // create toast wrapper
                    const toast = document.createElement('div');
                    toast.setAttribute('role', 'status');
                    toast.style.position = 'fixed';
                    toast.style.top = '20px';
                    toast.style.left = '20px';
                    toast.style.zIndex = 99999;
                    toast.style.minWidth = '220px';
                    toast.style.maxWidth = '360px';
                    toast.style.color = '#fff';
                    toast.style.backgroundColor = bg;              // inline color => avoids class override
                    toast.style.padding = '12px 14px';
                    toast.style.borderRadius = '10px';
                    toast.style.boxShadow = '0 8px 24px rgba(0,0,0,0.15)';
                    toast.style.display = 'flex';
                    toast.style.flexDirection = 'column';
                    toast.style.gap = '8px';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(10px)';
                    toast.style.transition = 'opacity .25s ease, transform .25s ease';

                    // inner content (icon + message)
                    const row = document.createElement('div');
                    row.style.display = 'flex';
                    row.style.alignItems = 'center';
                    row.style.gap = '10px';

                    const iconWrapper = document.createElement('div');
                    iconWrapper.innerHTML = icon;
                    iconWrapper.style.flex = '0 0 18px';
                    iconWrapper.style.display = 'flex';
                    iconWrapper.style.alignItems = 'center';

                    const msg = document.createElement('div');
                    msg.style.flex = '1';
                    msg.style.fontSize = '14px';
                    msg.style.lineHeight = '1.3';
                    msg.innerText = message;

                    row.appendChild(iconWrapper);
                    row.appendChild(msg);
                    toast.appendChild(row);

                    // progress bar
                    const progress = document.createElement('div');
                    progress.style.height = '4px';
                    progress.style.width = '100%';
                    progress.style.background = 'rgba(255,255,255,0.18)';
                    progress.style.borderRadius = '4px';
                    progress.style.overflow = 'hidden';

                    const progressInner = document.createElement('div');
                    progressInner.style.height = '100%';
                    progressInner.style.width = '0%';
                    progressInner.style.background = 'rgba(255,255,255,0.95)';
                    progressInner.style.transition = 'width linear';
                    progressInner.style.borderRadius = '4px';

                    progress.appendChild(progressInner);
                    toast.appendChild(progress);

                    document.body.appendChild(toast);

                    // show
                    requestAnimationFrame(() => {
                        toast.style.opacity = '1';
                        toast.style.transform = 'translateY(0)';
                    });

                    // animate progress fill over duration
                    const duration = 3000; // ms
                    setTimeout(() => {
                        progressInner.style.transitionDuration = duration + 'ms';
                        progressInner.style.width = '100%';
                    }, 50);

                    // hide after duration
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateY(10px)';
                        // remove after transition
                        setTimeout(() => toast.remove(), 300);
                    }, duration + 200);
                },
                async sleep(ms){
                    return new Promise(resolve => setTimeout(resolve, ms));
                }
            }
        }).mount('#vueapp')
    </script>
@endsection
