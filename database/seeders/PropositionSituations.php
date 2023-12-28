<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropositionSituations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proposition_situations')->insert([
            'id' => 1,
            'description' => 'APROVADO'
        ]);

        DB::table('proposition_situations')->insert([
            'id' => 2,
            'description' => 'ARQUIVADO'
        ]);

        DB::table('proposition_situations')->insert([
            'id' => 3,
            'description' => 'EM TRÂMITE'
        ]);
    }
}
