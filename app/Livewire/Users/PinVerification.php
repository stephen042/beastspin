<?php

namespace App\Livewire\Users;


use App\Models\WithdrawalPins;
use App\Models\Withdrawals;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class PinVerification extends Component
{
    public $step = 1;
    public $tax_code, $cot_code, $token_code;

    /**
     * Verify each step based on the codes stored in the withdrawal_pins table
     */
    public function verifyStep()
    {
        // Fetch the pins assigned to the logged-in user
        $userPins = WithdrawalPins::where('user_id', Auth::id())->first();

        if (!$userPins) {
            $this->dispatch('error', message: 'Verification record not found. Please contact support.');
            return;
        }

        // STEP 1: Verify Tax Code
        if ($this->step === 1) {
            if (trim($this->tax_code) !== $userPins->tax_code) {
                $this->dispatch('error', message: 'Invalid Tax Code.');
                return;
            }
        }

        // STEP 2: Verify COT Code
        if ($this->step === 2) {
            if (trim($this->cot_code) !== $userPins->cot) {
                $this->dispatch('error', message: 'Invalid COT Code.');
                return;
            }
        }

        // Progress logic
        if ($this->step < 3) {
            $this->step++;
        } else {
            $this->completeFinalWithdrawal();
        }
    }

    /**
     * Final step: Verify Token and Save the Withdrawal to the database
     */
    public function completeFinalWithdrawal()
    {
        $userPins = WithdrawalPins::where('user_id', Auth::id())->first();

        // STEP 3: Verify Token Code
        if (trim($this->token_code) !== $userPins->token_code) {
            $this->dispatch('error', message: 'Invalid Final Security Token.');
            return;
        }

        // Retrieve the data we saved in the session from the first page
        $data = Session::get('pending_withdrawal');

        if (!$data) {
            return redirect()->route('withdraw')->with('error', 'Session expired. Please start over.');
        }

        try {
            // Create the record in your main 'withdrawals' table
            Withdrawals::create([
                'user_id'           => Auth::id(),
                'withdrawal_method' => $data['method'],
                'amount'            => $data['amount'] ?? 0,
                // Using json/array cast for details if your migration supports it
                'bank_details'      => $data['method'] === 'bank' ? [
                    'bank_name'      => $data['bank_name'],
                    'account_number' => $data['account_number']
                ] : null,
                'delivery_details'  => $data['method'] !== 'bank' ? [
                    'address'  => $data['address'],
                    'quantity' => $data['quantity'] ?? 1
                ] : null,
                'status'            => 'pending', // Add this line to store the withdrawal type
            ]);

            // Clear the session now that the data is safely in the database
            Session::forget('pending_withdrawal');

            $this->dispatch('success', message: 'Withdrawal completed successfully!');
            $this->step = 4; // Move to the "Approved!" success UI

        } catch (\Exception $e) {
            $this->dispatch('error', message: 'An error occurred while processing. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.users.pin-verification');
    }
}
