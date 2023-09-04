<?php

namespace App\Http\Controllers;

use App\Data\RequestData\CommentDataRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(protected Comment $comment) {}

    public function one(int $id): ?JsonResponse
    {
        try {
            $comments = Comment::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->first();

            return response()->json([
                'success' => true,
                'data' => CommentDataRequest::from($comments)
            ]);
        } catch (Exception $exeption) {
            return response()->json([
                'success' => false,
                'errors' => $exeption->errors(),
            ], 500);
        }
    }

    public function create(CommentDataRequest $commentDataRequest): ?JsonResponse
    {
        $this->comment->text = $commentDataRequest->text;
        $this->comment->user_id = auth()->id();

        try {
            $this->comment->save();

            return response()->json([
                'success' => true,
                'data' => $this->comment,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function update(CommentDataRequest $commentDataRequest, Comment $comment): ?JsonResponse
    {
        try {
            $comment->update([
                'text' => $commentDataRequest->text,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->comment,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

     public function delete(Comment $comment): ?JsonResponse
     {
         try {
             $comment->delete();

             return response()->json([
                 'success' => true,
             ], 204);
         } catch (Exception $exception) {
             return response()->json([
                 'success' => false,
                 'msg' => $exception->getMessage(),
             ]);
         }
     }
}
