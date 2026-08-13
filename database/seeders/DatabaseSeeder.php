<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::where('mobile', '=', '09192138510')->where('is_admin', '=', true)->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'پشتیبان سایت',
                'email' => 'info@caspiweb.com',
                'mobile' => '09192138510',
                'mobile_verified' => true,
                'email_verified_at' => now(),
                'password' => bcrypt('13741207'),
                'is_admin' => true,
                'is_active' => true,
                'subscribe' => true,
                'role_id' => 1,
                'province_id' => 25,
                'referral_code' => '1',
                'city' => 'صومعه سرا',
            ]);
            $pass = rand(123456789, 9999999999);
            User::create([
                'name' => 'عارف نوروزی',
                'email' => 'info@caspiweb.ir',
                'mobile' => '09337487507',
                'mobile_verified' => true,
                'email_verified_at' => now(),
                'password' => bcrypt('13741207'),
                'is_admin' => true,
                'is_active' => true,
                'subscribe' => true,
                'referral_code' => '2',
                'referral_id' => 1,
                'role_id' => 1,
                'province_id' => 25,
                'city' => 'رشت',

            ]);
        }

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            SmsSettingSeeder::class,
            WebsiteSettingSeeder::class,
            ShopSettingSeeder::class,
            PaymentMethodSeeder::class,
            ShippingMethodSeeder::class,
            ProvinceSeeder::class,
            InvoiceStatusSeeder::class,
            InvoiceTypeSeeder::class,
            InvoiceItemStatusSeeder::class,
            TicketStatusSeeder::class,
            BlogCategorySeeder::class,
            PostSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductUnitSeeder::class,
            ProductSeeder::class,
            SliderSeeder::class,
            PageSeeder::class,
            MenuSeeder::class,
            PageSectionSeeder::class,
            ProductSliderSeeder::class,
            BannerSeeder::class,
            //CourseSeeder::class,
            //LessonSeeder::class,
            IconBoxSeeder::class,
            CouponSeeder::class,
            //CartSeeder::class,
            //InvoiceSeeder::class,
            //CommentSeeder::class,
            //TicketSeeder::class,
            SocialNetworkSeeder::class,
            MediaSeeder::class,
            ProductPropertySeeder::class
        ]);
    }
}
