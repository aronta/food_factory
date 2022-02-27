<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('languages')->updateOrInsert([
            'locale' => 'hr',
            'language_name' => 'hrvatski',
        ]);

        DB::table('languages')->updateOrInsert([
            'locale' => 'en',
            'language_name' => 'english',
        ]);

        DB::table('languages')->updateOrInsert([
            'locale' => 'it',
            'language_name' => 'italian',
        ]);

        DB::table('languages')->updateOrInsert([
            'locale' => 'de',
            'language_name' => 'deutsch',
        ]);
    }
}
