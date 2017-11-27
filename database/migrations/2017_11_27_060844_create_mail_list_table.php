<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mail_list')) {
            Schema::create('mail_list', function (Blueprint $table) {
                $table->engine = 'MyISAM';
                $table->increments('Id')->comment('自增主键');
                $table->string('Name', 250)->default('')->comment('邮件名');
                $table->string('Mail', 250)->default('')->comment('邮件');
                $table->enum('Status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->comment('状态');
                $table->dateTime('AddTime')->comment('添加时间');
                $table->dateTime('UpdateTime')->comment('更新时间');
                $table->timestamp('Timestamp')->comment('系统更新时间戳');
                $table->unique('Mail');
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
        Schema::dropIfExists('mail_list');
    }
}
