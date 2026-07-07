@props([
    'totalBarang',
    'barangDipinjam',
    'barangTersedia',
    'peminjamanHariIni'
])

@php

$cards = [

[
'title' => 'Stok Barang',
'value' => $totalBarang,
'icon' => 'package',
'color' => '#EF4444',
'bg' => 'from-red-500 to-rose-500',
'trend' => '+12.5%'
],

[
'title' => 'Stok Dipinjam',
'value' => $barangDipinjam,
'icon' => 'clipboard-list',
'color' => '#F97316',
'bg' => 'from-orange-500 to-amber-500',
'trend' => '+8.3%'
],

[
'title' => 'Barang Tersedia',
'value' => $barangTersedia,
'icon' => 'check-circle-2',
'color' => '#22C55E',
'bg' => 'from-green-500 to-emerald-500',
'trend' => '+15.7%'
],

[
'title' => 'Hari Ini',
'value' => (int) ($peminjamanHariIni ?? 0),
'icon' => 'calendar-days',
'color' => '#8B5CF6',
'bg' => 'from-violet-500 to-fuchsia-500',
'trend' => '+2'
]

];

@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

@foreach($cards as $i => $card)

<div
class="rounded-[28px]
bg-white/60
backdrop-blur-2xl
border border-white/40
shadow-xl
overflow-hidden
transition-all
duration-300
hover:-translate-y-1
hover:shadow-2xl">

<div class="p-6">

<div class="flex justify-between items-start">

<div>

<p class="text-slate-500">

{{ $card['title'] }}

</p>

<h2 class="mt-3 text-5xl font-bold text-slate-800">

{{ number_format($card['value']) }}

</h2>

<p
class="mt-3 text-sm font-medium"
style="color:{{ $card['color'] }}">

↑ {{ $card['trend'] }}
<span class="text-slate-400">
dari bulan lalu
</span>

</p>

</div>

<div
class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br {{ $card['bg'] }} shadow-lg">

<i
data-lucide="{{ $card['icon'] }}"
class="w-8 h-8 text-white">
</i>

</div>

</div>

</div>

<div class="h-14">

<canvas
id="sparkline{{ $i }}">
</canvas>

</div>

</div>

@endforeach

</div>

@push('scripts')

<script>

const sparklineData = [

[18,22,21,28,26,30,35],
[8,10,14,11,15,18,16],
[42,45,40,43,39,47,46],
[2,3,2,5,4,6,5]

];

const sparkColors = [

'#EF4444',
'#F97316',
'#22C55E',
'#8B5CF6'

];

document.addEventListener('DOMContentLoaded',()=>{

sparklineData.forEach((data,index)=>{

const ctx=document.getElementById('sparkline'+index);

if(!ctx) return;

new Chart(ctx,{

type:'line',

data:{

labels:data,

datasets:[{

data:data,

borderColor:sparkColors[index],

backgroundColor:'transparent',

borderWidth:2,

pointRadius:0,

tension:.45,

fill:false

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{
legend:{
display:false
},
tooltip:{
enabled:false
}
},

scales:{
x:{
display:false
},
y:{
display:false
}
},

elements:{
line:{
capBezierPoints:true
}
}

}

});

});

});

</script>

@endpush