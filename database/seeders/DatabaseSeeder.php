<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $user = new User();
        $user->name = 'Site Admin';
        $user->email = 'user@email.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('user@email.com');
        $user->remember_token = Str::random(10);
        $user->save();
    }
}
