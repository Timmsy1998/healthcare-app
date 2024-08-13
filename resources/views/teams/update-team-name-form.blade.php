<x-form-section submit="updateTeamName">
    <x-slot name="title">
        {{ __('Department Name') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The Department\'s name') }}
    </x-slot>

    <x-slot name="form">

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Department Name') }}" />

            <x-input id="name"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="state.name"
                        :disabled="! Gate::check('update', $team)" />

            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    @endif
</x-form-section>
