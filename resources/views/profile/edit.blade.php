<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2 p-8 bg-white/70 backdrop-blur-xl border border-white/50 rounded-3xl shadow-sm">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-8 bg-white/70 backdrop-blur-xl border border-white/50 rounded-3xl shadow-sm">
                @include('profile.partials.update-password-form')
            </div>

            <div class="p-8 bg-white/70 backdrop-blur-xl border border-white/50 rounded-3xl shadow-sm flex flex-col justify-center">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Akun</h3>
                <p class="text-sm text-slate-500 mb-4">Setelah akun dihapus, semua sumber daya dan data akan dihapus secara permanen.</p>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>