<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Page;
use App\Models\Statistic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // $this->call(UserSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Creating a page
        $page = Page::factory()->create();

        // Creating a comment for the page
        $comment = Comment::factory()->create([
            'page_id' => $page->page_id,
        ]);

        // Creating a message for the comment
        $message = Message::factory()->create([
            'comment_id' => $comment->comment_id,
        ]);

        // Creating statistics for the page
        $statistic = Statistic::factory()->create([
            'page_id' => $page->id,
        ]);
    }
}
