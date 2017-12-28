<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('task_list')) {
            Schema::create('task_list', function (Blueprint $table) {
                $table->engine = 'MyISAM';
                $table->increments('Id')->comment('自增主键');
                $table->string('Name', 250)->default('')->comment('项目名');
                $table->text('Description')->nullable()->comment('描述');
                $table->unsignedBigInteger('ProjectId')->default(0)->comment('项目');
                $table->unsignedBigInteger('CategoryId')->default(0)->comment('分类');
                $table->text('Content')->nullable()->comment('内容');
                $table->string('CronTime', 100)->default('')->comment('cron时间串');
                $table->integer('Batch')->default(0)->comment('cron批次，0代表单独cron处理；其他表示批处理对应batch_list里id');
                $table->enum('NotifyType', ['MAIL', 'OTHER'])->default('OTHER')->comment('通知类型');
                $table->text('NotifyContent')->nullable()->comment('通知配置项');
                $table->unsignedBigInteger('MonitorCount')->default(0)->comment('执行次数');
                $table->unsignedBigInteger('AlertCount')->default(0)->comment('通知次数');
                $table->unsignedBigInteger('SeriesAlertCount')->default(0)->comment('连续通知次数');
                $table->unsignedBigInteger('AlertLimit')->default(0)->comment('通知上限，超过上限，不产生通知');
                $table->enum('CurrentStatus', ['PENDING', 'PROCESSING', 'RESLOVED'])->default('PENDING')->comment('当前状态');
                $table->enum('Status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->comment('状态');
                $table->dateTime('StartTime')->comment('执行开始时间');
                $table->dateTime('EndTime')->comment('执行结束时间');
                $table->dateTime('AddTime')->comment('添加时间');
                $table->dateTime('UpdateTime')->comment('更新时间');
                $table->timestamp('Timestamp')->comment('系统更新时间戳');
                $table->index('ProjectId');
                $table->index('CategoryId');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_list');
    }
}
