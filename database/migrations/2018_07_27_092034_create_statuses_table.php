<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            // 后面我们会借助 user_id 来查找指定用户发布过的所有微博，因此为了提高查询效率，这里我们需要为该字段加上索引
            $table->integer('user_id')->index();
            // 第三个则是为微博的创建时间添加索引，由于 timestamps 方法会为微博数据表生成一个微博创建时间字段 created_at 和一个微博更新时间字段 updated_at，因此在这里我们并不需要再手动创建。为微博的创建时间添加索引的目的是，后面我们会根据微博的创建时间进行倒序输出，并在页面上进行显示，使新建的微博能够排在比较靠前的位置。
            $table->index(['created_at']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}