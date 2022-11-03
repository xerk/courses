<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\LeadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class CategoryLeadsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $leads = $category
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'name_ar' => ['nullable', 'max:255', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'max:255', 'string'],
            'category_approved' => ['nullable', 'max:255', 'string'],
            'course_type' => ['nullable', 'in:medical,technical'],
            'lead_from' => ['nullable', 'in:website,calls,whatsapp,by_visit'],
            'status' => ['nullable', 'max:255', 'string'],
            'business_landline' => ['nullable', 'max:255', 'string'],
            'note' => ['nullable', 'max:255', 'string'],
        ]);

        $lead = $category->leads()->create($validated);

        return new LeadResource($lead);
    }
}
