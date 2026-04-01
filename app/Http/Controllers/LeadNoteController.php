<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadNoteController extends Controller
{
    /**
     * Store a new note for a lead (Web — Inertia redirect).
     */
    public function store(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $lead->notes()->create([
            'user_id' => $request->user()?->id ?? 1,
            'note' => $validated['note'],
        ]);

        return redirect()->back();
    }

    /**
     * Store a new note for a lead (API — JSON response).
     */
    public function apiStore(Request $request, Lead $lead): JsonResponse
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $userId = Auth::id();

        $note = $lead->notes()->create([
            'user_id' => $userId ?? 1,
            'note' => $validated['note'],
        ]);

        $note->load('user:id,name,email');

        return response()->json([
            'message' => 'Note created successfully.',
            'data' => $note,
        ], 201);
    }
}
