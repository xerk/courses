<?php

namespace App\Http\Livewire;

use App\Models\Lead;
use Livewire\Component;
use App\Models\FollowUp;
use App\Models\CompanyLead;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeadFollowUpsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Lead $lead;
    public FollowUp $followUp;
    public $companyLeadsForSelect = [];
    public $followUpNextFollowDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New FollowUp';

    protected $rules = [
        'followUp.title' => ['required', 'max:255', 'string'],
        'followUp.Note' => ['nullable', 'max:255', 'string'],
        'followUp.status' => ['nullable', 'max:255', 'string'],
        'followUp.company_lead_id' => ['nullable', 'exists:company_leads,id'],
        'followUp.follow_up_from' => ['nullable', 'in:visit,email,call'],
        'followUp.follow_date' => ['nullable', 'date'],
        'followUpNextFollowDate' => ['nullable', 'date'],
    ];

    public function mount(Lead $lead)
    {
        $this->lead = $lead;
        $this->companyLeadsForSelect = CompanyLead::pluck('name', 'id');
        $this->resetFollowUpData();
    }

    public function resetFollowUpData()
    {
        $this->followUp = new FollowUp();

        $this->followUpNextFollowDate = null;
        $this->followUp->company_lead_id = null;
        $this->followUp->follow_up_from = 'visit';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFollowUp()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.lead_follow_ups.new_title');
        $this->resetFollowUpData();

        $this->showModal();
    }

    public function editFollowUp(FollowUp $followUp)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.lead_follow_ups.edit_title');
        $this->followUp = $followUp;

        $this->followUpNextFollowDate = $this->followUp->next_follow_date->format(
            'Y-m-d'
        );

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->followUp->lead_id) {
            $this->authorize('create', FollowUp::class);

            $this->followUp->lead_id = $this->lead->id;
        } else {
            $this->authorize('update', $this->followUp);
        }

        $this->followUp->next_follow_date = \Carbon\Carbon::parse(
            $this->followUpNextFollowDate
        );

        $this->followUp->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', FollowUp::class);

        FollowUp::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetFollowUpData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->lead->followUps as $followUp) {
            array_push($this->selected, $followUp->id);
        }
    }

    public function render()
    {
        return view('livewire.lead-follow-ups-detail', [
            'followUps' => $this->lead->followUps()->paginate(20),
        ]);
    }
}
