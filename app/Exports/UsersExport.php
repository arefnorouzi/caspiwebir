<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return User::query()
            ->where('role_id', '>', 2)
            ->orderby('id','desc')
            ->with(['province:id,name', 'role:id,name'])
            ->select('id', 'name', 'mobile', 'role_id', 'province_id', 'authenticated', 'zip_code', 'city', 'address', 'is_active', 'national_code');
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->mobile,
            $user->national_code,
            $user?->role?->name ?? '',
            $user->authenticated ? "1" : "0",
            $user->is_active ? "1" : "0",
            $user->ban ? "1" : "0",
            $user->zip_code,
            $user?->province?->name ?? '',
            $user->city,
            $user->address,
        ];
    }

    public function headings(): array
    {
        return ['شناسه', 'نام و نام خانوادگی', 'موبایل', 'کد ملی', 'سطح کاربری', 'احراز هویت', 'وضعیت کاربر', 'مسدود', 'کد پستی', 'استان', 'شهر', 'آدرس'];
    }
}
