@props(['sedangDipinjam', 'dikembalikan', 'terlambat'])

<div
    class="rounded-[24px] border border-white/40 bg-white/60 backdrop-blur-2xl shadow-xl p-5">

    <div class="mb-5 flex items-center gap-3">

        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-pink-500 shadow">

            <i data-lucide="pie-chart" class="h-5 w-5 text-white"></i>

        </div>

        <div>

            <h2 class="text-lg font-semibold text-slate-800">
                Ringkasan Peminjaman
            </h2>

            <p class="text-xs text-slate-500">
                Status transaksi
            </p>

        </div>

    </div>

    <div class="relative flex h-[135px] items-center justify-center">

        <canvas id="activityChart"></canvas>

        <div class="absolute text-center">

            <div class="text-2xl font-bold text-slate-800">

                {{ $sedangDipinjam + $dikembalikan + $terlambat }}

            </div>

            <div class="text-xs text-slate-500">

                Total

            </div>

        </div>

    </div>

    <div class="mt-5 space-y-2">

        <div class="flex items-center justify-between rounded-lg bg-white/40 px-3 py-2">

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>

                <span class="text-sm text-slate-600">
                    Sedang Dipinjam
                </span>

            </div>

            <span class="font-semibold text-slate-800">

                {{ $sedangDipinjam }}

            </span>

        </div>

        <div class="flex items-center justify-between rounded-lg bg-white/40 px-3 py-2">

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>

                <span class="text-sm text-slate-600">
                    Dikembalikan
                </span>

            </div>

            <span class="font-semibold text-slate-800">

                {{ $dikembalikan }}

            </span>

        </div>

        <div class="flex items-center justify-between rounded-lg bg-white/40 px-3 py-2">

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>

                <span class="text-sm text-slate-600">
                    Terlambat
                </span>

            </div>

            <span class="font-semibold text-slate-800">

                {{ $terlambat }}

            </span>

        </div>

    </div>

</div>