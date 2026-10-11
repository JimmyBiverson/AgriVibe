<x-mail::message>
# Welcome to {{ config('agrivibe.app_name', 'Agrivibe') }}, {{ $user->name }}!

Thank you for joining the connected farming community. Your account is ready.

**What you can do now:**
- Verify your email address to keep your account secure
- Complete your profile and register your farm
- Explore the Knowledge Centre for practical farming guides
- Find vets, suppliers, buyers and training near you

We're excited to grow with you.

<x-mail::button :url="url('/dashboard')">
Go to my dashboard
</x-mail::button>

Thanks,<br>
The {{ config('agrivibe.app_name', 'Agrivibe') }} Team
</x-mail::message>