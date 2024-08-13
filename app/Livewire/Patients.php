<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\User;
use Livewire\Component;

class Patients extends Component
{
    // Declare the Form Fields For Creating A Patient
    public $first_name, $last_name, $email, $phone_number, $nhs_number, $address, $date_of_birth, $sex, $user_id;

    // Initalise Patients and Users
    public $patients, $users;

    // Define the pages for Pagination
    public $page = 1, $perPage = 10;

    // Set up pateint Editing
    public $patientBeingEdited = null;
    public function mount()
    {
        $this->users = User::all();
        $this->loadPatients();
    }

    public function loadPatients()
    {
        $this->patients = Patient::orderBy('last_name')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.patients.show');
    }

    public function nextPage()
    {
        $this->page++;
        $this->loadPatients();
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page--;
            $this->loadPatients();
        }
    }

    public function store()
    {
        $validatedData = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'nhs_number' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:male,female',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Patient::create($validatedData);

        // Reset the form inputs
        $this->reset(['first_name', 'last_name', 'email', 'phone_number', 'nhs_number', 'address', 'date_of_birth', 'sex', 'user_id']);

        // Reload the patients data
        $this->loadPatients();
    }

    public function edit($patientId)
    {
        $this->patientBeingEdited = $patientId;

        // Load the patient data into the form inputs
        $patient = Patient::find($patientId);
        $this->first_name = $patient->first_name;
        $this->last_name = $patient->last_name;
        $this->email = $patient->email;
        $this->phone_number = $patient->phone_number;
        $this->nhs_number = $patient->nhs_number;
        $this->address = $patient->address;
        $this->date_of_birth = $patient->date_of_birth;
        $this->sex = $patient->sex;
        $this->user_id = $patient->user_id;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'nhs_number' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:male,female',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($this->patientBeingEdited) {
            $patient = Patient::find($this->patientBeingEdited);
            $patient->update($validatedData);

            $this->patientBeingEdited = null;
        }

        // Reset the form inputs
        $this->reset(['first_name', 'last_name', 'email', 'phone_number', 'nhs_number', 'address', 'date_of_birth', 'sex', 'user_id']);

        // Reload the patients data
        $this->loadPatients();
    }

    public function delete($patientId)
    {
        Patient::where('id', $patientId)->delete();

        // Reload the patients data
        $this->loadPatients();
    }

}
