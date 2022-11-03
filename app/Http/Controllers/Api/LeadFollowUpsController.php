<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowUpResource;
use App\Http\Resources\FollowUpCollection;

class LeadFollowUpsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Lead $lead)
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $followUps = $lead
            ->followUps()
            ->search($search)
            ->latest()
            ->paginate();

        return new FollowUpCollection($followUps);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lead $lead)
    {
        $this->authorize('create', FollowUp::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'Note' => ['nullable', 'max:255', 'string'],
            'status' => ['nullable', 'max:255', 'string'],
        ]);

        $followUp = $lead->followUps()->create($validated);

        return new FollowUpResource($followUp);
    }
}
