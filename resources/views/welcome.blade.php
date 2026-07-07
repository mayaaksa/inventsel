<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang | InvenTsel</title>
    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[#FFF9F8]">

    <!-- Background Glows (Diperkuat Pink & Merah sesuai Dashboard) -->
    <div class="fixed inset-0 -z-50 overflow-hidden bg-gradient-to-br from-[#FFF9F8] to-[#FFD1DC]">
        <div class="absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-red-500/20 blur-[180px]"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 h-[600px] w-[900px] rounded-full bg-pink-400/30 blur-[180px]"></div>
        <div class="absolute -bottom-24 -right-20 h-[600px] w-[600px] rounded-full bg-yellow-300/20 blur-[170px]"></div>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-lg text-center">
        
        <!-- Branding (Miring & Putih - Mengikuti gaya Dashboard) -->
        <div class="mb-12">
            <h1 class="text-6xl font-black italic drop-shadow-sm" style="color: #8E1632;">
                InvenTsel
            </h1>
            <p class="text-sm font-semibold text-slate-900 uppercase tracking-[0.3em] mt-3">by Telkomsel</p>
        </div>

        <!-- Card Pilihan -->
        <div class="bg-white/60 backdrop-blur-2xl border border-white/50 p-10 rounded-[32px] shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Halo, Selamat Datang!</h2>
                <p class="text-[#8E1632] text-m mt-1">Masuk atau buat akun untuk memulai</p>
            </div>

            <div class="space-y-4">
                <!-- Tombol Masuk: Warna Merah Dashboard -->
                <a href="{{ route('login') }}" 
                   class="block w-full py-4 bg-[#8E1632] hover:bg-red-950 text-white font-bold text-center rounded-2xl transition-all active:scale-95 shadow-lg shadow-red-900/20">
                   Masuk
                </a>
                
                <!-- Tombol Daftar: Warna & Style Senada -->
                <a href="{{ route('register') }}" 
                   class="block w-full py-4 bg-white border-2 border-slate-200 text-slate-800 font-bold text-center rounded-2xl hover:bg-slate-50 transition-all active:scale-95">
                   Daftar
                </a>
            </div>

            <p class="mt-10 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                &copy; {{ date('Y') }} InvenTsel
            </p>
        </div>
    </div>

</body>
</html>