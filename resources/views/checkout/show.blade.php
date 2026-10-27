@extends('layouts.IranMarket')
@section('title', 'پرداخت فاکتور')
@section('page_meta')
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">
    <style>
        #snapp_gateway{
            display: flex; flex-direction: row; width: 50%; margin-left: 1rem;
            align-items: flex-start; padding: 1rem; gap: 16px;
        }
        .snapp-icon{width: 40px; height: 40px;}
        @media only screen and (max-width: 920px) {
            #snapp_gateway{
                gap: 12px;
            }
            .snapp-icon{width: 32px; height: 32px;}
        }
    </style>
@endsection
@section('content')

    <main class="max-w-[1500px] mx-auto px-3 py-5 md:px-5">
        <!-- top cart -->
        @if(session()->has('message') || session()->has('error'))

            @if (session()->has('message'))
                <div class="bg-green-100 text-green-600 rounded-md p-2">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="text-red-600 bg-red-100 rounded-md p-2">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                @foreach($errors->all() as $error)
                    <div class="bg-red-100 rounded-md p-2">
                        <p class="mb-1 text-red-800">{{ $error }}</p>
                    </div>
                @endforeach
            @endif
        @endif

        <!-- main -->
        <div id="vueapp" class="my-2  py-5 lg:px-20 md:flex gap-5">
            <div class="w-full bg-white shadow-box-md rounded-xl py-5 px-2 sm:px-6">
                <!-- name -->
                <div class="text-zinc-800 text-lg font-semibold">
                    <span>شماره فاکتور: </span> <strong>{{$invoice->id}}</strong>
                </div>
                <!-- inputs -->
                <div class="sm:flex gap-x-5 mt-5">
                    <div class="sm:w-1/2 mb-2 sm:mb-0 flex flex-col gap-y-1">
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>نام مشتری: </span><strong>{{$invoice->customer_name}}</strong>
                        </p>
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>موبایل مشتری: </span><strong>{{$invoice->customer_mobile}}</strong>
                        </p>
                        <div class="p-2 border border-gray-200 rounded-md mb-2 flex">
                            <p class="me-2">تاریخ: </p><p class="ms-2 px-2"  style="direction: ltr; text-align: right">{{verta($invoice->created_at)->format('Y-m-d')}}</p>
                        </div>
                        <div class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>وضعیت: </span>
                            @if($invoice->payment_status)
                                <strong class="text-green-700">پرداخت شده</strong>
                            @else
                                <strong class="text-red-500">در انتظار پرداخت</strong>
                            @endif
                        </div>


                    </div>

                    <div class="sm:w-1/2 mb-2 sm:mb-0 flex flex-col gap-y-1">
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>جمع سفارش: </span><strong>{{number_format($invoice->sub_total)}} تومان</strong>
                        </p>
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>هزینه ارسال: </span><strong>{{number_format($invoice->shipping_cost)}} تومان</strong>
                        </p>
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>مالیات: </span><strong>{{number_format($invoice->tax)}} تومان</strong>
                        </p>
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>کارمزد: </span><strong>{{number_format($invoice->interest_amount)}} تومان</strong>
                        </p>
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>تخفیف: </span><strong class="text-red-500">{{number_format($invoice->discount)}} تومان</strong>
                        </p>
                        <p class="p-2 border border-gray-200 rounded-md mb-2">
                            <span>قابل پرداخت: </span><strong class="text-green-500">{{number_format($invoice->amount + $invoice->interest_amount)}} تومان</strong>
                        </p>

                    </div>
                </div>



                <div class="mt-5">
                    <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm mb-5">
                        <div class="flex gap-x-1 items-center text-zinc-700 border-b pb-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#d02525" viewBox="0 0 256 256"><path d="M232,96v96a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V96Z" opacity="0.2"></path><path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z"></path></svg>
                            نحوه پرداخت
                        </div>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
                            <li v-for="(payment_method, pm) in payment_methods" :key="pm"
                                @click="changePaymentMethod(payment_method)">
                                <input type="radio" :id="`pm-${payment_method.id}`" v-model="form.payment_method_id" name="pey" :value="payment_method.id" class="hidden peer" required>
                                <label :for="`pm-${payment_method.id}`" class="flex items-center justify-start gap-x-2 w-[150px] p-2 text-gray-600 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-400 peer-checked:text-red-400 hover:text-gray-600 hover:bg-gray-100">
                                    <img v-if="payment_method.image" :src="payment_method.image"
                                         class="payment-method-icon"
                                    >
                                    <div class="text-center">
                                        <span class="text-sm payment-method-name">@{{ payment_method.name }} </span>
                                    </div>
                                </label>
                            </li>
                            @if($snapp_gateway)
                            <li :key="snapp_pay" class="border border-gray-200 rounded-lg"
                                @click="check_eligible()">
                                <input type="radio" id="pm-{{$snapp_gateway->id}}" v-model="form.payment_method_id" name="pey" value="{{$snapp_gateway->id}}" class="hidden peer" required>
                                <label for="pm-{{$snapp_gateway->id}}" class="flex items-center justify-start gap-x-2 w-[150px] p-2 text-gray-600 bg-white  cursor-pointer peer-checked:border-red-400 peer-checked:text-red-400 hover:text-gray-600 hover:bg-gray-100">
                                    <img src="{{$snapp_gateway->image}}"
                                         class="snapp-icon"
                                    >
                                    <div class="text-center">
                                        <span class="text-sm payment-method-name">{{ $snapp_gateway->name }} </span>
                                    </div>

                                </label>
                                <div class="w-full mr-10">
                                    <p class="text-xs">@{{snapp_title_message}}</p>
                                    <small class="text-xs">@{{snapp_description}}</small>
                                </div>
                            </li>
                            @endif
                        </ul>
                        <div v-if="payment_description" class="my-2 p-2 border bg-blue-100 text-blue-600 text-sm rounded-md">
                            <div v-html="payment_description"></div>
                        </div>

                    </div>
                    <div class="px-2 sm:px-6 py-3 bg-white rounded-xl shadow-box-sm">
                        <div class="flex gap-x-1 items-center text-zinc-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#d02525" viewBox="0 0 256 256"><path d="M223.92,208H32.08a8,8,0,0,1-8-8.93l14.25-120a8.06,8.06,0,0,1,8-7.07H209.67a8.06,8.06,0,0,1,8,7.07l14.25,120A8,8,0,0,1,223.92,208Z" opacity="0.2"></path><path d="M239.89,198.12l-14.26-120a16,16,0,0,0-16-14.12H176a48,48,0,0,0-96,0H46.33a16,16,0,0,0-16,14.12l-14.26,120A16,16,0,0,0,20,210.6a16.13,16.13,0,0,0,12,5.4H223.92A16.13,16.13,0,0,0,236,210.6,16,16,0,0,0,239.89,198.12ZM128,32a32,32,0,0,1,32,32H96A32,32,0,0,1,128,32ZM32,200,46.33,80H80v24a8,8,0,0,0,16,0V80h64v24a8,8,0,0,0,16,0V80h33.75l14.17,120Z"></path></svg>
                            اطلاعات پرداخت
                        </div>
                        <div class="flex gap-x-1 justify-between items-center text-zinc-600 mt-3 bg-gray-100 rounded-lg px-2 py-3 text-sm">
                            <div>
                                درگاه انتخاب شده
                            </div>
                            <div class="flex gap-x-1">
                                <div>
                                    @{{payment_method_name}}
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-x-1 justify-between items-center text-zinc-600 mt-3 bg-gray-100 rounded-lg px-2 py-3 text-sm">
                            <div>
                                کارمزد
                            </div>
                            <div class="flex gap-x-1">
                                <div>
                                    @{{Number(interest).toLocaleString()}}
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
                                    @{{Number(amount + interest).toLocaleString()}}
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
                        <button v-if="gateway"
                            @click="generateOrder"
                            class="mx-auto w-full px-2 py-3 text-sm bg-red-500 hover:bg-red-400 transition text-gray-100 rounded-lg primary-btn">
                            تایید و پرداخت
                        </button>
                    </div>
                </div>


                <div class="sm:flex gap-x-5 mt-7">
                    <table class="text-right w-full table-auto min-w-max text-sm text-gray-600">
                        <thead>
                        <tr>
                            <th class="p-2 border border-slate-300 bg-slate-50">ردیف</th>
                            <th class="p-2 border border-slate-300 bg-slate-50">محصول</th>
                            <th class="p-2 border border-slate-300 bg-slate-50 text-center">تعداد</th>
                            <th class="p-2 border border-slate-300 bg-slate-50 text-center">قیمت (تومان)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td class="p-2 border border-slate-200">{{ $counter++ }}</td>
                                <td class="p-2 border border-slate-200">
                                    <a href="/shop/product/{{$item->product->slug}}" target="_blank">{{ $item->name }}</a>
                                </td>
                                <td class="p-2 border border-slate-200 text-center">{{ $item->qty }}</td>
                                <td class="p-2 border border-slate-200 text-center">{{ number_format($item->unit_price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

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
                    payment_methods: [],
                    payment_method_name: "{{$invoice?->payment_method?->name ?? ''}}",
                    payment_description: '',
                    validation_errors: null,
                    form: {
                        payment_method_id: {{$invoice->payment_method_id ?? 1}},
                        invoice_id: {{$invoice->id}}
                    },
                    bank_check: false,
                    receipt: false,
                    months: 1,
                    amount: {{$invoice->amount}},
                    interest: {{$invoice->interest_amount}},
                    gateway: true,
                    snapp_title_message: '',
                    snapp_description: '',
                    eligible: true,
                    snapp_gateway: <?=$snapp_gateway;?>
                }
            },
            mounted(){
                @if(isset($payment_methods) && count($payment_methods))
                    this.payment_methods = <?=$payment_methods;?>;
                @endif
            },
            methods:{
                changePaymentMethod(payment_method){
                    this.form.payment_method_id = payment_method.id;
                    this.payment_method_name = payment_method.name;
                    this.payment_description = payment_method.description;
                    if(payment_method.interest_rate)
                    {
                        this.interest = Math.round(this.amount * (this.months * payment_method.interest_rate / 100))
                    }
                    else {
                        this.interest = 0
                    }
                    if(payment_method.code === 'bank-check')
                    {
                        this.bank_check = true
                        this.gateway = false
                    }
                    else {
                        this.bank_check = false
                        this.gateway = true
                    }
                    if(payment_method.code === 'receipt' || payment_method.code === 'ctc')
                    {
                        this.receipt = true
                        this.gateway = false
                    }
                    else {
                        this.receipt = false
                        this.gateway = true
                    }

                },
                async check_eligible(){
                    const requestOptions = {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json", "Accept": "application/json",
                            "X-CSRF-TOKEN": csrf_token
                        }
                    };

                    fetch("/payment/snapp/eligible/{{$invoice->id}}", requestOptions)
                        .then(async response => {
                            const data = await response.json()
                            // check for error response
                            if (response.ok) {
                                if(data?.eligible)
                                {
                                    this.form.payment_method_id = this.snapp_gateway?.id;
                                    this.payment_method_name = this.snapp_gateway?.name;
                                    this.gateway = true;
                                    if(this.snapp_gateway?.interest_rate)
                                    {
                                        this.interest = Math.round(this.amount * (this.months * this.snapp_gateway?.interest_rate / 100))
                                    }
                                    else {
                                        this.interest = 0
                                    }

                                    this.show_toast('مجاز به پرداخت از طریق درگاه اسنپ پی', 'success');
                                }
                                else {
                                    this.show_toast('امکان پرداخت از طریق درگاه اسنپ پی وجود ندارد', 'error');
                                }
                                this.snapp_title_message = data?.title_message;
                                this.snapp_description = data?.description;
                            }
                            else {
                                if (data?.error)
                                {
                                    this.show_toast(data?.error, 'error');
                                }
                            }

                        })
                        .catch(error => {
                            console.log(error)
                            this.show_toast('خطا در ارتباط با درگاه پرداخت.', 'error');
                        });

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

                    fetch("/payment", requestOptions)
                        .then(async response => {
                            const data = await response.json()
                            // check for error response
                            if (response.ok) {
                                this.show_toast('درحال اتصال به سرویس پرداخت', 'success');
                                await this.sleep(1000);
                                window.location.replace(data.link)
                            }
                            else {
                                if (data?.errors)
                                {
                                    this.validation_errors = data?.errors
                                }
                                this.show_toast('خطا در انتقال به درگاه پرداخت.', 'error');
                            }

                        })
                        .catch(error => {
                            console.log(error)
                            if (error?.response?.data?.errors)
                            {
                                this.validation_errors = error.response.data.errors
                            }
                            this.show_toast('خطا در انتقال به درگاه پرداخت.', 'error');
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
