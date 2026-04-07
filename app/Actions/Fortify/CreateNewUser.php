<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Models\Wallets;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Rules\ValidWincode;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'wincode' => $this->wincodeRules(),
        ])->validate();

        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        return Wallets::create([
            'user_id' => User::latest()->first()->id,
            'balance' => 0.00,
            'tesla_balance' => 0.00,
        ]);
    }

    protected function wincodeRules(): array
    {
        return [
            'required',
            'string',
            'max:255',
            new ValidWincode,
        ];
    }
}
