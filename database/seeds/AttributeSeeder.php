<?php

use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nowDate = date('Y-m-d H:i:s');
        DB::table('attribute_list')->insert(
            [
                [
                    'CategoryId' => 1,
                    'Name' => 'Url',
                    'Alias' => 'Url',
                    'ContentType' => 'STRING',
                    'DefaultMessage' => 'url有误',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'Method',
                    'Alias' => 'Method',
                    'ContentType' => 'STRING',
                    'DefaultMessage' => 'Method有误',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'Arguments',
                    'Alias' => 'Arguments',
                    'ContentType' => 'STRING',
                    'DefaultMessage' => 'Arguments有误',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'Header',
                    'Alias' => 'Header',
                    'ContentType' => 'STRING',
                    'DefaultMessage' => 'Header有误',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'HttpCode',
                    'Alias' => 'HttpCode',
                    'ContentType' => 'INT',
                    'DefaultMessage' => 'HttpCode有误',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'ResponseTime',
                    'Alias' => 'ResponseTime',
                    'ContentType' => 'INT',
                    'DefaultMessage' => 'ResponseTime超时',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'WhiteStringOne',
                    'Alias' => 'WhiteStringOne',
                    'ContentType' => 'STRING',
                    'DefaultMessage' => 'WhiteStringOne 不存在',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'WhiteRegexOne',
                    'Alias' => 'WhiteRegexOne',
                    'ContentType' => 'REGEX',
                    'DefaultMessage' => 'WhiteRegexOne 不存在',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'BlackStringOne',
                    'Alias' => 'BlackStringOne',
                    'ContentType' => 'STRING',
                    'DefaultMessage' => 'BlackStringOne 存在',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
                [
                    'CategoryId' => 1,
                    'Name' => 'BlackRegexOne',
                    'Alias' => 'BlackRegexOne',
                    'ContentType' => 'STRING',
                    'DefaultMessage' => 'BlackRegexOne 存在',
                    'Status' => 'ACTIVE',
                    'AddTime' => $nowDate,
                    'UpdateTime' => $nowDate,
                ],
            ]
        );
    }
}
