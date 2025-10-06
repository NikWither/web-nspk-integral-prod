<?php

namespace App\Http\Controllers;

use App\Models\Hypothesis;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $hypotheses = $user?->hypotheses()
            ->orderByRaw("CASE WHEN status = ? THEN 0 WHEN status = ? THEN 1 ELSE 2 END", [
                Hypothesis::STATUS_RESOLVED,
                Hypothesis::STATUS_IN_PROGRESS,
            ])
            ->orderByDesc('created_at')
            ->get() ?? collect();

        return view('profile.index', [
            'user' => $user,
            'hypotheses' => $hypotheses,
        ]);
    }
}
