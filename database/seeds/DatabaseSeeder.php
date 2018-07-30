<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // 用户
        $this->call(UsersTableSeeder::class);
        // 微博
        $this->call(StatusesTableSeeder::class);
        // 粉丝和关注
        $this->call(FollowersTableSeeder::class);

        Model::reguard();
    }
}
