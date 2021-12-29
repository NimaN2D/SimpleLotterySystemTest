<?php

namespace Tests\Feature\Admin;

use App\Models\Lottery;
use App\Models\User;
use App\Repositories\LotteryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LotteryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_lotteries_page()
    {
        /**@var $admin User */
        $admin = User::factory()->create([
            'type' => ADMIN_TYPE,
            'password' => bcrypt($password = 'Nima Nouri')
        ]);

        $res = $this->actingAs($admin)->get(route('admin.lottery.index'));
        $res->assertViewIs('admin.dashboard');
    }

    public function test_admin_can_see_create_new_lottery_page()
    {
        /**@var $admin User */
        $admin = User::factory()->create([
            'type' => ADMIN_TYPE,
            'password' => bcrypt($password = 'Nima Nouri')
        ]);

        $res = $this->actingAs($admin)->get(route('admin.lottery.create'));
        $res->assertViewIs('admin.lottery.create');
    }

    public function test_admin_can_create_new_lottery()
    {
        /**@var $admin User */
        $admin = User::factory()->create([
            'type' => ADMIN_TYPE,
            'password' => bcrypt($password = 'Nima Nouri')
        ]);

        $this->post('/login',[
            'email' => $admin->email,
            'password' => $password
        ]);

        $this->post(route('admin.lottery.store'), [
            'name' => $lottery_name = 'Test Lottery',
            'maximum_winners' => $maximum_winners = 123,
        ]);

        $this->assertDatabaseHas(with(new Lottery)->getTable(), [
            'name' => $lottery_name,
            'maximum_winners' => $maximum_winners
        ]);
    }
}
