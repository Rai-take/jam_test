<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArrivalSchedule;

class ArrivalScheduleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'arrival_status_id' => 'required',
            // 必要なバリデーションを設定
        ]);

        $arrivalSchedule = ArrivalSchedule::create([
            'arrival_status_id' => $request->input('arrival_status_id'),
            'order_number' => $request->input('order_number'),
            'arrival_schedule_date' => $request->input('arrival_schedule_date'),
            'arrival_actual_date' => $request->input('arrival_actual_date'),
            'comment' => $request->input('comment'),
            'canceled_at' => $request->input('canceled_at'),
            'canceled_by' => $request->input('canceled_by'),
            'created_by' => $request->input('created_by'),
            'updated_by' => $request->input('updated_by'),
            'is_active' => $request->input('is_active'),
            'is_active_comment' => $request->input('is_active_comment'),
        ]);

        return response()->json(['message' => 'Data inserted successfully', 'data' => $arrivalSchedule], 201);
    }
}
