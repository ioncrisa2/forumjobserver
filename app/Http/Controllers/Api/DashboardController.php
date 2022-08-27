<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = [
            'forum' => DB::table('forums')->count(),
            'job' => DB::table('jobs')->count(),
            'company' => DB::table('companies')->count(),
            'user' => DB::table('users')->count(),
        ];

        return responseSuccess(true, 'Dashboard Data', $data, Response::HTTP_OK);
    }
}
