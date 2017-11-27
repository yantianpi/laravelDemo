<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('log_list')) {
            Schema::create('log_list', function (Blueprint $table) {
                $table->engine = 'MyISAM';
                $table->increments('Id')->comment('自增主键');
                $table->enum('LogType', ['BASIC', 'EXECUTE', 'NOTIFY', 'OTHER'])->default('OTHER')->comment('日志类型');
                $table->unsignedBigInteger('MapId')->default(0)->comment('映射');
                $table->string('Program', 250)->default('')->comment('程序');
                $table->text('Keyword')->comment('查询关键词');
                $table->text('Content')->comment('内容详细');
                $table->enum('HasAlert', ['NO', 'YES'])->default('NO')->comment('是否产生通知');
                $table->dateTime('AddTime')->comment('添加时间');
                $table->dateTime('UpdateTime')->comment('更新时间');
                $table->timestamp('Timestamp')->comment('系统更新时间戳');
                $table->index('MapId');
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
        Schema::dropIfExists('log_list');
    }
}
