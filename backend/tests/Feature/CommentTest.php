<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\HelperForTests;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use HelperForTests;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = $this->getAuthUser()['token'];
    }

    public function testGetAllCommentsByUserId(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/comments/get');
        $response->assertOk();
        $response->assertStatus(200)
            ->assertJsonStructure([
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

    public function testCreateNewComment(): void
    {
        $data = [
            'text' => 'test',
            'user_id' => 1,
            'created_at' => now(),
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/comment/create', $data);
        $response->assertStatus(201);
    }

    public function testUpdateComment(): void
    {
        $comment = Comment::findOrFail(1);

        $data = [
            'text' => 'new test',
            'user_id' => 2,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->patchJson('api/comment/update/' . $comment->id, $data);
        $response->assertStatus(200);
    }

    public function testDeleteComment(): void
    {
        $comment = Comment::findOrFail(1);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->deleteJson('api/comment/delete/' . $comment->id);
        $response->assertStatus(204);
    }
}
