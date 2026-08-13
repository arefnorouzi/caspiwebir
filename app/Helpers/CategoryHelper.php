<?php

namespace App\Helpers;

class CategoryHelper
{
    public static function buildCategoryTree($categories, $parentId = null, $prefix = ''): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $tree[] = [
                    'id'   => $category->id,
                    'name' => $prefix . $category->name,
                ];

                $tree = array_merge(
                    $tree,
                    self::buildCategoryTree($categories, $category->id, $prefix . '-- ')
                );
            }
        }

        return $tree;
    }
}
