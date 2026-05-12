<aside class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-800 text-white transform transition-transform duration-200 ease-in-out lg:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="flex items-center gap-3 h-16 px-6 border-b border-slate-700">
        <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center font-bold text-sm">M</div>
        <span class="font-bold text-lg">Minimarket</span>
    </div>

    <nav class="px-3 py-4 space-y-1 overflow-y-auto" style="height: calc(100vh - 4rem)">
        <div class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu</div>

        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Dashboard</span>
        </x-nav-link>

        @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isSupervisor())
        {{-- Master Data --}}
        <div class="mt-6 mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Master Data</div>

        <x-nav-link :href="route('master.categories.index')" :active="request()->routeIs('master.categories.*')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            <span>Kategori</span>
        </x-nav-link>

        <x-nav-link :href="route('master.products.index')" :active="request()->routeIs('master.products.*')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span>Produk</span>
        </x-nav-link>

        <x-nav-link :href="route('master.suppliers.index')" :active="request()->routeIs('master.suppliers.*')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span>Supplier</span>
        </x-nav-link>
        @endif

        {{-- Operasional --}}
        @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isCashier() || auth()->user()->isSupervisor() || auth()->user()->isWarehouse())
        <div class="mt-6 mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Operasional</div>
        @endif

        @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isCashier())
        <x-nav-link :href="route('transactions.pos')" :active="request()->routeIs('transactions.pos')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <span>POS / Penjualan</span>
        </x-nav-link>
        @endif

        @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isSupervisor())
        <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            <span>Riwayat Transaksi</span>
        </x-nav-link>
        @endif

        @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isWarehouse())
        <x-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span>Inventaris</span>
        </x-nav-link>
        @endif

        {{-- Manajemen --}}
        @if(auth()->user()->isOwner() || auth()->user()->isManager())
        <div class="mt-6 mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Manajemen</div>

        <x-nav-link :href="route('branches.index')" :active="request()->routeIs('branches.*')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span>Cabang</span>
        </x-nav-link>
        @endif

        @if(auth()->user()->isOwner())
        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
            <span>Pengguna</span>
        </x-nav-link>
        @endif

        {{-- Laporan --}}
        @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isSupervisor())
        <div class="mt-6 mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Laporan</div>

        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" sidebar>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span>Laporan</span>
        </x-nav-link>
        @endif
    </nav>
</aside>

{{-- Overlay (mobile) --}}
<div x-show="sidebarOpen" x-cloak
     @@click="sidebarOpen = false"
     class="fixed inset-0 z-20 bg-black/50 lg:hidden">
</div>
