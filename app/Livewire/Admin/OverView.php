<?php

namespace App\Livewire\Admin;

use App\Models\SpinAllocations;
use App\Models\User;
use App\Models\Wallets;
use App\Models\Withdrawals;
use Livewire\Component;
use Livewire\WithPagination;

class OverView extends Component
{
    use WithPagination;

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.over-view', [
            'totalUsers' => User::where('role', 'user')->count(),
            'totalBalance' => Wallets::sum('balance'),
            'totalTeslaBalance' => Wallets::sum('tesla_balance'), // Assuming "Fleet" value is here
            'totalWithdrawalsCash' => Withdrawals::where('withdrawal_method', 'cash')->where('withdrawal_method', 'bank')->where('status', 'completed')->sum('amount'),
            'totalWithdrawalsCar' => Withdrawals::where('withdrawal_method', 'car')->where('status', 'completed')->sum('amount'),
            'users' => User::where('role','user')->with('wallet')->latest()->paginate(10),
        ]);
    }
}
