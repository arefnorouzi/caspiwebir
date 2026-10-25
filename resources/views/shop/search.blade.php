@extends('layouts.IranMarket')
@section('title', 'نتایج جستجو')
@section('page_meta')
    <link rel="canonical" href="/shop">
    <meta name="googlebot" content="noindex, follow">
    <meta name="robots" content="noindex">
@endsection
@section('content')

    <div class="bg-white shadow-xl my-5 lg:my-10 rounded-xl md:rounded-2xl p-3 md:p-5">
        <div class="bg-white mx-5 rounded-2xl mb-4 grid">
            <div class="py-3">
                <h3 class="text-xl font-semibold text-gray-800">نتایج جستجو</h3>
            </div>
        </div>

        <div id="vueapp" class="md:flex">
            <div class="w-full">
                <div v-if="products && products.length > 0" class="bg-white rounded-2xl">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-x-2 px-1 rounded-2xl pb-5">

                        <a v-for="product in products" :key="product.id" :href="`/shop/product/${product.slug}`" target="_blank"
                           class="mb-2 p-3 border rounded-xl items-center sm:inline hover:shadow-lg transition">


                            <div class="image-box w-full sm:mb-6">
                                <div>
                                    <img :src="`${product.image}`" :alt="`${product.name}`"
                                         class="hover:scale-105 product-image transition rounded-md sm:rounded-3xl sm:w-full mx-auto" />
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="text-xs sm:text-sm opacity-90 mb-5">

                                    <div class="leading-7 h-auto">
                                        @{{product.name}}
                                    </div>
                                </div>
                                <div v-if="product.price > 0" class="flex justify-end mb-2 text-sm opacity-80 pl-3 md:pl-0 text-red-500">
                                    <div class="mx-1">@{{Number(product.offer_price && product.offer_price < product.price ? product.offer_price : product.price ).toLocaleString()}}</div>
                                    <div>تومان</div>
                                </div>
                                <div v-else class="flex justify-end mb-2 text-sm opacity-80 pl-3 md:pl-0 text-red-500">
                                    <div class="mx-1">تماس بگیرید</div>
                                </div>
                                <div v-if="product.offer_price && product.offer_price < product.price" class="flex justify-end text-xs opacity-75 pl-3 md:pl-0">
                                    <div class="line-through mx-1">@{{Number(product.price).toLocaleString()}}</div>
                                    <div class="line-through">تومان</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="pagination custom-pagination flex flex-wrap justify-center mb-5" v-if="pagination.last_page > 1">

                        <button
                            @click="loadProducts(pagination.current_page - 1)"
                            :disabled="pagination.current_page === 1">
                            قبلی
                        </button>

                        <button
                            v-for="page in pagination.last_page"
                            :key="page"
                            @click="loadProducts(page)"
                            :class="{ active: page === pagination.current_page }">
                            @{{ page }}
                        </button>

                        <button
                            @click="loadProducts(pagination.current_page + 1)"
                            :disabled="pagination.current_page === pagination.last_page">
                            بعدی
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>
        window.INIT_DATA = {
            products: @json($products),      // پکیج کامل paginate لاراول
        };
    </script>
    <script src="/js/vue.global.js"></script>

    <script>
        const { createApp, ref } = Vue

        createApp({
            data(){
                return{
                    filters: {
                        categories: [],
                        brands: [],
                        search: ""
                    },
                    pagination: {
                        current_page: 1,
                        last_page: 1,
                    },
                    brands: [],
                    products: [],
                    categories: [],
                    authorized: false
                }
            },
            mounted(){
                @if($authorized)
                    this.authorized = true;
                @endif
                const init = window.INIT_DATA || {};
                if (init.products) {
                    // لاراول paginator درون کلید `data` لیست مدل‌ها را دارد
                    this.products = init.products.data || [];
                    this.pagination.current_page = init.products.current_page || 1;
                    this.pagination.last_page = init.products.last_page || 1;
                }
            },
            watch: {
                filters: {
                    handler() {
                        this.loadProducts();
                    },
                    deep: true
                }
            },
            methods:{
                async loadProducts(page = 1){
                    const params = new URLSearchParams()

                    if (this.filters.brands.length) params.append('brands', this.filters.brands)
                    if (this.filters.categories.length) params.append('categories', this.filters.categories)

                    fetch("/shop/filter" + '?' + params.toString() + '&page=' + page)
                        .then(async response => {
                            const data = await response.json()

                            // check for error response
                            if (response.ok) {
                                this.products = data.products.data
                                this.pagination.current_page = data.products.current_page;
                                this.pagination.last_page = data.products.last_page;
                            }

                        })
                        .catch(error => {
                            console.log(error)
                        });
                },
                async sleep(ms){
                    return new Promise(resolve => setTimeout(resolve, ms));
                }
            }
        }).mount('#vueapp')
    </script>
    <script src="/js/faq.js"></script>
@endsection
