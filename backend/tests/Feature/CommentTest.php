<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_comments_by_user_id(): void
    {
        $response = $this->getJson('api/auth/comments/get');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'text',
                    'user_id',
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_create_new_comment(): void
    {
        $data = [
            'text' => 'test',
            'user_id' => 1,
            'created_at' => now(),
        ];
        $response = $this->postJson('api/auth/comment/create', $data);
        $response->assertStatus(201);
    }

    public function test_update_comment(): void
    {
        $comment = Comment::findOrFail(1);

        $data = [
            'text' => 'new test',
            'user_id' => 2,
        ];
        $response = $this->patchJson('api/auth/comment/update/' . $comment->id, $data);
        $response->assertStatus(200);
    }

    public function test_delete_comment(): void
    {
        $comment = Comment::findOrFail(1);
        $response = $this->deleteJson('api/auth/comment/delete/' . $comment->id);
        $response->assertStatus(204);
    }
}
