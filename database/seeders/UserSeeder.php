<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::query()->count()) {
            User::query()->upsert($this->getAdminsList(), ['email']);
            User::query()->create([
                'first_name' => 'First',
                'last_name' => 'Customer',
                'email' => 'customer_test@yopmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            User::factory()->count(250)->create();
        }
    }

    private function getAdminsList()
    {
        return [
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin_test@yopmail.com',
                'password' => bcrypt(123456),
                'type' => ADMIN_TYPE,
            ],
        ];
    }
}
