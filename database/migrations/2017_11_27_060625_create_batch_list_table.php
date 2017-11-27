<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('batch_list')) {
            Schema::create('batch_list', function (Blueprint $table) {
                $table->engine = 'MyISAM';
                $table->increments('Id')->comment('自增主键');
                $table->string('Name', 250)->default('')->comment('批次');
                $table->string('Alias', 255)->default('')->comment('别名');
                $table->string('Crontime', 100)->default('')->comment('cron时间串');
                $table->integer('Throughput')->default(100)->comment('吞吐量-批次处理数据每次处理量');
                $table->enum('Status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->comment('状态');
                $table->dateTime('AddTime')->comment('添加时间');
                $table->dateTime('UpdateTime')->comment('更新时间');
                $table->timestamp('Timestamp')->comment('系统更新时间戳');
                $table->unique('Name');
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
        Schema::dropIfExists('batch_list');
    }
}
