<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            CategoriesSeeder::class,
            PostSeeder::class,
            PermissionsSeeder::class,
            CommentsSeeder::class,
            NotificationSeeder::class,
            AlertSeeder::class,
        ]);
    }
}
