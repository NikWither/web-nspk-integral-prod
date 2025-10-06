@extends('layouts.app')

@section('title', 'Решения для бизнеса')

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

  .stats-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-top: 2rem;
  }

  @media (min-width: 768px) {
    .stats-grid {
      grid-template-columns: 1fr 1fr;
    }
  }

  .stat-card {
    border-radius: 16px;
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
    padding: 1.5rem;
    text-align: center;
  }

  .stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin-top: 0.5rem;
  }

  .pie-box {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 0;
  }

  .pie-box canvas {
    width: 100% !important;
    max-width: 360px;
    height: auto !important;
    display: block;
  }

  /* Сетка для двух графиков в одном блоке */
  .charts-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-top: 1rem;
  }

  @media (min-width: 768px) {
    .charts-grid {
      grid-template-columns: 1fr 1fr;
    }
  }

  .chart-box {
    position: relative;
    height: min(40vh, 360px);
  }

  .chart-box canvas {
    display: block;
    width: 100% !important;
    height: 100% !important;
  }

  .consumer-card {
    border-radius: 16px;
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
    padding: 1.5rem;
    margin-top: 1.5rem;
  }

  .consumer-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .consumer-card p {
    color: #475569;
    margin: 0;
  }
</style>
@endpush

@section('content')
    <div class="container py-4">
        <h1 class="mb-3">Гипотезы и инсайты для бизнеса</h1>
        <p class="lead">Гипотеза: анализ спроса на витамины и БАДы за 2024 год.</p>

        {{-- Средний чек и аудитория --}}
        <div class="stats-grid">
            <div class="stat-card">
                <p class="text-muted mb-1">Средний чек</p>
                <div class="stat-value" id="averageCheckValue">0 ₽</div>
                                    <div class="consumer-card">
            <h3>Наиболее частая потребительская группа: Семьи</h3>
            <p>Эта группа активно покупает товары для всей семьи: продукты питания, товары для дома, детские товары, бытовую химию. 
               Их покупки регулярные и стабильные, они ценят скидки на оптовые наборы и акции "2 по цене 1". 
               Часто выбирают бренды с репутацией надёжности и хорошим соотношением цена/качество.</p>
        </div>
            </div>

            <div class="stat-card">
                <p class="text-muted mb-3">Целевая аудитория (возраст)</p>
                <div class="pie-box">
                    <canvas id="audiencePieChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Общий блок для двух графиков --}}
        <div class="card chart-card mt-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Ключевые метрики по годам</h2>
                <p class="text-muted">Рост потребления БАДов и выручки за 2019–2024 гг.</p>
                <div class="charts-grid">
                    <div>
                        <h3 class="h6 text-center mb-2">Потребление БАДов</h3>
                        <div class="chart-box">
                            <canvas id="businessSupplementsChart"></canvas>
                        </div>
                    </div>
                    <div>
                        <h3 class="h6 text-center mb-2">Выручка</h3>
                        <div class="chart-box">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Потребительская группа --}}

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Chart) return;

    // Средний чек
    const averageCheck = 1203;
    const averageCheckEl = document.getElementById('averageCheckValue');
    let currentValue = 0;
    const step = Math.ceil(averageCheck / 40);
    const animateAverage = setInterval(() => {
        currentValue += step;
        if (currentValue >= averageCheck) {
            currentValue = averageCheck;
            clearInterval(animateAverage);
        }
        averageCheckEl.textContent = currentValue.toLocaleString('ru-RU') + ' ₽';
    }, 15);

    // Диаграмма аудитории
    const audienceData = [
        { group: "До 18 лет", value: 10 },
        { group: "18–24", value: 24 },
        { group: "24–45", value: 35 },
        { group: "45+", value: 31 }
    ];
    new Chart(document.getElementById('audiencePieChart'), {
        type: 'pie',
        data: {
            labels: audienceData.map(a => a.group),
            datasets: [{
                data: audienceData.map(a => a.value),
                backgroundColor: ['rgb(233, 61, 61)', '#34D399', '#FBBF24', '#F87171']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { callbacks: { label: c => `${c.label}: ${c.raw}%` } }
            }
        }
    });

    // Графики в одном блоке
    const supplementsData = [
        { year: 2019, consumption: 131.25 },
        { year: 2020, consumption: 140.38 },
        { year: 2021, consumption: 160.50 },
        { year: 2022, consumption: 170.63 },
        { year: 2023, consumption: 175.75 },
        { year: 2024, consumption: 180.88 }
    ];
    new Chart(document.getElementById('businessSupplementsChart'), {
        type: 'line',
        data: {
            labels: supplementsData.map(i => i.year),
            datasets: [{
                label: 'Потребление',
                data: supplementsData.map(i => i.consumption),
                borderColor: 'rgb(233, 61, 61)',
                backgroundColor: 'rgba(233, 61, 61, 0.15)',
                borderWidth: 3,
                tension: 0.3,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: 'rgb(233, 61, 61)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { title: { display: true, text: 'Индекс (2019 = 100)' } },
                x: { title: { display: true, text: 'Год' } }
            }
        }
    });

    const revenueData = [
        { year: 2019, revenue: 12.5 },
        { year: 2020, revenue: 15.2 },
        { year: 2021, revenue: 17.8 },
        { year: 2022, revenue: 20.5 },
        { year: 2023, revenue: 23.0 },
        { year: 2024, revenue: 26.3 }
    ];
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueData.map(i => i.year),
            datasets: [{
                label: 'Выручка',
                data: revenueData.map(i => i.revenue),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                borderWidth: 3,
                tension: 0.3,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#10b981',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { title: { display: true, text: 'Выручка (млн ₽)' } },
                x: { title: { display: true, text: 'Год' } }
            }
        }
    });
});
</script>
@endpush
