<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Product::first();
        if (! $model) {


            $json_file = file_get_contents(public_path("db/products.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item)
            {
                Product::create($item);
//                Product::create([
//                    'id' => $item['id'], 'name' => $item['name'], 'image' => $item['image'],
//                    'slug' => $item['slug'], 'status' => $item['status'], 'brand_id' => $item['brand_id'],
//                    'price' => $item['price'], 'description' => $item['description'],
//                    'meta' => $item['meta'], 'offer_price' => $item['offer_price'],
//                    'offer_end_date' => $item['offer_end_date'], 'views' => $item['views'],
//                    'published_at' => $item['published_at'], 'created_at' => $item['created_at'],
//                    'updated_at' => $item['updated_at'], 'user_id' => 2,
//                    'warranty' => 'ضمانت بازگشت وجه تا ۷ روز', 'sku' => $item['sku'],
//                ]);
            }

//            $brands = Brand::get();
//            foreach ($brands as $brand) {
//                for ($i = 1; $i <= 10; $i++) {
//                    $price = rand(10, 60) * 100000;
//                    $offer_price = null;
//                    $offer_end_date = null;
//                    if (rand(0, 1)) {
//                        $offer_price = intval($price - ($price * (rand(2, 12) / 100)));
//                    }
//                    if ($offer_price) {
//                        $offer_end_date = now()->addHours(rand(2, 320))->format('Y-m-d');
//                    }
//                    $product = Product::create([
//                        'name' => 'آموزش '.$brand->name.' کد '.rand(1024, 4096),
//                        'sku' => $brand->id.'-'.rand(1024, 987654321),
//                        'slug' => Str::uuid(),
//                        'brand_id' => $brand->id,
//                        'price' => $price,
//                        'offer_price' => $offer_price,
//                        'offer_end_date' => $offer_end_date,
//                        'image' => '/images/products/'.rand(1, 20).'.webp',
//                        'meta' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای',
//                        'description' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
//لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
//',
//                        'excerpt_review' => 'برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
//',
//                        'guarantee' => 'گواهی معتبر پایان دوره',
//                        'warranty' => 'ضمانت بازگشت وجه تا ۷ روز',
//                        'status' => true,
//                        'views' => rand(1, 5000),
//                        'sales' => rand(0, 20),
//                        'suggested' => rand(0, 1),
//                        'amazing' => rand(0, 1),
//                        'downloadable' => 1,
//                        'duration' => rand(1, 6),
//                        'course_time' => rand(1, 10) . ' ' . 'ساعت',
//                        'source' => rand(0, 1),
//                        'pinned' => (bool) $offer_price,
//                        'user_id' => 2,
//                        'video' => 'https://www.aparat.com/v/q088t9z?playlist=8028928',
//                        'published_at' => now()->subDays(rand(1, 30)),
//                    ]);
//                    $product->categories()->attach([rand(1, 9)]);
//
//                    // properties
//                    $product->properties()->create([
//                        'property_name' => 'پیشنیاز',
//                        'property_value' => 'ندارد',
//                        'pinned' => true,
//                    ]);
//                    $product->properties()->create([
//                        'property_name' => 'سورس کد',
//                        'property_value' => 'دارد',
//                        'pinned' => true,
//                    ]);
//                    $product->properties()->create([
//                        'property_name' => 'ارتباط با مدرس',
//                        'property_value' => 'دارد',
//                        'pinned' => true,
//                    ]);
//                    $product->properties()->create([
//                        'property_name' => 'گواهی پایان دوره',
//                        'property_value' => 'دارد',
//                        'pinned' => false,
//                    ]);
//
//                    ProductGallery::factory()
//                        ->count(fake()->numberBetween(1, 5))
//                        ->create(['product_id' => $product->id]);
//
//                }
//            }

            $json_file = file_get_contents(public_path("db/category_product.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item)
            {
                DB::table('category_product')->insert($item);
            }
        }
    }
}
