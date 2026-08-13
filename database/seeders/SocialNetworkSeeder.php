<?php

namespace Database\Seeders;

use App\Models\SocialNetwork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = SocialNetwork::first();
        if (!$model)
        {
            SocialNetwork::create([
               'name' => 'تلگرام',
               'image' => '/icons/telegram.svg',
               'rank' => 1,
                'link' => 'https://t.me/caspiweb_ir'
            ]);
            SocialNetwork::create([
                'name' => 'واتساپ',
                'image' => '/icons/whatsapp.svg',
                'rank' => 2,
                'link' => 'https://wa.me/+989192138510'
            ]);

            SocialNetwork::create([
                'name' => 'اینستاگرام',
                'image' => '/icons/instagram.svg',
                'rank' => 3,
                'link' => 'https://instagram.com/caspiweb_ir'
            ]);

            SocialNetwork::create([
                'name' => 'لینکدین',
                'image' => '/icons/linkedin.svg',
                'rank' => 4,
                'status' => false,
                'link' => 'https://www.linkedin.com/in/aref-norouzi-abatari/'
            ]);

            SocialNetwork::create([
                'name' => 'یوتیوب',
                'image' => '/icons/youtube.svg',
                'rank' => 5,
                'status' => false,
                'link' => 'https://www.youtube.com/@caspiweb_ir'
            ]);
            SocialNetwork::create([
                'name' => 'آپارات',
                'image' => '/icons/aparat.png',
                'rank' => 6,
                'link' => 'https://aparat.com/caspiweb'
            ]);

            SocialNetwork::create([
                'name' => 'روبیکا',
                'image' => '/icons/rubika.png',
                'rank' => 7,
                'link' => 'https://rubika.ir/caspiweb_ir'
            ]);

            SocialNetwork::create([
                'name' => 'بله',
                'image' => '/icons/bale.png',
                'rank' => 8,
                'link' => 'https://ble.ir/join/8JmCqzpfTe'
            ]);


        }
    }
}
