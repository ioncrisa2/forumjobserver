<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumRequest;
use App\Http\Resources\ForumResource;
use App\Models\Forum;
use App\Traits\AuthUser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    use AuthUser;

    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function index()
    {
        try{
            $forum = Forum::all();

            return responseSuccess(true, 'Success', $forum, Response::HTTP_OK);
        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    public function store(ForumRequest $request)
    {
        try{
            $request->validated();
            $user = $this->getAuthUser();

            $user->forums()->create([
                'title'         => $request->title,
                'body'          => $request->body,
                'slug'          => Str::slug($request->title,'-'),
                'category'      => $request->category
            ]);

            return response()->json(['message'=>'Successfully Posted!'],201);
        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    public function show($id)
    {
        try{
            $forum = Forum::findOrFail($id);
            return responseSuccess(true, 'Success', $forum, Response::HTTP_OK);
        }catch(QueryException $e){
            return responseError(false,$e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function update(ForumRequest $request, $id)
    {
        try{
            $request->validated();
            $forum = Forum::findOrFail($id)->first();

            $this->checkOwnership($forum->id);


            $forum->update([
                'title' => $request->title,
                'body' => $request->body,
                'category' => $request->category
            ]);

            return responseSuccess(true, 'Success', $forum, Response::HTTP_OK);
        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    public function destroy($id)
    {
        $forum = Forum::find($id);
        $this->getAuthUser();
        $this->checkOwnership($forum->user_id);

        $forum->delete();

        return responseSuccess(true, 'Success', $forum, Response::HTTP_OK);
    }
}
