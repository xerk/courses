<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrainerResource;
use App\Http\Resources\TrainerCollection;

class CompanyTrainersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $trainers = $company
            ->trainers()
            ->search($search)
            ->latest()
            ->paginate();

        return new TrainerCollection($trainers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', Trainer::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'company' => ['nullable', 'max:255'],
            'occupation' => ['nullable', 'max:255', 'string'],
            'work_place' => ['nullable', 'max:255', 'string'],
            'sufer_diseases' => ['nullable', 'max:255'],
            'diseases_note' => ['nullable', 'max:255', 'string'],
            'job_title' => ['nullable', 'max:255', 'string'],
            'note' => ['nullable', 'max:255', 'string'],
        ]);

        $trainer = $company->trainers()->create($validated);

        return new TrainerResource($trainer);
    }
}
