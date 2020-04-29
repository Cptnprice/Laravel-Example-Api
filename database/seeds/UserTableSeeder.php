<?php

use Illuminate\Database\Seeder;
use App\User;
use App\database\factories\UserFactory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,25)->create();
    }
}
