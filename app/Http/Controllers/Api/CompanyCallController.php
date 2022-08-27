<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\JsonResponseFormat;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CompanyCallController extends Controller
{
    use JsonResponseFormat;
    public function __invoke()
    {
        try{
            $company = DB::select("select id,name from companies");
            return $this->responseSuccess(true, 'All Company Data', $company, Response::HTTP_OK);
        }catch(\Throwable $e){
            return $this->responseError(false, $e->getMessage(), null, Response::HTTP_BAD_REQUEST);
        }
    }
}
