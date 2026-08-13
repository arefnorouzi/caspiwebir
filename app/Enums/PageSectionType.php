<?php

namespace App\Enums;

enum PageSectionType: string
{
    case PRODUCT_SLIDER = 'product_slider';
    case TEXT = 'text';
    case IMAGE = 'image';
    case BANNER = 'banner';

    case ICON_BOX = 'icon_box';


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
            self::PRODUCT_SLIDER => 'اسلایدر محصولات',
            self::TEXT           => 'سکشن متنی',
            self::IMAGE          => 'تصویر',
            self::BANNER         => 'بنر',
            self::ICON_BOX         => 'باکس آیکون دار',
        };
    }
}
