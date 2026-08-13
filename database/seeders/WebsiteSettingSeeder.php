<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = WebsiteSetting::first();
        if(!$model)
        {
            WebsiteSetting::create([
                'name' => 'فروشگاه ساز مارلیک',
                'meta' => 'طراحی فروشگاه اینترنتی در کوتاهترین زمان با بالاترین کیفیت.',
                'mobile' => '09192138510',
                'phone' => '09192138510',
                'email' => 'info@caspiweb.ir',
                'address' => 'گیلان، صومعه سرا',
                'whatsapp' => '989192138510',
                'telegram' => 'caspiweb_ir',
                'instagram' => 'caspiweb_ir',
                'logo' => '/images/logo.png',
                'header_logo' => '/images/logo.png',
                'footer_logo' => '/images/logo.png',
                'factor_logo' => '/images/logo.png',
                'enamad' => "<a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=419240&Code=BlEV2SmQwKA5HoqHLo4SZswfohXwkcTd'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=419240&Code=BlEV2SmQwKA5HoqHLo4SZswfohXwkcTd' alt='' style='cursor:pointer' Code='BlEV2SmQwKA5HoqHLo4SZswfohXwkcTd'></a>"
            ]);
        }
    }
}
