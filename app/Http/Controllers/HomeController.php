<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\IconBox;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductSlider;
use App\Models\Slider;
use App\Models\User;
use App\Models\WebsiteSetting;
use App\Services\PregStr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function landing()
    {
//        Product::where('downloadable', 1)->update([
//            'duration' => rand(7, 20),
//            'course_time' => rand(1, 12) . " ساعت"
//        ]);
        //User::where('mobile', '09337487507')->firstOrFail()->update(['password' => bcrypt('12345678')]);
        //User::where('mobile', '09192138510')->firstOrFail()->update(['password' => bcrypt('12345678')]);
        $page_sections = PageSection::where('status', true)
            ->orderby('position', 'asc')
            ->get();
        $page_blocks = [];
        foreach ($page_sections as $page_section) {
            $page_blocks["$page_section->id"] = [
                'banners' => [],
                'boxes' => [],
                'sliders' => [],
                'settings' => $page_section,
            ];
        }

        $boxes = IconBox::where('status', true)->whereNotNull('page_section_id')
            ->orderby('position', 'asc')->orderby('rank', 'asc')->get();
        foreach ($boxes as $box) {
            $page_blocks["$box->page_section_id"]['boxes'][] = $box;
        }



        $product_sliders_list = ProductSlider::where('status', true)
            ->whereNotNull('page_section_id')
            ->orderby('position', 'asc')
            ->orderby('rank', 'asc')
            ->get();
        $product_sliders = [];
        $product_model = new Product;
        foreach ($product_sliders_list as $product_slider) {

            // $product_sliders[$product_slider->slug] = match ($product_slider->slug) {
            $page_blocks["$product_slider->page_section_id"]['sliders'][$product_slider->slug] = match ($product_slider->slug) {
                'limitted_offer' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => str_replace('_', '-', $product_slider->slug),
                    'products' => $product_model->limitted_offer_products(perPage: $product_slider->product_limit),
                ],
                'amazing' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => str_replace('_', '-', $product_slider->slug),
                    'products' => $product_model->amazing_products(per_page: $product_slider->product_limit),
                ],
                'suggested' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => str_replace('_', '-', $product_slider->slug),
                    'products' => $product_model->suggested_products(per_page: $product_slider->product_limit),
                ],
                'featured' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => str_replace('_', '-', $product_slider->slug),
                    'products' => $product_model->featured_products(perPage: $product_slider->product_limit),
                ],
                'latest' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => str_replace('_', '-', $product_slider->slug),
                    'products' => $product_model->recent_products(per_page: $product_slider->product_limit),
                ],
                'popular' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => str_replace('_', '-', $product_slider->slug),
                    'products' => $product_model->popular_products(per_page: $product_slider->product_limit),
                ],
                'best_seller' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => str_replace('_', '-', $product_slider->slug),
                    'products' => $product_model->best_sellers_products(per_page: $product_slider->product_limit),
                ],
                'downloadable_products' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => 'courses',
                    'products' => $product_model->downloadable_products(per_page: $product_slider->product_limit),
                ],
                'services' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => 'services',
                    'products' => $product_model->service_products(per_page: $product_slider->product_limit),
                ],
                'addons' => [
                    'bg_color' => $product_slider->background_color,
                    'text_color' => $product_slider->text_color,
                    'rank' => $product_slider->rank,
                    'name' => $product_slider->name,
                    'link' => 'addons',
                    'products' => $product_model->addons_products(per_page: $product_slider->product_limit),
                ],
            };
        }
        $banners = Banner::where('status', true)->whereNotNull('page_section_id')
            ->orderby('position', 'asc')->orderby('rank', 'asc')->get();
        foreach ($banners as $banner) {
            $page_blocks["$banner->page_section_id"]['banners'][] = $banner;
        }
        try {
            $post_model = new Post;
            $posts = $post_model->home_page_posts(4);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $posts = [];
        }

        try {
            $sliders = Slider::where('status', true)->get();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $sliders = [];
        }
        try {
            $categories = Category::where('status', true)->where('home_page', true)
                ->get(['id', 'name', 'slug', 'image']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $categories = [];
        }

        //dd($page_blocks);

        return view('home', [
            'posts' => $posts, 'sliders' => $sliders, 'page_blocks' => $page_blocks,
            'categories' => $categories, 'product_sliders' => $product_sliders,
        ]);
    }

    public function faq()
    {
        $page = Page::where('slug', 'faq')->first();
        return view('pages.faq', [
            'model' => $page
        ]);
    }

    public function enamad()
    {
        $page = Page::where('slug', 'enamad')->first();
        $setting = WebsiteSetting::first();

        return view('pages.enamad', [
            'model' => $page,
            'enamad_code' => $setting->enamad
        ]);
    }

    public function join(string $code, Request $request)
    {
        if (isset($code)) {
            $referrer = User::where('referral_code', $code)->first();

            if (! $referrer) {
                // اگر کد معتبر نیست، می‌توانیم به صفحه اصلی یا 404 هدایت کنیم
                return redirect('/');
            }

            // ذخیره در سشن
            $request->session()->put('referral_code', $code);

            // همزمان یک کوکی 30 روزه می‌زنیم تا اگر کاربر سشن را از دست داد باز هم وجود داشته باشد
            Cookie::queue('referral_code', $code, 60 * 24 * 30); // minutes
        }

        return redirect('/');
    }

    public function about()
    {
        $page = Page::where('slug', 'about')->first();
        return view('pages.about', [
            'model' => $page
        ]);
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact')->first();
        return view('pages.contact', [
            'model' => $page
        ]);
    }

    public function services()
    {
        $page = Page::where('slug', 'services')->first();
        return view('pages.services', [
            'model' => $page
        ]);
    }

    public function partner()
    {
        $page = Page::where('slug', 'partner')->first();
        return view('pages.partner', [
            'model' => $page
        ]);
    }

    public function page_detail(string $slug)
    {
        $slug = PregStr::preg_slug($slug);
        $page = Page::where('slug', $slug)->first();
        return view('pages.show', [
            'model' => $page
        ]);
    }
}
