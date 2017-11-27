<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nowDate = date('Y-m-d H:i:s');
        DB::table('category_list')->insert(
            [
                'Name' => 'simpleurlmonitor',
                'Alias' => '简单url监控',
                'Script' => 'ApiSimpleUrlGrab.php',
                'Status' => 'ACTIVE',
                'AddTime' => $nowDate,
                'UpdateTime' => $nowDate,
            ]
        );
    }
}
