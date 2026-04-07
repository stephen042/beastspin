<?php

namespace App\Livewire\Users;

use App\Models\SpinAllocations;
use App\Models\SpinHistories;
use App\Models\SpinResults;
use App\Models\Wallets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SpinWheel extends Component
{
    public $canSpin = false;
    public $remainingSpins = 0;

    public $balance = 0;
    public $tesla_balance = 0;

    public function mount()
    {
        $this->checkSpinAvailability();
    }

    // ✅ FIXED: optimized wallet query (no duplicate query)
    public function refreshWheel()
    {
        $wallet = Wallets::where('user_id', Auth::id())->first();

        $this->balance = $wallet?->balance ?? 0;
        $this->tesla_balance = $wallet?->tesla_balance ?? 0;

        $this->redirectRoute('spin');
    }

    public function checkSpinAvailability()
    {
        $this->canSpin = SpinAllocations::where('user_id', Auth::id())
            ->where('is_active', true)
            ->whereColumn('used_spins', '<', 'total_spins')
            ->exists();

        if ($this->canSpin) {
            $allocation = SpinAllocations::where('user_id', Auth::id())
                ->where('is_active', true)
                ->first();

            $this->remainingSpins = $allocation->total_spins - $allocation->used_spins;
        } else {
            $this->remainingSpins = 0;
        }
    }

    public function spin()
    {
        if (!$this->canSpin) {
            $this->dispatch('error', message: 'No spins available');
            return;
        }

        DB::transaction(function () {

            $spin = SpinResults::where('user_id', Auth::id())
                ->where('is_used', false)
                ->first();

            if (!$spin) {
                $this->dispatch('error', message: 'No spin result found');
                return;
            }

            // ✅ mark spin as used
            $spin->update([
                'is_used' => true,
                'used_at' => now()
            ]);

            // ✅ update allocation usage
            SpinAllocations::where('user_id', Auth::id())
                ->where('is_active', true)
                ->increment('used_spins');

            // ✅ ensure wallet exists
            $wallet = Wallets::firstOrCreate(
                ['user_id' => Auth::id()],
                ['balance' => 0, 'tesla_balance' => 0]
            );

            // ✅ reward logic
            if ($spin->prize_label === 'TESLA CAR') {
                $wallet->increment('tesla_balance', 1);
            } elseif ($spin->amount > 0) {
                $wallet->increment('balance', $spin->amount);
            }

            // save history
            SpinHistories::create([
                'user_id' => Auth::id(),
                'spin_result_id' => $spin->id,
                'result_label' => $spin->prize_label,
                'result_value' => $spin->prize_value,
                'amount' => $spin->amount
            ]);

            // ✅ STRICT INDEX (NO FALLBACKS, NO GUESSING)
            if (!isset($spin->slice_index)) {
                throw new \Exception('Missing slice_index for spin result ID: ' . $spin->id);
            }

            $index = (int) $spin->slice_index;

            $maxIndex = 4; // MUST match frontend prizes count - 1

            if ($index < 0 || $index > $maxIndex) {
                throw new \Exception('Invalid slice_index for spin result ID: ' . $spin->id);
            }

            // ✅ dispatch browser event (NOW 100% SAFE)
            $this->dispatch(
                'spinResult',
                label: $spin->prize_label,
                value: $spin->prize_value,
                amount: $spin->amount,
                index: $index
            );

        });

        $this->checkSpinAvailability();
    }


    public function render()
    {
        return view('livewire.users.spin-wheel');
    }
}
