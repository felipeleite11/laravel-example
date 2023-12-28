<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentAdministrations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_administrations')->insert([
            'id' => 1,
            'description' => 'Deputado'
        ]);

        DB::table('appointment_administrations')->insert([
            'id' => 2,
            'description' => 'Dr. Breno - Chefe de gabinete'
        ]);

        DB::table('appointment_administrations')->insert([
            'id' => 3,
            'description' => 'Dr. João - Jurídico'
        ]);

        DB::table('appointment_administrations')->insert([
            'id' => 4,
            'description' => 'Dr. Swami - Jurídico'
        ]);

        DB::table('appointment_administrations')->insert([
            'id' => 5,
            'description' => 'Gabinete Externo'
        ]);
    }
}
