<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $article_ids = \App\Models\Article::where('is_del', 0)->where('is_hidden', 1)->get()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $comments = factory(\App\Models\Comment::class)
                    ->times(100)
                    ->make()
                    ->each(function ($comment, $index) use ($article_ids, $faker){
                        $comment->article_id = $faker->randomElement($article_ids);
                        \App\Models\Article::where('id', $comment->article_id)->increment('reply_count');
                    });

        \App\Models\Comment::insert($comments->toArray());
    }
}
