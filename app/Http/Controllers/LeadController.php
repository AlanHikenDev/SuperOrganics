<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Inertia\Inertia;
use Inertia\Response;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index(): Response
    {
        $leads = Lead::withCount('notes')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return Inertia::render('Leads/Index', [
            'leads' => $leads,
        ]);
    }

    /**
     * Display the specified lead with its notes.
     */
    public function show(Lead $lead): Response
    {
        $lead->load(['notes' => function ($query) {
            $query->with('user:id,name,email')
                ->orderBy('created_at', 'desc');
        }]);

        $lead->loadCount('notes');

        return Inertia::render('Leads/Show', [
            'lead' => $lead,
        ]);
    }
}
