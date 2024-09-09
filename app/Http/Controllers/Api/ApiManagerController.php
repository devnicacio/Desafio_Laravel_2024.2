<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class ApiManagerController extends Controller
{
    /**
     * @OA\Info(
     *   title="SafebankManagerApi",
     *   version="1.0",
     * )
     */
    public function index()
    {
        $managers = Manager::select('name', 'photo')->get();
        $managersCount = $managers->count();
        $totalPages = ceil($managersCount/6);

        if($managers->isEmpty()){
            return response()->json([
                'managers' => "Não foi encontrado nenhum registro",
                'totalPages' => 0,
                'status' => 204
            ]);
        }

        return response()->json([
            'managers' => $managers,
            'totalPages' => $totalPages,
            'status' => 200
        ]);
    }
}
