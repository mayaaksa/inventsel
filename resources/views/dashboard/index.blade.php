<x-app-layout>
    <div class="space-y-5">
        
        <x-dashboard.hero
            :totalBarang="$totalBarang"
            :barangDipinjam="$barangDipinjam"
            :barangTersedia="$barangTersedia"
        />

        <x-dashboard.stats 
            :totalBarang="$totalBarang" 
            :barangDipinjam="$barangDipinjam" 
            :barangTersedia="$barangTersedia" 
            :peminjamanHariIni="$peminjamanHariIni" 
        />
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="lg:col-span-2 flex flex-col gap-4">
                <x-dashboard.chart />
                <x-dashboard.quick-action />
            </div>

            <div class="flex flex-col gap-4">
                <x-dashboard.activity 
                    :sedangDipinjam="$sedangDipinjam" 
                    :dikembalikan="$dikembalikan" 
                    :terlambat="$terlambat" 
                />
                
                <x-dashboard.recent-borrowing :recentBorrowings="$recentBorrowings" />
            </div>
        </div>

        <x-dashboard.footer />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();

            // 1. Bar Chart dengan Grid yang dihilangkan
            const ctxBar = document.getElementById('borrowingChart');
            if (ctxBar) {
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: {!! json_encode($chartData) !!},
                            backgroundColor: '#ef4444',
                            borderRadius: 6 // Lebih kecil agar lebih ramping
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, grid: { display: true }, ticks: { stepSize: 1, font: { size: 10 } } },
                            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                        },
                        plugins: { legend: { display: true } }
                    }
                });
            }

            // 2. Doughnut Chart (Ringkas)
            const ctxDonut = document.getElementById('activityChart');
            if (ctxDonut) {
                new Chart(ctxDonut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Dipinjam', 'Kembali', 'Terlambat'],
                        datasets: [{
                            data: [{{ $sedangDipinjam ?? 0 }}, {{ $dikembalikan ?? 0 }}, {{ $terlambat ?? 0 }}],
                            backgroundColor: ['#ef4444', '#3b82f6', '#f59e0b'],
                            borderWidth: 0,
                            cutout: '80%' // Dibuat lebih tipis (80% cutout)
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            }
        });
    </script>
</x-app-layout>
