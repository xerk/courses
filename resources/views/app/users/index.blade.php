<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.users.index_title')
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
                            @can('create', App\Models\User::class)
                            <a
                                href="{{ route('users.create') }}"
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
                                    @lang('crud.users.inputs.name')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.name_ar')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.avatar')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.email')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.private_email')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.phone')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.phone2')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.address')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.inside_address')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.type')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.category_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.city')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.country')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.users.inputs.company_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $user->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->name_ar ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $user->avatar ? \Storage::url($user->avatar) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->email ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->private_email ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->phone ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->phone2 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->address ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->inside_address ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->type ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($user->category)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->city ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $user->country ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($user->company)->name ?? '-' }}
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
                                        @can('update', $user)
                                        <a
                                            href="{{ route('users.edit', $user) }}"
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
                                        @endcan @can('view', $user)
                                        <a
                                            href="{{ route('users.show', $user) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $user)
                                        <form
                                            action="{{ route('users.destroy', $user) }}"
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
                                <td colspan="15">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="15">
                                    <div class="mt-10 px-4">
                                        {!! $users->render() !!}
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
