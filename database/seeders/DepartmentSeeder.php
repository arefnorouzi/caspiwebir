<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Department::first();
        if (! $model) {
            $departments = [
                [
                    'name' => 'پشتیبانی فنی',
                    'code' => 'SUPPORT',
                    'description' => 'پشتیبانی نرم افزاری و سخت افزاری.',
                ],
                [
                    'name' => 'سفارش پروژه',
                    'code' => 'PROJECT',
                    'description' => 'سفارش پروژه',
                ],
                [
                    'name' => 'مدیریت',
                    'code' => 'ADMIN',
                    'description' => 'مدیریت تیم',
                ],
            ];

            foreach ($departments as $dept) {
                Department::firstOrCreate(
                    ['code' => $dept['code']], // جلوگیری از تکراری شدن
                    $dept
                );
            }
        }
    }
}
