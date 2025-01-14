<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'Nombre' => ['required', 'string', 'max:255'],
            'Apellido' => ['required', 'string', 'max:255'],
            'Tipousuario' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'DNI' => ['required', 'string', 'string', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'Nombre' => $input['Nombre'],
            'Apellido' => $input['Apellido'],
            'Tipousuario' => $input['Tipousuario'],
            'DNI' => $input['DNI'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
