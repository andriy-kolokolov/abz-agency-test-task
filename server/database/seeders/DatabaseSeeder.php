<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run() : void
    {
        if (User::count() >= 45) {
            return;
        }

        $this->call([
            UserSeeder::class,
        ]);
    }
}
