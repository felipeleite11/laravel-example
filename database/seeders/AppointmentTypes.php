<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_types')->insert([
            'id' => 1,
            'description' => 'Assessoria Jurídica'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 2,
            'description' => 'Casos Agente de Segurança'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 3,
            'description' => 'Consulta Médica'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 4,
            'description' => 'Chefe de Gabinete'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 5,
            'description' => 'Documentação'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 6,
            'description' => 'Exames Clínicos'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 7,
            'description' => 'Medicamentos'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 8,
            'description' => 'IURD'
        ]);

        DB::table('appointment_types')->insert([
            'id' => 9,
            'description' => 'Outros'
        ]);
    }
}
