<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::where('status', true)
            ->whereNotNull("published_at")
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'slug', 'updated_at']);

        $products = Product::where('status', true)
            ->whereNotNull('published_at')
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'slug', 'sku', 'updated_at']);

        $staticPages = [
            URL::to('/'),
            URL::to('/shop'),
            URL::to('/blog'),
            URL::to('/shop/courses'),
            URL::to('/contact'),
            URL::to('/faq'),
            URL::to('/terms'),
            URL::to('/partner'),
            URL::to('/page/installment-payment'),
            URL::to('/page/cryptocurrency-payment'),

            // ...
        ];

        $xml = view('sitemap', compact( 'posts', 'products', 'staticPages'))->render();

        file_put_contents(public_path('sitemap.xml'), $xml);
        Log::info("sitemap updated");
        return Command::SUCCESS;
    }
}
