<nav class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Course Management</h1>

    <div>
        @auth
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="ml-3 bg-red-500 px-3 py-1 rounded">Logout</button>
            </form>
        @endauth
    </div>
</nav>
