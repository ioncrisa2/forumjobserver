<?php

namespace App\Http\Controllers\Api;

use App\Traits\AuthUser;
use App\Services\ForumService;
use Illuminate\Http\Response;
use App\Http\Requests\ForumRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ForumController extends Controller
{
    protected $forumService;

    public function __construct()
    {
        $this->forumService = new ForumService();
        return auth()->shouldUse('api');
    }

    public function index()
    {
        try {
            $forum = $this->forumService->showAll();

            return responseSuccess(true, 'Semua Data Forum', $forum, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function store(ForumRequest $request)
    {
        try {
            $request->validated();

            $forum = $this->forumService->storeData($request->all());

            return responseSuccess(true, "Success Adding Forum", $forum, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $forum = $this->forumService->showDetail($id);
            return responseSuccess(true, 'Success', $forum, Response::HTTP_OK);
        } catch (QueryException $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function update(ForumRequest $request, $id)
    {
        try {
            $request->validated();
            $forum = $this->forumService->updateData($id, $request->all());

            return responseSuccess(true, 'Success', $forum, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        $this->forumService->deleteData($id);

        return responseSuccess(true, 'Success', '', Response::HTTP_OK);
    }
}
