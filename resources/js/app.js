

import Alpine from 'alpinejs';

import Chart from 'chart.js/auto';
window.Chart = Chart;

window.Alpine = Alpine;

Alpine.store('layout', {
    sidebarOpen: true,
    toggle() {
        this.sidebarOpen = !this.sidebarOpen;
    }
});

Alpine.start();
