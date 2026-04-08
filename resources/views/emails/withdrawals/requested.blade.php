<x-mail::message>
    # Withdrawal Request: {{ $method }}

    @if ($isAdmin)
        **Admin Notification:** A new withdrawal request has been submitted.
    @else
        Hello {{ $withdrawal->user->name }}, we have received your request for withdrawal.
    @endif

    <x-mail::panel>
        **Asset:** {{ $method }}
        **Amount/Quantity:** {{ $displayAmount }}
        **Status:** Pending Review
    </x-mail::panel>

    @if ($method === 'BANK')
        **Bank:** {{ $withdrawal->bank_details['bank_name'] }}
        **Account:** {{ $withdrawal->bank_details['account_number'] }}
    @else
        **Delivery Address:** {{ $withdrawal->delivery_details['address'] }}
    @endif

    @if (!$isAdmin)
        Please allow 24-48 hours for our team to verify the transaction.
    @endif

    <x-mail::button :url="config('app.url')">
        Visit Site
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
