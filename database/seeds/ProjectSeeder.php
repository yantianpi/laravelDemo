<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nowDate = date('Y-m-d H:i:s');
        DB::table('project_list')->insert(
            [
                'Name' => 'pp',
                'Status' => 'ACTIVE',
                'AddTime' => $nowDate,
                'UpdateTime' => $nowDate,
            ]
        );
    }
}
