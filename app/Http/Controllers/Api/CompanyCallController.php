<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CompanyCallController extends Controller
{
    public function __invoke()
    {
        try {
            $company = DB::select("select id,name from companies");
            return responseSuccess(true, 'All Company Data', $company, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return responseError(false, $e->getMessage(), '', Response::HTTP_BAD_REQUEST);
        }
    }
}
