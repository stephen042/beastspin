<div class="dashboard-wrapper">
    {{-- Section 1: Stats --}}
    <div class="section-container">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold tracking-tight text-zinc-800 dark:text-white">Financial Overview</h2>
            <span class="text-xs text-zinc-400 font-medium">Real-time updates</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="stat-card-inner">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
            </div>

            <div class="stat-card-inner">
                <div class="stat-label">Total Users Balance</div>
                <div class="stat-value">${{ number_format($totalBalance, 0) }}</div>
            </div>

            <div class="stat-card-inner">
                <div class="stat-label">Total Users Fleet</div>
                <div class="stat-value text-indigo-600">{{ number_format($totalTeslaBalance, 0) }}</div>
            </div>

            <div class="stat-card-inner flex flex-col justify-between">
                <div>
                    <div class="stat-label">Total Withdrawals</div>
                    <div class="stat-value">${{ number_format($totalWithdrawalsCash, 2) }}</div>
                </div>
                <div class="mt-4 pt-3 border-t border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                    <span class="text-[0.65rem] font-black uppercase text-green-600">Cars (Fleets)</span>
                    <span class="font-bold text-sm text-green-600 dark:text-green-400">{{ number_format($totalWithdrawalsCar, 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 2: User Table --}}
    <div class="section-container !p-0 overflow-hidden">
        <div class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold tracking-tight text-zinc-800 dark:text-white">User Management</h2>
                <p class="text-xs text-zinc-500 mt-1">Manage and audit system participants</p>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="pl-6">Full Name</th>
                        <th>Email</th>
                        <th>Spin Status</th>
                        <th>Balance</th>
                        <th class="pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            // Determine spin status based on your logic
                            $spinStatus = 'Inactive'; // Default status
                            if ($user->spinallocations()->where('is_active', true)->exists()) {
                                $spinStatus = 'Active';
                            }
                        @endphp
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="pl-6">
                                <div class="font-bold text-zinc-800 dark:text-white">{{ $user->name }}</div>
                            </td>
                            <td class="text-zinc-500">{{ $user->email }}</td>
                            <td>
                                <span style="background: {{ $spinStatus === 'Active' ? 'green' : 'red' }}; color: white; padding: 6px 8px; border-radius: 10px;font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 700;">
                                    {{ $spinStatus }}
                                </span>
                            </td>
                            <td class="font-mono font-bold">
                                ${{ number_format($user->wallet->balance ?? 0, 2) }}
                            </td>
                            <td class="pr-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.edit-user', $user) }}" class="btn-manage"
                                        style="padding: 4px 10px; font-size: 10px; border: 1px solid; border-radius: 4px; text-decoration: none;">MANAGE</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-zinc-100 dark:border-zinc-800">
            {{ $users->links() }}
        </div>
    </div>
</div>
