<?php

namespace App\Data\ResourceData;

use App\Models\Comment;
use Spatie\LaravelData\Data;

class CommentDataResource extends Data
{
    public function __construct(
        public int $id,
        public string $text,
        public int $user_id,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromModel(Comment $comment): self
    {
        return new self(
            id: $comment->id,
            text: $comment->text,
            user_id: $comment->user_id,
            created_at: $comment->created_at,
            updated_at: $comment->updated_at,
        );
    }
}
