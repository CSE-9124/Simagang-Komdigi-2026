<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InstitutionApiService;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Search universities via API
     */
    public function searchUniversities(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 50);
        
        try {
            $universities = InstitutionApiService::searchUniversities($search, $limit);
            return response()->json([
                'success' => true,
                'data' => $universities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari API',
                'data' => \App\Helpers\InstitutionHelper::getUniversities(false)
            ], 500);
        }
    }
    
    /**
     * Get all universities
     */
    public function getAllUniversities(Request $request)
    {
        try {
            $universities = InstitutionApiService::getAllUniversities();
            return response()->json([
                'success' => true,
                'data' => $universities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari API',
                'data' => \App\Helpers\InstitutionHelper::getUniversities(false)
            ], 500);
        }
    }
}

