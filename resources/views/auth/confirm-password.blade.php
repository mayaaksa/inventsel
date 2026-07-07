<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password | InvenTsel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[#FFF9F8]">

    <div class="fixed inset-0 -z-50 overflow-hidden bg-gradient-to-br from-[#FFF9F8] to-[#FFD1DC]">
        <div class="absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-red-500/20 blur-[180px]"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 h-[600px] w-[900px] rounded-full bg-pink-400/30 blur-[180px]"></div>
        <div class="absolute -bottom-24 -right-20 h-[600px] w-[600px] rounded-full bg-yellow-300/20 blur-[170px]"></div>
    </div>

    <div class="w-full max-w-lg text-center">
        
        <div class="mb-12">
            <h1 class="text-6xl font-black italic drop-shadow-sm" style="color: #8E1632;">
                InvenTsel
            </h1>
            <p class="text-sm font-semibold text-slate-900 uppercase tracking-[0.3em] mt-3">by Telkomsel</p>
        </div>

        <div class="bg-white/60 backdrop-blur-2xl border border-white/50 p-10 rounded-[32px] shadow-xl text-left">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-800">Konfirmasi Password</h2>
                <p class="text-slate-500 text-xs mt-2 px-4 leading-relaxed">
                    Ini adalah area aman aplikasi. Silakan konfirmasi password kamu sebelum melanjutkan.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold text-slate-700 mb-2 ml-1 uppercase tracking-wider">Password</label>
                    <input type="password" name="password" required autocomplete="current-password"
                           class="w-full rounded-2xl border-none bg-white/70 px-4 py-4 shadow-inner focus:ring-2 focus:ring-[#8E1632] transition font-medium text-slate-800">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                </div>

                <button type="submit" 
                        class="w-full py-4 bg-[#8E1632] hover:bg-red-950 text-white font-bold text-center rounded-2xl transition-all active:scale-95 shadow-lg shadow-red-900/20">
                    KONFIRMASI
                </button>
            </form>

            <p class="mt-10 text-center text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                &copy; {{ date('Y') }} InvenTsel
            </p>
        </div>
    </div>

</body>
</html>