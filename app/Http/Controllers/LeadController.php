<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\LeadStoreRequest;
use App\Http\Requests\LeadUpdateRequest;

class LeadController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Lead::class);

        $search = $request->get('search', '');

        $leads = Lead::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.leads.index', compact('leads', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Lead::class);

        $categories = Category::pluck('name', 'id');

        return view('app.leads.create', compact('categories'));
    }

    /**
     * @param \App\Http\Requests\LeadStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadStoreRequest $request)
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validated();

        $lead = Lead::create($validated);

        return redirect()
            ->route('leads.edit', $lead)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Lead $lead)
    {
        $this->authorize('view', $lead);

        return view('app.leads.show', compact('lead'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $categories = Category::pluck('name', 'id');

        return view('app.leads.edit', compact('lead', 'categories'));
    }

    /**
     * @param \App\Http\Requests\LeadUpdateRequest $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function update(LeadUpdateRequest $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $validated = $request->validated();

        $lead->update($validated);

        return redirect()
            ->route('leads.edit', $lead)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Lead $lead)
    {
        $this->authorize('delete', $lead);

        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
