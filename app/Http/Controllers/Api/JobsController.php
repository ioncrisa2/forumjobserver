<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobImportRequest;
use App\Http\Requests\JobRequest;
use App\Imports\JobImport;
use App\Models\Jobs;
use App\Services\JobService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Excel;
use Throwable;

class JobsController extends Controller
{
    private JobService $jobService;

    public function __construct()
    {
        $this->jobService = new JobService();
    }

    public function index()
    {
        try {
            $searchByQuery = request('q');
            $jobs = $this->jobService->showAll($searchByQuery);

            return responseSuccess(true, 'Success', $jobs, Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->responseError(false, $e->getMessage(), null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(JobRequest $request)
    {
        try {
            $request->validated();

            $job = $this->jobService->storeData($request->all());

            return responseSuccess(true, 'Success', $job, Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return  responseError(false, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Jobs $job): JsonResponse
    {
        return responseSuccess(true, 'Success', $job, Response::HTTP_OK);
    }

    public function update(JobRequest $request, int $id): JsonResponse
    {
        try {
            $request->validated();

            $updatejob = $this->jobService->updateData($id, $request->all());

            return responseSuccess(true, 'Data Pekerjaan Berhasil Diperbarui', $updatejob, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobService->deleteData($id);
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
}
