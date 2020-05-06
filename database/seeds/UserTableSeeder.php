<?php

use Illuminate\Database\Seeder;
use App\User;
use App\database\factories\UserFactory;
use Spatie\Permission\Models\Role;

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
        $users = User::take(3)->get();

        foreach($users as $user){
            $user->roles()->save(Role::first());
        }
    }
}
