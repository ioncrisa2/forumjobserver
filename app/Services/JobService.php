<?php

namespace App\Services;

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
        $jobs = Jobs::when(
            $request,
            fn ($job) =>
            $job->orWhere('job_name', 'like', '%' . $request . '%')->orWhereHas(
                'company',
                fn ($company) => $company->where('name', 'like', '%' . $request . '%')
            )
        )->orderBy('id', 'DESC')->paginate(5);

        return $jobs;
    }

    public function storeData(array $data)
    {
        $image = $this->uploadToServer('public/poster', $data['poster']);
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
        $job->poster = $image;
        $job->end_date = $data['end_date'];
        $job->save();

        $job->types()->attach($typeArr);

        return $job;
    }

    public function showData($id)
    {
        return Jobs::findOrFail($id);
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
            $filePath = "poster/" . basename($data['poster']);

            $this->deleteFromServer('public', $filePath);

            $poster = $this->uploadToServer('poster', $data['poster']);

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

            $job->types()->sync($typeArr);
        }

        return $job;
    }

    public function deleteData($id)
    {
        $job = Jobs::findOrFail($id);
        $job->types()->detach();
        $this->deleteFromServer('public', "poster/" . basename($job->poster));
        $job->delete();
    }
}
