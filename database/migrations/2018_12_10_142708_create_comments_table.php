<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content')->comment('回复内容');
            $table->string('author')->nullable()->comment('水军ID');
            $table->string('email')->nullable()->comment('水军邮箱');
            $table->string('website')->nullable()->comment('水军网站');
            $table->unsignedInteger('article_id')->comment('文章ID');
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
        Schema::dropIfExists('comments');
    }
}
