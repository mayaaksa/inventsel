<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InventSel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body
    class="font-[Poppins] antialiased text-slate-800 overflow-x-hidden">

    <!-- Background -->
    <div
        class="fixed inset-0 -z-50">
        <!-- Base -->
        <div
            class="absolute inset-0 bg-[#FFF9F8]">
        </div>

        <!-- Top Left Glow -->
        <div
            class="absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-red-500/30 blur-[180px]">
        </div>

        <!-- Top Center Glow -->
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 h-[600px] w-[900px] rounded-full bg-pink-400/20 blur-[180px]">
        </div>

        <!-- Top Right Yellow -->
        <div
            class="absolute -top-24 right-0 h-[600px] w-[600px] rounded-full bg-yellow-300/25 blur-[170px]">
        </div>

        <!-- Bottom -->
        <div
            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[500px] w-[900px] rounded-full bg-rose-200/20 blur-[200px]">
        </div>
    </div>

    <div class="flex gap-8 p-6 min-h-screen">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Overlay --}}
    <div
        id="sidebarOverlay"
        class="fixed inset-0 bg-black/40 hidden z-40 lg:hidden">
    </div>

    {{-- Content --}}
    <div class="flex-1 flex flex-col">
        @include('partials.navbar')

            <main class="flex-1">

                {{ $slot }}

            </main>

        </div>

    </div>

    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        lucide.createIcons();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const menu = document.getElementById('menuButton');

menu.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
});

overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
});
</script>
</body>

</html>