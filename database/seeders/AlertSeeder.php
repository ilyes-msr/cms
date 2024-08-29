<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alert;
use App\Models\User;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alert1 = Alert::create([
            'user_id' => User::where('name', 'Eyad Hasan')->first()->id,
            'alert' => '3',
        ]);

        $alert2 = Alert::create([
            'user_id' => User::where('name', 'Hasan dani')->first()->id,
            'alert' => '1',
        ]);

        $alert3 = Alert::create([
            'user_id' => User::where('name', 'Mohamed Ali')->first()->id,
            'alert' => '0',
        ]);
    }
}
