<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('文章标题');
            $table->longText('content_html')->comment('文章内容html');
            $table->longText('content_markdown')->comment('文章内容markdown');
            $table->string('cover')->comment('文章封面');
            $table->unsignedInteger('user_id')->comment('作者ID');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->unsignedInteger('view_count')->default(0)->comment('浏览数量');
            $table->unsignedInteger('reply_count')->default(0)->comment('回复数量');
            $table->unsignedInteger('like_count')->default(0)->comment('点赞数量');
            $table->tinyInteger('is_original')->default(0)->comment('是否为原创 0否 1是');
            $table->tinyInteger('is_del')->default(0)->comment('是否删除 0否 1是');
            $table->tinyInteger('is_top')->default(0)->comment('是否置顶 0否 1是');
            $table->tinyInteger('is_hidden')->default(0)->comment('是否发布 0草稿 1发布');
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
        Schema::dropIfExists('articles');
    }
}
