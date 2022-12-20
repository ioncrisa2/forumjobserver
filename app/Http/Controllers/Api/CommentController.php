<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Forum;
use App\Services\CommentService;
use App\Traits\AuthUser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use AuthUser;

    private CommentService $commentService;

    public function __construct()
    {
        $this->commentService = new CommentService();
    }

    public function store(Request $request, Forum $forum)
    {
        try {
            $this->getValidateInput();

            $this->commentService->storeComment($request->all(), $forum);

            return response()->json(['message' => 'Succesfully Posted Comment!'], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, Forum $forum, Comment $comment)
    {
        try {
            $this->getValidateInput();

            $this->commentService->updatedComment($request->all(), $forum, $comment);

            return response()->json(['message' => 'Success Updated Comments!'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function destroy(Forum $forum, Comment $comment)
    {
        try {
            $comments = Comment::find($comment->id)->first();
            $this->checkOwnership($comments->user_id);
            $comments->delete();

            return response()->json(['message' => 'success delete comment!'], 204);
        } catch (QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    protected function getValidateInput()
    {
        $validator = Validator::make(request()->all(), [
            'body' => 'required'
        ]);

        if ($validator->fails()) {
            response()->json($validator->errors(), 422)->send();
            exit;
        }
    }
}
