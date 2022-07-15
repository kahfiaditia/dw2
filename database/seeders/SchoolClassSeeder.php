<?php

namespace Database\Seeders;

use App\Models\School_class;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_class')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $level = [
            // [
            //     'school_level_id' => '1', // KB
            //     'classes' => '1',
            // ],
            // [
            //     'school_level_id' => '2', // TK
            //     'classes' => '1',
            // ],
            [
                'school_level_id' => '3', // SD
                'classes' => 'I',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => 'II',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => 'III',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => 'IV',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => 'V',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => 'VI',
            ],
            [
                'school_level_id' => '4', // SMP
                'classes' => 'VII',
            ],
            [
                'school_level_id' => '4', // SMP
                'classes' => 'VIII',
            ],
            [
                'school_level_id' => '4', // SMP
                'classes' => 'IX',
            ],
            [
                'school_level_id' => '5', // SMA
                'classes' => 'X',
            ],
            [
                'school_level_id' => '5', // SMA
                'classes' => 'XI',
            ],
            [
                'school_level_id' => '5', // SMA
                'classes' => 'XII',
            ],
            [
                'school_level_id' => '6', // SMK
                'classes' => 'X',
            ],
            [
                'school_level_id' => '6', // SMK
                'classes' => 'XI',
            ],
            [
                'school_level_id' => '6', // SMK
                'classes' => 'XII',
            ],
        ];

        foreach ($level as $key => $value) {
            School_class::create($value);
        }
    }
}
