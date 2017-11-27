<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nowDate = date('Y-m-d H:i:s');
        DB::table('mail_list')->insert(
            [
                'Name' => 'peteryan',
                'Mail' => '1262233230@qq.com',
                'Status' => 'ACTIVE',
                'AddTime' => $nowDate,
                'UpdateTime' => $nowDate,
            ]
        );
    }
}
