<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesSeederTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name' => '教程',
                'description' => '纷繁世界，唯有教程不可辜负',
            ],
            [
                'name' => '设计',
                'description' => '身处乱世，唯有设计不可戏弄',
            ],
            [
                'name' => '文档',
                'description' => '三分天下，唯有文档可破千军',
            ],
            [
                'name' => '宝典',
                'description' => '葵花宝典，切勿男人拿来修炼',
            ],
        ];
        \DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('categories')->truncate();
    }
}
