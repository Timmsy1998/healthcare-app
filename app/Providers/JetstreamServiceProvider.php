<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Admin', [
            'create',
            'read',
            'update',
            'delete',
            'manage',
            'manage-users',
            'manage-departments',
            'manage-appointments',
        ])->description('Admin users can perform any action.');

        Jetstream::role('doctor', 'Doctor', [
            'read',
            'update-patients',
            'manage-appointments',
        ])->description('Doctor users can read and update patient information, and manage appointments.');

        Jetstream::role('nurse', 'Nurse', [
            'read',
            'update-patients',
        ])->description('Nurse users can read and update patient information.');

        Jetstream::role('receptionist', 'Receptionist', [
            'read-patients',
            'manage-appointments',
        ])->description('Receptionist users can read patient information and manage appointments.');

        Jetstream::role('patient', 'Patient', [
            'read-self',
        ])->description('Patient users can read their own information.');
    }
}
