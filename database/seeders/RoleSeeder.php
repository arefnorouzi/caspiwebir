<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Role::first();
        if (! $model) {
            $items = [
                ['id' => 1, 'name' => 'مدیر'],
                ['id' => 2, 'name' => 'پشتیبان'],
                ['id' => 3, 'name' => 'مدرس'],
                ['id' => 4, 'name' => 'مشتری'],
            ];

            DB::table('roles')->insert($items);
        }
    }
}
