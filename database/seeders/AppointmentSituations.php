<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSituations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_situations')->insert([
            'id' => 1,
            'description' => 'Em Trâmite'
        ]);

        DB::table('appointment_situations')->insert([
            'id' => 2,
            'description' => 'Atendido'
        ]);

        DB::table('appointment_situations')->insert([
            'id' => 3,
            'description' => 'Não Atendido'
        ]);

        DB::table('appointment_situations')->insert([
            'id' => 4,
            'description' => 'Arquivado'
        ]);
    }
}
