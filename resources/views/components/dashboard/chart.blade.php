<div
    class="rounded-[30px]
    bg-white/60
    backdrop-blur-2xl
    border border-white/40
    shadow-xl
    p-7">

    <div class="flex items-start justify-between">

        <div>

            <div class="flex items-center gap-3">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-pink-500">

                    <i
                        data-lucide="chart-column"
                        class="w-6 h-6 text-white">
                    </i>

                </div>

                <div>

                    <h2
                        class="text-xl font-semibold text-slate-800">

                        Grafik Peminjaman

                    </h2>

                    <p
                        class="text-sm text-slate-500">

                        Statistik peminjaman 6 bulan terakhir
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="mt-8 h-[360px]">

        <canvas id="borrowingChart"></canvas>

    </div>

</div>