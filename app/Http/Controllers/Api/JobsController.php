<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobImportRequest;
use App\Http\Requests\JobRequest;
use App\Imports\JobImport;
use App\Models\Jobs;
use App\Traits\AuthUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Throwable;

class JobsController extends Controller
{
    use AuthUser;

    public function index()
    {
        try {
            $searchByQuery = request('q');
            $jobs = Jobs::when(
                $searchByQuery,
                fn ($job) =>
                $job->orWhere('job_name', 'like', '%' . $searchByQuery . '%')
                    ->orWhereHas('company', fn ($company) =>
                    $company->where('name', 'like', '%' . $searchByQuery . '%'))
            )->orderBy('id', 'DESC')->paginate(5);

            return responseSuccess(true, 'Success', $jobs, Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->responseError(false, $e->getMessage(), null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(JobRequest $request)
    {
        try {
            $request->validated();

            $poster = $request->file('poster');
            $poster->storeAs('poster', $poster->hashName());

            $job = Jobs::create([
                'user_id' => auth('api')->user()->id,
                'company_id' => $request->company_id,
                'job_name' => $request->job_name,
                'job_description' => $request->job_description,
                'poster' => $poster->hashName(),
                'job_type' => $request->job_type,
                'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),
            ]);

            return responseSuccess(true, 'Success', $job, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return  $this->responseError(false, $e->getMessage(), null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Jobs $job): JsonResponse
    {
        return responseSuccess(true, 'Success', $job, Response::HTTP_OK);
    }

    public function update(JobRequest $request, Jobs $job)
    {
        try {
            $request->validated();

            if ($request->poster) {
                Storage::disk('public')->delete('poster/' . basename($job->poster));

                $poster = $request->poster;
                $poster->storeAs('public/poster/', $poster->hashName());

                $job->update([
                    'user_id'           => auth('api')->user()->id,
                    'company_id'        => $request->company_id,
                    'job_name'          => $request->job_name,
                    'job_description'   => $request->job_description,
                    'poster'            => $poster->hashName(),
                    'job_type'          => $request->job_type,
                    'end_date'          => Carbon::parse($request->end_date)->format('Y-m-d'),
                ]);
            }

            $job->update([
                'user_id'           => auth('api')->user()->id,
                'company_id'        => $request->company_id,
                'job_name'          => $request->job_name,
                'job_description'   => $request->job_description,
                'job_type'          => $request->job_type,
                'end_date'          => Carbon::parse($request->end_date)->format('Y-m-d'),
            ]);

            return responseSuccess(true, 'Data Pekerjaan Berhasil Diperbarui', $job, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Jobs $job)
    {
        try {
            $job->delete();
            return responseSuccess(true, 'Data Pekerjaan Berhasil Dihapus', null, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function import(JobImportRequest $request): JsonResponse
    {
        $request->validated();
        (new JobImport)->import($request->file, null, Excel::XLSX);
        return responseSuccess(true, 'Data Pekerjaan Berhasil Diimport', null, Response::HTTP_OK);
    }

    public function export(): JsonResponse
    {
        return responseSuccess(true, 'Data Pekerjaan Berhasil Diexport', Jobs::all(), Response::HTTP_OK);
    }

    public function deleteAll()
    {
        try {
            Jobs::whereNotNull('id')->delete();
            return responseSuccess(true, 'Semua Data Pekerjaan telah dihapus!', null, Response::HTTP_NO_CONTENT);
        } catch (Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
