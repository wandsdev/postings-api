<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Posting;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = 1;
        Person::factory()->state([
            'user_id' => $id
        ])->count(3)->has(
            Posting::factory()->state([
                'user_id' => $id
            ])->count(3)
        )->create();

        $id = 2;
        Person::factory()->state([
            'user_id' => $id
        ])->count(3)->has(
            Posting::factory()->state([
                'user_id' => $id
            ])->count(3)
        )->create();
    }
}
