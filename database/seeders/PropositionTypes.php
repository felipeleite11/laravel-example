<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropositionTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proposition_types')->insert([
            'id' => 1,
            'description' => 'PROJETO DE DECRETO LEGISLATIVO'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 2,
            'description' => 'PROJETO DE EMENDA CONSTITUCIONAL'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 3,
            'description' => 'PROJETO DE DECRETO LEGISLATIVO'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 4,
            'description' => 'PROJETO DE INDICAÇÃO'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 5,
            'description' => 'PROJETO DE LEI'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 6,
            'description' => 'PROJETO DE LEI COMPLEMENTAR'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 7,
            'description' => 'PROJETO DE RESOLUÇÃO'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 8,
            'description' => 'MOÇÃO'
        ]);

        DB::table('proposition_types')->insert([
            'id' => 9,
            'description' => 'REQUERIMENTO'
        ]);
    }
}
