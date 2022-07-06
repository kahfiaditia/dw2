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
                'classes' => '1',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => '2',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => '3',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => '4',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => '5',
            ],
            [
                'school_level_id' => '3', // SD
                'classes' => '6',
            ],
            [
                'school_level_id' => '4', // SMP
                'classes' => '1',
            ],
            [
                'school_level_id' => '4', // SMP
                'classes' => '2',
            ],
            [
                'school_level_id' => '4', // SMP
                'classes' => '3',
            ],
            [
                'school_level_id' => '5', // SMA
                'classes' => '1',
            ],
            [
                'school_level_id' => '5', // SMA
                'classes' => '2',
            ],
            [
                'school_level_id' => '5', // SMA
                'classes' => '3',
            ],
            [
                'school_level_id' => '6', // SMK
                'classes' => '1',
            ],
            [
                'school_level_id' => '6', // SMK
                'classes' => '2',
            ],
            [
                'school_level_id' => '6', // SMK
                'classes' => '3',
            ],
        ];

        foreach ($level as $key => $value) {
            School_class::create($value);
        }
    }
}
