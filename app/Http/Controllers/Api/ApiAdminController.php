<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ApiAdminController extends Controller
{
    /**
     * @OA\Info(
     *   title="SafebankManagerApi",
     *   version="1.0",
     * )
     */
    public function index()
    {
        $admins = Admin::select('name', 'photo')->get();
        $adminsCount = $admins->count();
        $totalPages = ceil($adminsCount/6);

        if($admins->isEmpty()){
            return response()->json([
                'admins' => "Não foi encontrado nenhum registro",
                'totalPages' => 0,
                'status' => 204
            ]);
        }

        return response()->json([
            'admins' => $admins,
            'totalPages' => $totalPages,
            'status' => 200
        ]);
    }
}
