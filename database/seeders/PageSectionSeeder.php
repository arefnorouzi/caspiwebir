<?php

namespace Database\Seeders;

use App\Enums\PageSectionType;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = PageSection::first();
        if ($model === null) {
            PageSection::create([
                'name' => 'خدمات ما', 'type' => PageSectionType::ICON_BOX->value,
                'xl_columns' => 6, 'lg_columns' => 4, 'md_columns' => 3, 'sm_columns' => 2, 'xs_columns' => 2,
                'gap' => 3, 'position' => 1, 'rank' => 1, 'show_name' => true,
                'background_color' => '#ffffff', 'text_color' => '#212121',
            ]);

            PageSection::create([
                'name' => 'بلوک 2', 'type' => PageSectionType::PRODUCT_SLIDER->value,
                'position' => 2, 'rank' => 1,
            ]);

            PageSection::create([
                'name' => 'بلوک 3', 'type' => PageSectionType::BANNER->value,
                'position' => 3, 'rank' => 1,
            ]);

            PageSection::create([
                'name' => 'مسیر یادگیری', 'type' => PageSectionType::ICON_BOX->value,
                'xl_columns' => 6, 'lg_columns' => 4, 'md_columns' => 3, 'sm_columns' => 2, 'xs_columns' => 2,
                'gap' => 3, 'position' => 4, 'rank' => 1, 'show_name' => true,
                'background_color' => '#ffffff', 'text_color' => '#212121',
            ]);

            PageSection::create([
                'name' => 'بخش دوم اسلایدرها', 'type' => PageSectionType::PRODUCT_SLIDER->value,
                'position' => 5, 'rank' => 1,
            ]);

            PageSection::create([
                'name' => 'خدمات وردپرس', 'type' => PageSectionType::ICON_BOX->value,
                'xl_columns' => 4, 'lg_columns' => 4, 'md_columns' => 2, 'sm_columns' => 2, 'xs_columns' => 2,
                'gap' => 3, 'position' => 6, 'rank' => 1, 'show_name' => true,
                'background_color' => '#ffffff', 'text_color' => '#212121',
            ]);
        }
    }
}
