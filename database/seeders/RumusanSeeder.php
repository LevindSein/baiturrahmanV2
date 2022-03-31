<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class RumusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rumusan')->insert([
            [
                'kategori' => 1,
                'rumus'    => json_encode([
                    'satuan'     => "Liter",
                    'alternatif' => "Liter",
                    'rupiah'     => "8000",
                    'jiwa'       => "3.5"
                ]),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kategori' => 2,
                'rumus'    => json_encode([
                    'satuan'     => "Kilogram",
                    'alternatif' => "Kg",
                    'rupiah'     => "11200",
                    'jiwa'       => "2.5"
                ]),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
