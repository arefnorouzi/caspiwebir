@extends('layouts.IranMarket')
@section('title', 'دوره ها و ویدیوهای آموزشی')
@section('page_meta')
    <!-- Canonical URL -->
    <link rel="canonical" href="/shop/courses">
@endsection
@section('content')

    <div class="bg-white shadow-xl my-5 lg:my-10 rounded-xl md:rounded-2xl p-3 md:p-5">
        <div class="bg-white mx-5 rounded-2xl mb-4 grid">
            <div class="py-3">
                <h3 class="text-xl font-semibold text-gray-800">دوره ها</h3>
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
                                         class="hover:scale-105 transition rounded-md sm:rounded-3xl sm:w-full mx-auto" />
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
                                <div class="text-xs sm:text-sm opacity-90 mb-5" style="font-size: .7rem">

                                    <div class="leading-7 h-auto">
                                        @{{product.meta}}
                                    </div>
                                </div>
                                <div class="text-xs sm:text-sm opacity-90 mb-5 flex flex-wrap gap-2 justify-between" style="font-size: .7rem">
                                    <div class="p-1 rounded-md text-center flex align-middle items-center">
                                        <svg height="14px" width="14px" style="margin: auto" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#000000;} </style> <g> <path class="st0" d="M505.837,180.418L279.265,76.124c-7.349-3.385-15.177-5.093-23.265-5.093c-8.088,0-15.914,1.708-23.265,5.093 L6.163,180.418C2.418,182.149,0,185.922,0,190.045s2.418,7.896,6.163,9.627l226.572,104.294c7.349,3.385,15.177,5.101,23.265,5.101 c8.088,0,15.916-1.716,23.267-5.101l178.812-82.306v82.881c-7.096,0.8-12.63,6.84-12.63,14.138c0,6.359,4.208,11.864,10.206,13.618 l-12.092,79.791h55.676l-12.09-79.791c5.996-1.754,10.204-7.259,10.204-13.618c0-7.298-5.534-13.338-12.63-14.138v-95.148 l21.116-9.721c3.744-1.731,6.163-5.504,6.163-9.627S509.582,182.149,505.837,180.418z"></path> <path class="st0" d="M256,346.831c-11.246,0-22.143-2.391-32.386-7.104L112.793,288.71v101.638 c0,22.314,67.426,50.621,143.207,50.621c75.782,0,143.209-28.308,143.209-50.621V288.71l-110.827,51.017 C278.145,344.44,267.25,346.831,256,346.831z"></path> </g> </g></svg>
                                        <span class="mr-1">@{{product.sales}}</span> دانشجو
                                    </div>
                                    <div class="p-1 rounded-md text-center flex align-middle items-center">
                                        <svg fill="#000000" width="14px" height="14px" style="margin: auto" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M1801.441 0v1920H219.03v-439.216h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.47 56.515-56.47h56.514V1029.02h-56.514c-31.196 0-56.515-25.3-56.515-56.471 0-31.172 25.319-56.47 56.515-56.47h56.514V577.254h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.471 56.515-56.471h56.514V0h1582.412Zm-521.714 1389.706H640.288v112.94h639.439v-112.94Zm109.172-214.83H640.288v112.94h748.611v-112.94Zm-109.172-534.845H640.288v112.94h639.439v-112.94Zm109.172-214.83H640.288v112.94h748.611v-112.94Z" fill-rule="evenodd"></path> </g></svg>
                                        <span class="mr-1">@{{product.duration}} جلسه</span>
                                    </div>
                                    <div class="p-1 rounded-md text-center flex align-middle items-center">
                                        <svg width="14px" height="14px" style="margin: auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="13" r="8" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle> <path d="M12 9V13L15 15" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18 3L21 6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 3L3 6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                        <span class="mr-1">@{{product.course_time}}</span>
                                    </div>
                                </div>
                                <div class="text-center p-2">
                                    <button class="p-2 w-full rounded-md bg-green-500 text-white">شرکت در دوره</button>
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
                    params.append('downloadable', 1)
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
