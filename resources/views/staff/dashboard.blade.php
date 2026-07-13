@extends('layouts.staff_app')

@section('content')
<main class="flex-1 p-8 bg-slate-50">
    <header class="mb-8">
        <h2 class="text-2xl font-black text-slate-800">ဘဏ်လုပ်ငန်းအချက်အလက်များ</h2>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="font-bold mb-4">ရာသီအလိုက် ချေးငွေနှိုင်းယှဉ်ချက်</h4>
            <canvas id="seasonalChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="font-bold mb-4">ချေးငွေအမျိုးအစားအလိုက် အခြေအနေ</h4>
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Seasonal Chart
    const seasonData = {!! json_encode($chartDataSeason) !!};
    new Chart(document.getElementById('seasonalChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(seasonData),
            datasets: [
                { label: 'မိုးရာသီ', data: Object.values(seasonData).map(i => i.rainy), backgroundColor: '#3b82f6' },
                { label: 'ဆောင်းရာသီ', data: Object.values(seasonData).map(i => i.winter), backgroundColor: '#10b981' }
            ]
        }
    });

    // Status Chart
    const statusData = {!! json_encode($chartDataStatus) !!};
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(statusData),
            datasets: [
                { label: 'pending', data: Object.values(statusData).map(i => i.pending ?? 0), backgroundColor: '#fbbf24' },
                { label: 'accepted', data: Object.values(statusData).map(i => i.accepted ?? 0), backgroundColor: '#22c55e' },
                { label: 'rejected', data: Object.values(statusData).map(i => i.rejected ?? 0), backgroundColor: '#ef4444' }
            ]
        },
        options: { scales: { x: { stacked: true }, y: { stacked: true } } }
    });
</script>
@endsection
