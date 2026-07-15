<div class="w-64 h-screen sticky top-0 text-white p-6 shadow-lg flex flex-col" style="background: linear-gradient(180deg, #7a0d1e 0%, #a11225 35%, #d3541c 100%);">
    <h1 class="text-2xl font-bold tracking-wider mb-8">VELOZZA</h1>
    <nav class="space-y-3 flex-1">
        <a href="{{ url('/admin/jadwal') }}"
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium transition
           {{ request()->routeIs('admin.jadwal*') || request()->is('admin/jadwal*')
                ? 'bg-white text-[#a11225] font-semibold shadow-sm'
                : 'text-white/90 hover:bg-white/10' }}">
            <span class="text-lg">📅</span> Kelola Jadwal
        </a>

        <a href="{{ url('/admin/pembayaran') }}"
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium transition
           {{ request()->is('admin/pembayaran*')
                ? 'bg-white text-[#a11225] font-semibold shadow-sm'
                : 'text-white/90 hover:bg-white/10' }}">
            <span class="text-lg">🎟️</span> Pembayaran
        </a>

        <a href="{{ url('/admin/riwayat') }}"
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium transition
           {{ request()->is('admin/riwayat*')
                ? 'bg-white text-[#a11225] font-semibold shadow-sm'
                : 'text-white/90 hover:bg-white/10' }}">
            <span class="text-lg">🕘</span> Riwayat
        </a>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 text-left py-2.5 px-4 rounded-lg hover:bg-white/10 transition text-white/80 cursor-pointer">
            <span class="text-lg">🚪</span> Logout
        </button>
    </form>
</div>