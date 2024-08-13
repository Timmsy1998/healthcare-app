<x-form-section submit="createTeam">
    <x-slot name="title">
        {{ __('Department Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('What Department Is This?') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Department Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('Create') }}
        </x-button>
    </x-slot>
</x-form-section>
