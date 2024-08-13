<?php

namespace App\Actions\Jetstream;

use App\Models\Patient;
use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class AddTeamMember implements AddsTeamMembers
{
    /**
     * Add a new team member to the given team.
     */
    public function add(User $user, Team $team, string $nhsNumber, ?string $role = null): void
    {
        Gate::forUser($user)->authorize('addTeamMember', $team);

        $this->validate($team, $nhsNumber, $role);

        $patient = Patient::where('nhs_number', $nhsNumber)->firstOrFail();

        $newTeamMember = $patient->user;

        AddingTeamMember::dispatch($team, $newTeamMember);

        $team->users()->attach(
            $newTeamMember, ['role' => $role]
        );

        TeamMemberAdded::dispatch($team, $newTeamMember);
    }

    /**
     * Validate the add member operation.
     */
    protected function validate(Team $team, string $nhsNumber, ?string $role): void
    {
        Validator::make([
            'nhs_number' => $nhsNumber,
            'role' => $role,
        ], $this->rules(), [
            'nhs_number.exists' => __('We were unable to find a patient with this NHS Number.'),
        ])->after(
            $this->ensurePatientIsNotAlreadyOnTeam($team, $nhsNumber)
        )->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for adding a team member.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function rules(): array
    {
        return array_filter([
            'nhs_number' => ['required', 'exists:patients,nhs_number'],
            'role' => Jetstream::hasRoles()
            ? ['required', 'string', new Role]
            : null,
        ]);
    }

    /**
     * Ensure that the patient is not already on the team.
     */
    protected function ensurePatientIsNotAlreadyOnTeam(Team $team, string $nhsNumber): Closure
    {
        return function ($validator) use ($team, $nhsNumber) {
            $patient = Patient::where('nhs_number', $nhsNumber)->first();

            if ($patient && $team->hasUser($patient->user)) {
                $validator->errors()->add(
                    'nhs_number',
                    __('This patient already belongs to the team.')
                );
            }
        };
    }
}
