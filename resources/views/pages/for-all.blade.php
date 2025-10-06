@extends('layouts.app')

@section('title', 'Решения для всех отраслей')

@push('styles')
<style>
  .chart-card {
    max-width: 760px;
    margin: 2rem auto 0;
    border-radius: 16px;
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
  }

  .chart-card .card-body {
    padding: clamp(1.5rem, 4vw, 2.5rem);
  }

  /* новый обёрточный блок с управляемой высотой */
  .chart-box {
    position: relative;
    height: min(48vh, 420px); /* можно заменить на 380-480px под дизайн */
  }

  .chart-box canvas {
    display: block;
    width: 100% !important;
    height: 100% !important; /* критично: даём высоту от родителя */
  }
</style>
@endpush


@section('content')
    <div class="container py-4">
        <h1 class="mb-3">Гипотезы для любых отраслей</h1>
        <p class="lead">Готовые сценарии проверки спроса, анализа трендов и оценки эффективности для компаний любого масштаба.</p>
        <p>Страница находится в разработке. Совсем скоро здесь появятся готовые сценарии и инструкции.</p>
        <a href="{{ route('hypothesis.create') }}" class="btn btn-primary mt-3">Перейти к проверке гипотезы</a>

        <div class="card chart-card mt-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Потребление БАДов в УрФО за 2025 год</h2>
                <p class="text-muted">Динамика ежемесячного потребления пищевых добавок в Уральском федеральном округе.</p>

                <div class="chart-box">
                <canvas id="supplementsChart" aria-label="График потребления БАДов" role="img"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('supplementsChart');
            if (!canvas || !window.Chart) {
                return;
            }

            const supplementsData = [
                { month: 'Октябрь', consumption: 140 },
                { month: 'Ноябрь', consumption: 170 },
                { month: 'Декабрь', consumption: 190 },
                { month: 'Январь', consumption: 160 },
                { month: 'Февраль', consumption: 150 },
                { month: 'Март', consumption: 130 },
                { month: 'Апрель', consumption: 110 },
                { month: 'Май', consumption: 100 },
            ];

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: supplementsData.map((item) => item.month),
                    datasets: [
                        {
                            label: 'Потребление БАДов',
                            data: supplementsData.map((item) => item.consumption),
                            borderColor: '#e2241b',
                            backgroundColor: 'rgba(226, 36, 27, 0.15)',
                            borderWidth: 3,
                            tension: 0.35,
                            fill: true,
                            pointRadius: 4,
                            pointBackgroundColor: '#e2241b',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 20,
                            },
                            title: {
                                display: true,
                                text: 'Индекс потребления',
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Месяц',
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                boxWidth: 18,
                                boxHeight: 18,
                            },
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        },
                    },
                },
            });
        });
    </script>
@endpush
