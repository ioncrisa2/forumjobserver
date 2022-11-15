<?php

namespace App\Services;

use App\Models\User;
use App\Models\Forum;
use App\Traits\AuthUser;
use Illuminate\Support\Str;

class ForumService
{
    use AuthUser;

    public function showAll()
    {
        return Forum::all();
    }

    public function storeData($data)
    {
        $user = $this->getAuthUser();

        $forum = $user->forums()->create([
            'title'         => $data['title'],
            'body'          => $data['body'],
            'slug'          => Str::slug($data['title'], '-'),
            'category'      => $data['category']
        ]);

        return Forum::findOrFail($forum->id);
    }

    public function showDetail($id)
    {
        return Forum::findOrFail($id);
    }

    public function updateData($id, $data)
    {
        $forum = Forum::findOrFail($id);
        $this->checkOwnership($forum->id);
        $forum->update([
            'title'     => $data['title'],
            'body'      => $data['body'],
            'category'  => $data['category']
        ]);

        return $forum;
    }

    public function deleteData($id)
    {
        $forum = Forum::findOrFail($id)->first;
        $this->getAuthUser();
        $this->checkOwnership($forum->user_id);

        $forum->delete();
    }
}
