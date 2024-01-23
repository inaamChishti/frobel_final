<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $old_user = DB::connection('mysql2')->table('users')->get();

        foreach ($old_user as $user) {
            DB::connection('mysql')->table('users')->insert([
                'name'     => $user->username,
                'username'     => $user->username,
                'email'    => 'user@biztechsols'. rand(10, 10000). Str::random(3) .'.com',
                'password' => $user->password,
                'custom_password' => 12345678
            ]);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@frobel.uk',
            'email_verified_at' => now(),
            'password' => 12345678,
            'remember_token' => Str::random(10),
            'custom_password' => 12345678
        ]);

        $devUser = User::create([
            'name' => 'Dev User',
            'username' => 'biztechsols',
            'email' => 'dev@biztechsols.com',
            'email_verified_at' => now(),
            'password' => 12345678,
            'remember_token' => Str::random(10),
            'custom_password' => 12345678
        ]);

        $role = Role::where('name', 'Super Admin')->first();

        if ($role) {
            $user->roles()->attach($role->id);
            $devUser->roles()->attach($role->id);
        }
    }
}
