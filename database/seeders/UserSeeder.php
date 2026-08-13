<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = User::count();
        if($model == 2)
        {
            $json_file = file_get_contents(public_path("db/users.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item)
            {
                User::created($item);
//                User::create([
//                    'id' => $item['id'], 'name' => $item['name'], 'email' => $item['email'],
//                    'mobile' => $item['mobile'], 'is_active' => 1,
//                    'mobile_verified' => $item['mobile_verified'],
//                    'email_verified_at' => $item['email_verified_at'],
//                    'password' => $item['password'],
//                    'referral_code' => $item['referral_code'],
//                    'created_at' => $item['created_at'],
//                    'updated_at' => $item['updated_at'],
//
//                ]);
            }
        }
    }
}
