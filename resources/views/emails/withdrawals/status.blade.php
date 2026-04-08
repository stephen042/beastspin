<x-mail::message>
    # Withdrawal Approved! 🎊

    Hello {{ $withdrawal->user->name }},

    Great news! Your withdrawal request has been reviewed and **approved** by our finance team.

    <x-mail::panel>
        **Transaction Summary** **Method:** {{ strtoupper($withdrawal->withdrawal_method) }}
        **Total Released:** {{ $displayAmount }}
        **Status:** Completed
    </x-mail::panel>

    @if ($withdrawal->withdrawal_method === 'bank')
        The funds have been dispatched to your registered bank account:
        **Bank:** {{ $withdrawal->bank_details['bank_name'] }}
        **Account:** {{ $withdrawal->bank_details['account_number'] }}
    @elseif($withdrawal->withdrawal_method === 'car')
        Our logistics team is currently preparing your vehicle for delivery. You will receive a follow-up call at your
        registered phone number to coordinate the delivery to:
        **Address:** {{ $withdrawal->delivery_details['address'] }}
    @else
        Your cash payout is ready for pickup/delivery at your specified location.
    @endif

    <x-mail::button :url="config('app.url') . '/dashboard'" color="success">
        View Transaction History
    </x-mail::button>

    If you do not see the assets reflected in your account within the next few hours (for bank transfers), please
    contact our support team.

    Congratulations,<br>
    The {{ config('app.name') }} Team
</x-mail::message>
