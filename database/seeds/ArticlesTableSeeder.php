<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取所有的用户ID
        $userIds = \App\Models\User::all()->pluck('id')->toArray();

        // 获取所有的分类ID
        $categoryIds = \App\Models\Category::all()->pluck('id')->toArray();

        // 获取 faker 实例
        $faker = app(Faker\Generator::class);

        $articles = factory(\App\Models\Article::class)
                    ->times(100)
                    ->make()
                    ->each(function ($article, $index) use ($userIds, $categoryIds, $faker) {
                        $article->user_id = $faker->randomElement($userIds);
                        $article->category_id = $faker->randomElement($categoryIds);
                    });

        \App\Models\Article::insert($articles->toArray());
    }
}
