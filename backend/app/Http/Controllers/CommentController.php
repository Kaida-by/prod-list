<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(protected Comment $comment) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Comment::all()
        ]);
    }

    public function create(Request $request): ?JsonResponse
    {
        $this->comment->text = $request['text'];
        $this->comment->user_id = $request['user_id'];

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

    public function update(Request $request, Comment $comment): ?JsonResponse
    {
        try {
            $comment->update([
                'text' => $request['text'],
                'user_id' => $request['user_id'],
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
