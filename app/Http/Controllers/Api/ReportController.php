<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function instructorCourseCount(): JsonResponse
    {
        $data = Course::query()
            ->select('users.id', 'users.name', 'users.email', DB::raw('COUNT(courses.id) as course_count'))
            ->join('users', 'users.id', '=', 'courses.instructor_id')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('course_count')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Course count per instructor loaded successfully.',
            'data' => $data,
        ]);
    }

    public function transactionDetail(): JsonResponse
    {
        $data = Transaction::query()
            ->select([
                'transactions.id',
                'transactions.invoice_number',
                'transactions.quantity',
                'transactions.total_price',
                'transactions.status as transaction_status',
                'users.name as user_name',
                'users.email as user_email',
                'courses.title as product_title',
                'categories.name as category_name',
            ])
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->join('courses', 'courses.id', '=', 'transactions.course_id')
            ->join('categories', 'categories.id', '=', 'courses.category_id')
            ->latest('transactions.created_at')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction detail loaded successfully.',
            'data' => $data,
        ]);
    }
}
