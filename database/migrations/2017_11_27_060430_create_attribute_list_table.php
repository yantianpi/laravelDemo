<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('attribute_list')) {
            Schema::create('attribute_list', function (Blueprint $table) {
                $table->engine = 'MyISAM';
                $table->increments('Id')->comment('自增主键');
                $table->unsignedBigInteger('CategoryId')->default(0)->comment('分类id');
                $table->string('Name', 191)->default('')->comment('属性名');
                $table->string('Alias', 255)->default('')->comment('别名');
                $table->enum('ContentType', ['INT', 'STRING', 'REGEX', 'FLOAT', 'OTHER'])->default('OTHER')->comment('属性类型');
                $table->text('DefaultMessage')->nullable()->comment('默认消息');
                $table->enum('Status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->comment('状态');
                $table->dateTime('AddTime')->comment('添加时间');
                $table->dateTime('UpdateTime')->comment('更新时间');
                $table->timestamp('Timestamp')->comment('系统更新时间戳');
                $table->unique(['CategoryId', 'Name']);
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
        Schema::dropIfExists('attribute_list');
    }
}
