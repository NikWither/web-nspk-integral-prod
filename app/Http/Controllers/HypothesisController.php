<?php

namespace App\Http\Controllers;

use App\Models\Hypothesis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HypothesisController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        $validated = $request->validate([
            'user_location' => ['nullable', 'string', 'max:191'],
            'date_range' => ['nullable', 'string', 'max:191'],
            'hypothesis' => ['required', 'string', 'max:2000'],
            'mcc_code' => ['required', 'string', 'max:16'],
            'status' => ['nullable', 'string', 'in:' . Hypothesis::STATUS_IN_PROGRESS . ',' . Hypothesis::STATUS_RESOLVED],
        ]);

        $hypothesis = $user->hypotheses()->create([
            'user_location' => $validated['user_location'] ?? null,
            'date_range' => $validated['date_range'] ?? null,
            'hypothesis' => $validated['hypothesis'],
            'mcc_code' => $validated['mcc_code'],
            'status' => $validated['status'] ?? Hypothesis::STATUS_IN_PROGRESS,
        ]);

        return response()->json([
            'message' => '����⥧� ��࠭���.',
            'data' => [
                'id' => $hypothesis->id,
                'status' => $hypothesis->status,
            ],
        ], 201);
    }
}
