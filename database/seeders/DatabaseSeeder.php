<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            ['company_name' => 'コカコーラ'],
            ['company_name' => 'サントリー'],
            ['company_name' => '伊藤園'],
            ['company_name' => 'ヤクルト'],
            ['company_name' => 'アサヒ'],
            ['company_name' => 'キリン'],
            ['company_name' => 'ブルボン'],
            ['company_name' => '森永乳業'],
            ['company_name' => '雪印メグミルク'],
            ['company_name' => 'カゴメ'],
            ['company_name' => 'スフレ'],
            ['company_name' => 'AGF'],
            ['company_name' => 'サンガリア'],
        ]);

    }
}
