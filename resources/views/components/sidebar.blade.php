<aside class="w-64 h-screen p-4 text-white bg-gray-900">
    <h2 class="mb-4 text-xl font-bold">Navigation</h2>
    <ul>
        @if(auth()->user()->isAdmin())
            <li><a href="{{ route('admin.dashboard') }}" class="block py-2">Admin Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="block py-2">Manage Users</a></li>
        @endif
        @if(auth()->user()->isManager())
            <li><a href="{{ route('manager.dashboard') }}" class="block py-2">Manager Dashboard</a></li>
        @endif
        @if(auth()->user()->isStaff())
            <li><a href="{{ route('staff.dashboard') }}" class="block py-2">Staff Dashboard</a></li>
        @endif
    </ul>
</aside>
