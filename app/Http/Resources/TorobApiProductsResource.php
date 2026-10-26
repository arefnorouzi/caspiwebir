<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Pest\Laravel\json;

class TorobApiProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'page_unique' => "$this->id",
            'page_url' => url('/shop/p/' . $this->id),
            'product_group_id' => "$this->brand_id" ?? "1",
            'title' => $this->name,
            'subtitle' => $this->sub_title,
            'product_image' => $this->thumbnail ?  url($this->thumbnail) : url($this->image),
            'current_price' => $this->active_price ?? $this->price,
            'old_price' => $this->price,
            'availability' => $this->stock > 0,
            "category_name" => "آموزش برنامه نویسی",
            "image_links" => [url($this->thumbnail ?? $this->image)],
            "guarantee" => $this->guarantee ?? "ضمانت بازگشت وجه",
            "short_desc" => $this->seo_meta ?? $this->meta,
            "date_added" => $this->created_at,
            "date_updated" => $this->updated_at,
            "spec" => [
              'شناسه دوره' => $this->id,
              'تعداد جلسات' => $this->duration ?? 1,
              'مدت دوره' => $this->course_time ?? "1 ساعت",
              'تعداد دانشجو' => $this->sales ?? 1,
            ]
        ];
    }
}
