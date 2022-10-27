<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\ExcelImportRequest;
use App\Imports\CompanyImport;
use App\Models\Company;
use App\Models\Location;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class CompanyController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $companies = Company::when(
                request('q'),
                fn ($company) => $company->orWhere('name', 'like', '%' . request('q') . '%')
                    ->orWhere('established', 'like', '%' . request('q') . '%')
                    ->orWhereHas('location', fn ($company) => $company->where('country', 'like', '%' . request('q') . '%'))
            )->orderBy('id', 'DESC');


            return responseSuccess(true, 'Success', $companies, Response::HTTP_OK);
        } catch (Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CompanyStoreRequest $request): JsonResponse
    {
        try {
            $request->validated();

            //insert company data with location data
            $company = Company::create([
                'name' => $request->name,
                'description' => $request->description,
                'established' => date('Y-m-d', strtotime($request->established)),
                'website_url' => $request->website_url,
                'company_field' => $request->company_field,
            ]);

            $company->location()->create([
                'street_address' => $request->street_address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
            ]);

            return responseSuccess(true, 'Success', $company, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Company $company): JsonResponse
    {
        try {
            $company = Company::findOrFail($company->id);
            return responseSuccess(true, 'Company Data', $company, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable  $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(CompanyRequest $request, Company $company): JsonResponse
    {
        try {
            $request->validated();
            //update company data with location data
            $company->update([
                'name' => $request->name,
                'description' => $request->description,
                'established' => date('Y-m-d', strtotime($request->established)),
                'website_url' => $request->website_url,
                'company_field' => $request->company_field,
            ]);

            $company->location()->update([
                'street_address' => $request->street_address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
            ]);

            return responseSuccess(true, 'Success', $company, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Company $company): JsonResponse
    {
        try {
            $user = auth('api')->user();

            if ($user->status != 'ADMIN')
                return $this->responseError(false, 'You are not authorized to perform this action!', null, Response::HTTP_UNAUTHORIZED);

            //delete company data with location data
            $company->delete();
            $company->location->delete();
            return responseSuccess(true, 'Success', null, Response::HTTP_OK);

            return responseSuccess(true, 'Company deleted successfully!', 'content deleted!', Response::HTTP_OK);
        } catch (\Throwable $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (QueryException $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function import(ExcelImportRequest $request): JsonResponse
    {
        $request->validated();
        (new CompanyImport)->import($request->file, null, \Maatwebsite\Excel\Excel::XLSX);
        return responseSuccess(true, 'Company imported successfully!', null, Response::HTTP_OK);
    }

    public function exportExcel(): JsonResponse
    {
        return responseSuccess(true, 'Company exported successfully!', Company::all(), Response::HTTP_OK);
    }

    public function deleteAll(): JsonResponse
    {
        Company::whereNotNull('id')->delete();
        Location::whereNotNull('id')->delete();
        return responseSuccess(true, 'Semua data perusahaan terhapus', null, Response::HTTP_NO_CONTENT);
    }
}
