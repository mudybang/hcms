<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = new UserModel;

        $user = new User([
            'username'  =>    'mudybang',
            'email'     =>    's.bagoes@gmail.com',
            'password'  =>    'Iamnew1213!',
            'active'    =>    1
        ]);
        $users->save($user);
        $user = $users->findById($users->getInsertID());
        $users->addToDefaultGroup($user);
        
        //faker begin
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $user = new User([
                'username'  =>    $faker->userName,
                'email'     =>    $faker->email,
                'password'  =>    '12341234',
                'active'    =>    1
            ]);
            $users->save($user);
            $user = $users->findById($users->getInsertID());
            $users->addToDefaultGroup($user);
        }
    }
}
