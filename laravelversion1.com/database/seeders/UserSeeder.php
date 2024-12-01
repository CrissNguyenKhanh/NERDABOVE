<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản mặc định
        User::create([
            'name' => 'Quoc Khanh',
            'phone' => '0123456789',
            'province_id' => null,
            'district_id' => null,
            'ward_id' => null,
            'address' => '123 Test Street',
            'birthday' => now()->subYears(25),
            'image' => null,
            'description' => 'This is a default user for testing.',
            'user_agent' => 'Seeder Script',
            'ip' => '127.0.0.1',
            'email' => 'quockhanhdz295@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'), // Mã hóa mật khẩu
        ]);

        // Thêm 100,000 user bằng Factory
        User::factory()->count(10)->create();
    }
}
