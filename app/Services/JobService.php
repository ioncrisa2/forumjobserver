<?php

namespace App\Services;

use App\Cloudinary\CloudinaryStorage;
use Carbon\Carbon;
use App\Models\Jobs;
use App\Models\Types;
use App\Traits\AuthUser;
use App\Traits\ImageHelper;

class JobService
{
    use AuthUser, ImageHelper;

    public function showAll($request)
    {
        return Jobs::latest('created_at')->get();
    }

    public function storeData(array $data)
    {
        if ($data['poster']) {
            // $image = $this->uploadToServer('public/poster', $data['poster']);
            $image = $data['poster'];
            $poster = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
        }
        $typeArr = [];

        foreach ($data['type'] as $index => $value) {
            $types = Types::firstOrCreate(
                ['name' => $value],
                ['name' => $value]
            );
            $typeArr[$index] = $types->id;
        }

        $job = new Jobs();
        $job->user_id = auth('api')->user()->id;
        $job->company_id = $data['company_id'];
        $job->job_name = $data['job_name'];
        $job->job_description = $data['job_description'];
        $job->poster = $poster != null ? $poster : null;
        $job->end_date = Carbon::parse($data['end_date'])->format('Y-m-d');
        $job->save();

        $job->types()->attach($typeArr);

        return $job;
    }

    public function showData($id)
    {
        return Jobs::with('company')->whereId($id)->first();
    }

    public function updateData($id, array $data)
    {
        $job = Jobs::find($id);

        $typeArr = [];

        foreach ($data['type'] as $index => $value) {
            $types = Types::firstOrCreate(
                ['name' => $value],
                ['name' => $value]
            );
            $typeArr[$index] = $types->id;
        }

        if ($data['poster']) {
            $image = $data['poster'];

            $poster = CloudinaryStorage::replace($image, $image->getRealPath(), $image->getClientOriginalName());

            $job->user_id = auth('api')->user()->id;
            $job->company_id = $data['company_id'];
            $job->job_name = $data['job_name'];
            $job->job_description = $data['job_description'];
            $job->poster = $poster;
            $job->end_date = Carbon::parse($data['end_date'])->format('Y-m-d');
            $job->save();

            $job->types()->sync($typeArr);
        } else if ($data['poster'] == null) {
            $job->user_id = auth('api')->user()->id;
            $job->company_id = $data['company_id'];
            $job->job_name = $data['job_name'];
            $job->job_description = $data['job_description'];
            $job->end_date = Carbon::parse($data['end_date'])->format('Y-m-d');
            $job->save();
        }

        $job->types()->sync($typeArr);

        return $job;
    }

    public function deleteData($id)
    {
        $job = Jobs::findOrFail($id);
        $job->types()->detach();
        CloudinaryStorage::delete($job->poster);
        $job->delete();
    }
}
