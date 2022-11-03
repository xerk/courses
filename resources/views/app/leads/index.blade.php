<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.leads.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Lead::class)
                            <a
                                href="{{ route('leads.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.name')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.name_ar')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.email')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.phone')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.category_approved')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.course_type')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.category_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.lead_from')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.status')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.business_landline')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.leads.inputs.note')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($leads as $lead)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->name_ar ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->email ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->phone ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->category_approved ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->course_type ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($lead->category)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->lead_from ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->status ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->business_landline ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $lead->note ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $lead)
                                        <a
                                            href="{{ route('leads.edit', $lead) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $lead)
                                        <a
                                            href="{{ route('leads.show', $lead) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $lead)
                                        <form
                                            action="{{ route('leads.destroy', $lead) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="mt-10 px-4">
                                        {!! $leads->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
