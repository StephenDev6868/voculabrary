<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getList($id, Request $request)
    {
        if (empty($id)) {

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'id không được để trống.',
            ]);
        }

        $perPage = $request->get('per_page', 20);

        $exams = Exam::with(
            ['category' => function($query) {
            return $query->select('id', 'name');
            }]
            )
            ->where('category_id', $id)->where('status', 1)
            ->select('id', 'title', 'description', 'category_id', 'suggest_number')
            ->orderBy('priority', 'ASC')->paginate($perPage);

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $exams
        ]);

    }
}
