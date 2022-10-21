<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $user = User::select('id', 'nim', 'nama_lengkap', 'created_at')->where('status', 'ALUMNI')->paginate(10);
            return responseSuccess(true, 'Semua Data Alumni', $user, Response::HTTP_OK);
        } catch (QueryException $e) {
            return responseError(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
