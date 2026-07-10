@props(['current' => 1])

@php
    $steps = [1 => 'Pilih Kereta', 2 => 'Pilih Kursi', 3 => 'Penumpang', 4 => 'Pembayaran'];
@endphp

<div class="bg-gradient-to-r from-primary-deep via-primary to-primary-light  px-6 py-4 flex items-center justify-between text-white">
    <a href="{{ route('pemesanan.cari') }}" class="text-xl font-extrabold tracking-wide">VELOZZA</a>

    <div class="flex items-center gap-2 text-sm">
        @foreach ($steps as $num => $label)
            <div class="flex items-center gap-2 {{ $num == $current ? 'font-bold text-white' : 'text-white/60' }}">
                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold
                    {{ $num == $current ? 'bg-white text-primary' : ($num < $current ? 'bg-white/30 text-white' : 'bg-white/20 text-white/70') }}">
                    {{ $num }}
                </span>
                <span>{{ $label }}</span>
            </div>
            @if (!$loop->last)
                <span class="text-white/40 mx-1">›</span>
            @endif
        @endforeach
    </div>
</div>