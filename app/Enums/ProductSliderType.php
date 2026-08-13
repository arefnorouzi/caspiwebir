<?php

namespace App\Enums;

enum ProductSliderType: string
{
    case BEST_SELLER = 'best_seller';
    case LATEST = 'latest';
    case POPULAR = 'popular';
    case SUGGESTED = 'suggested';
    case FEATURED = 'featured';
    case AMAZING = 'amazing';
    case LIMITTED_OFFER = 'limitted_offer';

    case OFF = 'off';

    case CATEGORY = 'category';
    case BRAND = 'brand';



    public static function values(): array
    {
        return array_map(
            fn ($case) => $case->value,
            self::cases()
        );
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }

    public function label(): string
    {
        return match ($this) {
            self::BEST_SELLER     => 'پرفروش‌ترین‌ها',
            self::LATEST       => 'جدیدترین محصولات',
            self::POPULAR     => 'محبوب‌ترین محصولات',
            self::FEATURED           => 'فروش ویژه',
            self::AMAZING         => 'شگفت انگیزها',
            self::SUGGESTED    => 'محصولات پیشنهادی',
            self::OFF            => 'محصولات تخفیفی',
            self::LIMITTED_OFFER  => 'فرصت‌های خرید',
            self::CATEGORY => 'برترین‌های دسته بندی',
            self::BRAND         => 'برترین‌های برند',
        };
    }
}
