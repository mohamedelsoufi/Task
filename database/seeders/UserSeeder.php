<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $names = ['mohamed', 'ahmed', 'khalid', 'omar', 'marwan'];

        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $names[$i],
                'image' => 'default.png',
                'email' => $names[$i] . '@app.com',
                'password' => '123456',
                'is_admin' => $i == 0 ? 1 : 0,
            ]);

        }
    }
}
