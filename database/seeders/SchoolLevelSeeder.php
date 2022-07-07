<?php

namespace Database\Seeders;

use App\Models\School_level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_level')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $level = [
            [
                'level' => 'KB',
            ],
            [
                'level' => 'TK',
            ],
            [
                'level' => 'SD',
            ],
            [
                'level' => 'SMP',
            ],
            [
                'level' => 'SMA',
            ],
            [
                'level' => 'SMK',
            ],
        ];

        foreach ($level as $key => $value) {
            School_level::create($value);
        }
    }
}
