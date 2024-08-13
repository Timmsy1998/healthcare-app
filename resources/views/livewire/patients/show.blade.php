<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Patient Management') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-1/4">Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>NHS Number</th>
                        <th>Address</th>
                        <th>Date of Birth</th>
                        <th>Sex</th>
                        <th>Registered</th>
                        <th></th> <!-- Additional column -->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td>
                            <div class="flex space-x-2">
                                <input type="text" wire:model="first_name" class="form-input w-1/2 border-none"
                                    placeholder="First Name">
                                <input type="text" wire:model="last_name" class="form-input w-1/2 border-none"
                                    placeholder="Last Name">
                            </div>
                        </td>
                        <td><input type="email" wire:model="email" class="form-input w-full border-none"
                                placeholder="Email"></td>
                        <td><input type="text" wire:model="phone_number" class="form-input w-full border-none"
                                placeholder="Phone Number"></td>
                        <td><input type="text" wire:model="nhs_number" class="form-input w-full border-none"
                                placeholder="NHS Number"></td>
                        <td><input type="text" wire:model="address" class="form-input w-full border-none"
                                placeholder="Address"></td>
                        <td><input type="date" wire:model="date_of_birth" class="form-input w-full border-none"></td>
                        <td>
                            <select wire:model="sex" class="form-select w-full border-none">
                                <option value="">Select Sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </td>
                        <td>
                            <select wire:model="user_id" class="form-select w-full">
                                <option value="">No User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button wire:click="store()"
                                class="bg-green-500 text-white px-4 py-2 border rounded-md hover:bg-green-700">✓</button>
                        </td>
                    </tr>
                    @if ($patients)
                        @foreach ($patients as $patient)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : '' }}">
                                <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <div class="flex space-x-2">
                                            <input type="text" wire:model="first_name"
                                                class="form-input w-1/2 border-none">
                                            <input type="text" wire:model="last_name"
                                                class="form-input w-1/2 border-none">
                                        </div>
                                    @else
                                        {{ $patient['first_name'] }} {{ $patient['last_name'] }}
                                    @endif
                                </td>
                                <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <input type="email" wire:model="email" class="form-input w-full border-none"
                                            placeholder="Email">
                                    @else
                                        {{ $patient['email'] }}
                                    @endif
                                </td>
                                <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <input type="text" wire:model="phone_number"
                                            class="form-input w-full border-none" placeholder="Phone Number">
                                    @else
                                        {{ $patient['phone_number'] }}
                                    @endif
                                </td>
                                <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <input type="text" wire:model="nhs_number"
                                            class="form-input w-full border-none" placeholder="NHS Number">
                                    @else
                                        {{ $patient['nhs_number'] }}
                                    @endif
                                </td>
                                <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <input type="text" wire:model="address" class="form-input w-full border-none"
                                            placeholder="Address">
                                    @else
                                        {{ $patient['address'] }}
                                    @endif
                                </td>
                                <td @if ($patientBeingEdited == $patient['id']) <input type="date" wire:model="date_of_birth"
                                        class="form-input w-full border-none"></td>
                                        @else
                                        {{ $patient['date_of_birth'] }} @endif
                                    <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <select wire:model="sex" class="form-select w-full border-none">
                                            <option value="">Select Sex</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    @else
                                        {{ $patient['sex'] }}
                                    @endif
                                </td>
                                <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <select wire:model="user_id" class="form-select w-full">
                                            <option value="">No User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        {{ $patient['user_id'] }}
                                    @endif
                                </td>
                                <td>
                                    @if ($patientBeingEdited == $patient['id'])
                                        <button wire:click="update({{ $patient['id'] }})"
                                            class="bg-blue-500 text-white px-4 py-2 border rounded-md hover:bg-blue-700">Save</button>
                                    @else
                                        <button wire:click="edit({{ $patient['id'] }})"
                                            class="bg-blue-500 text-white px-4 py-2 border rounded-md hover:bg-blue-700">Edit</button>
                                    @endif
                                    <button wire:click="delete({{ $patient['id'] }})"
                                        class="bg-red-500 text-white px-4 py-2 border rounded-md hover:bg-red-700">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
