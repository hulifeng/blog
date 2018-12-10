<?php

use Illuminate\Database\Seeder;

class ArticleTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $article_ids = \App\Models\Article::where('is_del', 0)->where('is_hidden', 1)->get()->pluck('id')->toArray();

        $tag_ids = \App\Models\Tag::all();

        $faker = app(Faker\Generator::class);

        $articleTags = factory();
    }
}
