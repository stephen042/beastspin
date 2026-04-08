<x-mail::message>
    # Welcome to the Inner Circle, {{ $user->name }}!

    We are thrilled to have you on board. At **{{ config('app.name') }}**, we believe in creating opportunities and
    rewarding our community. Your account is now fully active and ready for action.

    <x-mail::panel>
        **Quick Tip:** Check your dashboard daily to see if you have new Spin Allocations waiting for you!
    </x-mail::panel>

    ### What's Next?
    * **Complete your profile** to ensure smooth withdrawals.
    * **Explore the Spin Engine** and see what prizes are waiting.
    * **Join our community** for updates and exclusive offers.

    <x-mail::button :url="config('app.url') . '/dashboard'" color="success">
        Go to My Dashboard
    </x-mail::button>

    If you have any questions, simply reply to this email. Our support team is always here to help.

    Stay Lucky,<br>
    The {{ config('app.name') }} Team
</x-mail::message>
    