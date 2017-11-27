<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nowDate = date('Y-m-d H:i:s');
        DB::table('batch_list')->insert(
            [
                [
                    'Name' => 'per10minute',
                    'Alias' => '每10分钟',
                    'Crontime' => '*/10 * * * *',
                    'Throughput' => 100,
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'Name' => 'per30minute',
                    'Alias' => '每30分钟',
                    'Crontime' => '*/30 * * * *',
                    'Throughput' => 100,
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ]
            ]
        );
    }
}
