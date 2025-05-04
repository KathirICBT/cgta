<header class="flex items-center justify-between p-4 text-white bg-gray-800">
    <div>
        <h1 class="text-xl font-bold">Dashboard</h1>
    </div>
    <div>
        <span class="mr-4">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-500">Logout</button>
        </form>
    </div>
</header>
