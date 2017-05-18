<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    use DatabaseTransaction
    //rolls back transaction at the end of every test

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        //create world
        $first = $factory(Post::class)->create();
        $second = $factory(Post::class)->create([
          'created_at' => \Carbon\Carbon::now()->subMonth()
        ]);

        //when perform action
        $posts = Post::archives();

        //this is desired result
        $this->assertEquals([
          [
            "year" => $first->created_at->format('Y'),
            "month" => $first->created_at->format('F'),
            "published" => 1
          ],

          [
            "year" => $second->created_at->format('Y'),
            "month" => $second->created_at->format('F'),
            "published" => 1
          ]
        ], $posts)

    }
}
