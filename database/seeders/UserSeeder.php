<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

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
