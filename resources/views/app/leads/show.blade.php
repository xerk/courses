<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.leads.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('leads.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.name')
                        </h5>
                        <span>{{ $lead->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.name_ar')
                        </h5>
                        <span>{{ $lead->name_ar ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.email')
                        </h5>
                        <span>{{ $lead->email ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.phone')
                        </h5>
                        <span>{{ $lead->phone ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.category_approved')
                        </h5>
                        <span>{{ $lead->category_approved ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.course_type')
                        </h5>
                        <span>{{ $lead->course_type ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.category_id')
                        </h5>
                        <span
                            >{{ optional($lead->category)->name ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.lead_from')
                        </h5>
                        <span>{{ $lead->lead_from ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.status')
                        </h5>
                        <span>{{ $lead->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.business_landline')
                        </h5>
                        <span>{{ $lead->business_landline ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.leads.inputs.note')
                        </h5>
                        <span>{{ $lead->note ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('leads.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Lead::class)
                    <a href="{{ route('leads.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\FollowUp::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Follow Ups </x-slot>

                <livewire:lead-follow-ups-detail :lead="$lead" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
