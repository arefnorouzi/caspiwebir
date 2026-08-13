@extends('layouts.IranMarket')
@section('title', 'سبد خرید')
@section('content')

    <div id="vueapp" class="bg-white shadow-xl my-5 lg:my-10 rounded-xl md:rounded-2xl p-3 md:p-5">
        <div class="relative overflow-x-auto p-1 rounded-2xl border">
            <div v-if="cart && cart_items.length > 0" class="flex flex-col md:flex-row gap-y-3 items-center gap-x-2 mb-7">
                <div class="text-sm opacity-80">
                    کد تخفیف دارید؟ وارد کنید:
                </div>
                <div>
                    <input v-model="coupon_code" class="border border-gray-400 outline-none focus:border-red-300 rounded-lg p-1 text-center" minlength="3" maxlength="50" type="text">
                </div>
                <div>
                    <button @click="applyCoupon" class="bg-red-600 text-white px-3 py-1 rounded-lg shadow-md">
                        تایید
                    </button>
                </div>
            </div>
            <table v-if="cart && cart_items.length > 0" class="w-full text-sm text-right rtl:text-right text-gray-500">
                <thead class="hidden md:table-header-group text-xs text-gray-700 bg-gray-50">
                <tr>
                    <th scope="col" class="px-16 py-3">
                        <span class="sr-only">تصویر</span>
                    </th>
                    <th scope="col" class="md:pr-6 py-3">
                        نام محصول
                    </th>
                    <th scope="col" class="pr-10 py-3">
                        تعداد
                    </th>
                    <th scope="col" class="px-6 py-3">
                        قیمت
                    </th>
                    <th scope="col" class="px-6 py-3">
                        جمع
                    </th>
                    <th scope="col" class="px-6 py-3">
                        عملیات
                    </th>
                </tr>
                </thead>
                <tbody  class="grid grid-cols-1 sm:grid-cols-2 md:contents gap-5">
                <tr v-for="(item, i) in cart_items"
                    class="bg-white border-b hover:bg-gray-50 grid grid-cols-1 justify-items-center md:table-row">
                    <td class="p-4">
                        <img :src="item?.product?.image"
                             class="cart-item-img rounded-lg" alt="">
                    </td>
                    <td class="md:pr-6 py-4 text-sm opacity-90 text-gray-900">
                        <a :href="`/shop/p/${item.product_id}`" target="_blank">@{{ item.name }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <span>@{{item.qty}}</span>
                    </td>
                    <td class="px-6 py-4 text-sm opacity-90 text-gray-900">
                        <p>@{{Number(item.unit_price).toLocaleString()}}</p>
                        <s v-if="item.item_price > item.unit_price">@{{Number(item.item_price).toLocaleString()}}</s>
                    </td>
                    <td class="px-6 py-4 text-sm opacity-90 text-gray-900">
                        <p>@{{Number(item.unit_price * item.qty).toLocaleString()}}</p>
                        <s v-if="item.item_price > item.unit_price">@{{Number(item.item_price * item.qty).toLocaleString()}}</s>
                    </td>
                    <td class="px-6 py-4">
                        <button @click="updateQty(item.id, false)" class=" text-red-600">حذف</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-if="cart && cart_items.length > 0" class="border shadow-xl rounded-2xl mx-auto max-w-xl mt-7 flex flex-col gap-y-5 py-5 px-5 md:px-20">
            <div class="flex justify-between">
                <div>
                    جمع سفارش:
                </div>
                <div class="flex gap-x-1">
                    <div>
                        @{{Number(cart.sub_total).toLocaleString()}}
                    </div>
                    <div>
                        تومان
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <div>
                    کد تخفیف:
                    <span v-if="cart.coupon_code" @click="removeCoupon" class="p-1 cursor-pointer rounded-md bg-red-100 text-red-500">حذف کوپن</span>
                </div>
                <div class="flex gap-x-1">
                    <div class="text-red-500">
                        @{{ cart.coupon_code }}
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <div>
                    سود شما از این خرید:
                </div>
                <div class="flex gap-x-1 text-red-500">
                    <div>
                        @{{ Number(cart?.discount).toLocaleString() }}
                    </div>
                    <div>
                        تومان
                    </div>
                </div>
            </div>
            <div class="flex text-green-700 justify-between">
                <div class="">
                    مبلغ نهایی:
                </div>
                <div class="flex gap-x-1">
                    <div>
                        @{{Number(cart?.total_amount).toLocaleString()}}
                    </div>
                    <div>
                        تومان
                    </div>
                </div>
            </div>
            <a href="/checkout" class="flex justify-center items-center opacity-90 my-5">
                <button class="mx-auto w-full px-2 py-3 text-sm bg-red-500 hover:bg-red-400 transition text-gray-100 rounded-lg primary-btn">تایید و پرداخت</button>
            </a>
        </div>


        <div v-else>
            <div class="bg-orange-200 text-orange-500 rounded-md shadow text-center p-3">
                <p class="text-sm">هیچ محصولی در سبد خرید شما وجود ندارد.</p>
            </div>

            <a v-else href="/" class="flex justify-center items-center opacity-90 my-5">
                <button class="px-7 py-2 text-center text-white bg-red-500 align-middle border-0 rounded-lg shadow-md text-sm">بازگشت به سایت</button>
            </a>
        </div>

    </div>



@endsection
@section('script')
    <script src="/js/vue.global.js"></script>
    <script>
        const { createApp, ref } = Vue

        const csrf_token = document.querySelector('meta[name="csrf-token"]').content

        createApp({
            data(){
                return{
                    cart: null,
                    cart_items: [],
                    coupon_code: ''
                }
            },
            mounted(){
                @if($cart)
                    this.cart = <?=$cart;?>;
                this.cart_items = <?=$cart->items;?>;
                @endif
            },
            methods:{
                async removeCoupon(){
                    const requestOptions = {
                        method: "DELETE",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            _token: csrf_token
                        })
                    };

                    fetch("{{route('remove_coupon')}}", requestOptions)
                        .then(async response => {
                            const data = await response.json()
                            // check for error response
                            if (response.ok) {
                                this.show_toast('سبد خرید بروز شد', 'success');
                                await this.sleep(500)
                                window.location.reload()

                            }
                            else {
                                this.show_toast('درخواست نامعتبر است', 'error');
                            }

                        })
                        .catch(error => {
                            this.show_toast('درخواست نامعتبر است', 'error');
                        });
                },
                async applyCoupon(){
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            code: this.coupon_code,
                            _token: csrf_token
                        })
                    };

                    fetch("{{route('apply_coupon')}}", requestOptions)
                        .then(async response => {
                            const data = await response.json()
                            // check for error response
                            if (response.ok) {
                                this.show_toast('سبد خرید بروز شد', 'success');
                                await this.sleep(500)
                                window.location.reload()

                            }
                            else {
                                this.show_toast('کد تخفیف نامعتبر است', 'error');
                            }

                        })
                        .catch(error => {
                            this.show_toast('کد تخفیف نامعتبر است', 'error');
                        });
                },
                async updateQty(item_id, status){
                    const requestOptions = {
                        method: "PATCH",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            item_id: item_id, status: status,
                            _token: csrf_token
                        })
                    };

                    fetch("{{route('update_qty')}}", requestOptions)
                        .then(async response => {
                            const data = await response.json()
                            console.log(data)
                            // check for error response
                            if (response.ok) {
                                this.cart = data.cart;
                                this.cart_items = data.cart.items;
                                this.show_toast('سبد خرید بروز شد', 'success');

                            }
                            else {
                                this.show_toast('خطا در بروزرسانی تعداد', 'error');
                            }

                        })
                        .catch(error => {
                            this.show_toast('خطا در بروزرسانی تعداد', 'error');
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
