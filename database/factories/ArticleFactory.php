<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // get all the available category ids
        $categoryIds = Category::all()->pluck('id');
        $statuses = [0, 1];

        return [
            'title'       => $this->faker->sentence,
            'abstract'    => $this->faker->text(100),
            'contents'    => $this->faker->text(500),
            'category_id' => $this->faker->randomElement($categoryIds),
            'status'      => $this->faker->randomElement($statuses),
            'created_at'  => $this->faker->unique()->dateTimeThisYear()
        ];
    }
}
