<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nowDate = date('Y-m-d H:i:s');
        DB::table('task_list')->insert(
            [
                'Name' => '国内网速监控',
                'Description' => '通过百度监控百度首页，判断当前网络国内线路快慢',
                'ProjectId' => '1',
                'CategoryId' => '1',
                'Content' => '{"Arguments":{"content":"test","message":"Arguments\u6709\u8bef"},"BlackRegexOne":{"content":null,"message":"BlackRegexOne \u5b58\u5728"},"BlackStringOne":{"content":null,"message":"BlackStringOne \u5b58\u5728"},"Header":{"content":null,"message":"Header\u6709\u8bef"},"HttpCode":{"content":"200","message":"\u8fd4\u56de\u7801\u9519\u8bef"},"Method":{"content":"post","message":"Method\u6709\u8bef"},"ResponseTime":{"content":"3","message":"\u8d85\u65f63s"},"Url":{"content":"https:\/\/www.baidu.com","message":"url\u6709\u8bef"},"WhiteRegexOne":{"content":null,"message":"WhiteRegexOne \u4e0d\u5b58\u5728"},"WhiteStringOne":{"content":null,"message":"WhiteStringOne \u4e0d\u5b58\u5728"}}',
                'CronTime' => '*/10 * * * *',
                'Batch' => '0',
                'NotifyType' => 'MAIL',
                'NotifyContent' => '{"Title":"\u56fd\u5185\u7f51\u901f\u76d1\u63a7\u62a5\u8b66","Body":"\u76d1\u63a7\u4efb\u52a1\u62a5\u8b66","To":["1"],"Cc":["1"]}',
                'MonitorCount' => '0',
                'AlertCount' => '0',
                'SeriesAlertCount' => '0',
                'AlertLimit' => '5',
                'CurrentStatus' => 'PENDING',
                'Status' => 'ACTIVE',
                'StartTime' => $nowDate,
                'EndTime' => $nowDate,
                'AddTime' => $nowDate,
                'UpdateTime' => $nowDate,
            ]
        );
    }
}
