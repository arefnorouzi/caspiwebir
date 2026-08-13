<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $support_reply = null;
        $support_id = null;
        $status = 0;
        if (rand(0, 1)) {
            $support_id = rand(1, 2);
            $support_reply = $this->faker->sentence();
            $status = 1;
        }
        return [
            'description' => $this->faker->sentence(),
            'user_id' => rand(1, 10),
            'support_reply' => $support_reply,
            'support_id' => $support_id,
            'status' => $status,

            // commentable_id and commentable_type will be set via states
        ];
    }

    /**
     * Assign the comment to a specific commentable model.
     */
    public function forCommentable(\Illuminate\Database\Eloquent\Model $model): static
    {
        return $this->state([
            'commentable_id' => $model->getKey(),
            'commentable_type' => get_class($model),
        ]);
    }

    /**
     * State for Product comments.
     */
    public function forProduct(): static
    {
        return $this->state(fn (array $attributes) => [
            'commentable_id' => Product::factory(),
            'commentable_type' => Product::class,
        ]);
    }

    /**
     * State for Post comments.
     */
    public function forPost(): static
    {
        return $this->state(fn (array $attributes) => [
            'commentable_id' => Post::factory(),
            'commentable_type' => Post::class,
        ]);
    }

    /**
     * Randomly assign to either Product or Post.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Comment $comment) {
            if (!$comment->commentable_type) {
                $type = $this->faker->randomElement([Product::class, Post::class]);
                $comment->commentable_type = $type;
                $comment->commentable_id = $type::factory();
            }
        });
    }
}
