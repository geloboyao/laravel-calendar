<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // to run: php artisan db:seed
        Event::create([
            'name' => 'Sample Event',
            'from' => '2020-08-01',
            'to'   => '2020-08-31',
            'day'  => '["0","1","5","6"]'
        ]);
    }
}
