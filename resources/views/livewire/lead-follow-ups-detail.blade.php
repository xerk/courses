<div>
    <div>
        @can('create', App\Models\FollowUp::class)
        <button class="button" wire:click="newFollowUp">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\FollowUp::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="followUp.title"
                            label="Title"
                            wire:model="followUp.title"
                            maxlength="255"
                            placeholder="Title"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="followUp.Note"
                            label="Note"
                            wire:model="followUp.Note"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="followUp.status"
                            label="Status"
                            wire:model="followUp.status"
                            maxlength="255"
                            placeholder="Status"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="followUp.company_lead_id"
                            label="Company Lead"
                            wire:model="followUp.company_lead_id"
                        >
                            <option value="null" disabled>Please select the Company Lead</option>
                            @foreach($companyLeadsForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="followUp.follow_up_from"
                            label="Follow Up From"
                            wire:model="followUp.follow_up_from"
                        >
                            <option value="visit" {{ $selected == 'visit' ? 'selected' : '' }} >Visit</option>
                            <option value="email" {{ $selected == 'email' ? 'selected' : '' }} >Email</option>
                            <option value="call" {{ $selected == 'call' ? 'selected' : '' }} >Call</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="followUp.follow_date"
                            label="Follow Date"
                            wire:model="followUp.follow_date"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="followUpNextFollowDate"
                            label="Next Follow Date"
                            wire:model="followUpNextFollowDate"
                            max="255"
                        ></x-inputs.date>
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.lead_follow_ups.inputs.title')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.lead_follow_ups.inputs.Note')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.lead_follow_ups.inputs.status')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.lead_follow_ups.inputs.company_lead_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.lead_follow_ups.inputs.follow_up_from')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.lead_follow_ups.inputs.follow_date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.lead_follow_ups.inputs.next_follow_date')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($followUps as $followUp)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $followUp->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $followUp->title ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $followUp->Note ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $followUp->status ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($followUp->companyLead)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $followUp->follow_up_from ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $followUp->follow_date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $followUp->next_follow_date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $followUp)
                            <button
                                type="button"
                                class="button"
                                wire:click="editFollowUp({{ $followUp->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <div class="mt-10 px-4">{{ $followUps->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
