<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProductionUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate
        User::truncate();

        // Data
        $data = [
            [
                'id' => 7,
                'name' => 'Sammuel Henque Ferreira Gomes',
                'email' => 'sammuelhg@gmail.com',
                'avatar' => 'https://lh3.googleusercontent.com/a/ACg8ocIA13BZi-1ai4yaBv5hOwurBhfGe8ZXb5CRws9J8DLVDaC-L-Sy=s96-c',
                'google_id' => '114857707516784083594',
                'facebook_id' => '10229218207573044',
                'phone' => '(31) 99416-1000',
                'taxvat' => '039.204.876-05',
                'address' => null,
                'birth_date' => null,
                'is_admin' => 1,
                'email_verified_at' => '2025-12-17 12:00:00',
                'password' => Hash::make('!Sa002125'),
                'remember_token' => null,
                'created_at' => '2025-11-30 02:03:56',
                'updated_at' => '2025-12-04 13:02:33',
            ],
            [
                'id' => 12,
                'name' => 'Vinocracia Clube de Vinhos',
                'email' => 'vinocrata@gmail.com',
                'avatar' => 'https://lh3.googleusercontent.com/a/ACg8ocJz-FmNFD75jLSHNi_7GxQRmxhCnbSxGJW-yUCSr5qDnFiv5YOC=s96-c',
                'google_id' => '104586627428385381885',
                'facebook_id' => null,
                'phone' => null,
                'taxvat' => null,
                'address' => null,
                'birth_date' => null,
                'is_admin' => 0,
                'email_verified_at' => null,
                'password' => null,
                'remember_token' => null,
                'created_at' => '2025-12-05 15:21:17',
                'updated_at' => '2025-12-05 15:21:17',
            ],
            [
                'id' => 13,
                'name' => 'Los Fit',
                'email' => 'losfit1000@gmail.com',
                'avatar' => 'https://lh3.googleusercontent.com/a/ACg8ocKr7IXHii49mPWh28JJuIrNLbYOOR875sbFxAq7Q680-LmsQQ=s96-c',
                'google_id' => '106851467777243218374',
                'facebook_id' => null,
                'phone' => null,
                'taxvat' => null,
                'address' => null,
                'birth_date' => null,
                'is_admin' => 0,
                'email_verified_at' => null,
                'password' => null,
                'remember_token' => null,
                'created_at' => '2025-12-07 19:42:23',
                'updated_at' => '2025-12-07 19:42:23',
            ],
        ];

        foreach ($data as $item) {
            User::create($item);
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
