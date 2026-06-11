<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6">
    <button @@click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="flex-1"></div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500">

            <span>
                {{ Auth::user()->name }}
            </span>

            <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-700 font-medium">
                {{ Auth::user()->role ?? 'Staff' }}
            </span>

            @if(Auth::user()->branch)
                <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                    {{ Auth::user()->branch->name }}
                </span>
            @endif

        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="hidden sm:inline">Keluar</span>
            </button>
        </form>
    </div>
</header>
