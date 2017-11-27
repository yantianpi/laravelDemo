<?php

use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nowDate = date('Y-m-d H:i:s');
        DB::table('log_list')->insert(
            [
                'LogType' => 'OTHER',
                'MapId' => 0,
                'Program' => 'LogSeeder.php',
                'Keyword' => 'init loginit log',
                'Content' => 'log日志初始化第一条记录',
                'HasAlert' => 'NO',
                'AddTime' => $nowDate,
                'UpdateTime' => $nowDate,
            ]
        );
    }
}
