<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment_id' => Str::uuid(), // Generates a unique UUID for the comment_id
            'user_id' => Str::random(10), // Generates a random string for user_id
            'page_id' => Str::uuid(), // Generates a random UUID for page_id (this should be linked to a real Page model in actual usage)
            'message_text' => $this->faker->sentence(), // Generates a random sentence for the comment message
        ];
    }
}
