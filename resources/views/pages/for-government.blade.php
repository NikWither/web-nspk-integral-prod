@extends('layouts.app')

@section('title', 'Решения для государства')

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

  /* Контейнер управляет высотой, canvas заполняет его */
  .chart-box {
    position: relative;
    height: min(48vh, 420px); /* можно 360–480px под дизайн */
  }

  .chart-box canvas {
    display: block;
    width: 100% !important;
    height: 100% !important;
  }

  .lead-text {
    font-size: 25px;
  }
</style>
@endpush


@section('content')
    <div class="container py-4">
        <h1 class="mb-3">Гипотезы для министерства здравоохранения</h1>
        <p class="lead-text">Гипотеза: люди, которые покупают БАДы реже ходят в аптеки и больницы</p>
        <!-- <p>Страница находится в разработке. Совсем скоро здесь появятся готовые сценарии и инструкции.</p> -->

<div class="card chart-card mt-4">
  <div class="card-body">
    <h2 class="h4 mb-3">Гипотеза: влияние БАДов на обращаемость в больницы</h2>
    <p class="text-muted">
      Сравнение частоты обращений за медицинской помощью между группами «Употребляют БАДы» и «Не употребляют».
    </p>

    <div class="charts-row d-flex flex-wrap justify-content-between align-items-start gap-4" style="gap: 2rem;">
      <!-- Левый график -->
      <div class="chart-box flex-fill" style="min-width: 320px; height: 360px;">
        <h6 class="text-center mb-2 fw-semibold">Доля населения, употребляющего БАДы</h6>
        <canvas id="governmentSupplementsChart" aria-label="Диаграмма употребления БАДов" role="img"></canvas>
      </div>

      <!-- Правый график -->
      <div class="chart-box flex-fill" style="min-width: 420px; height: 360px;">
        <h6 class="text-center mb-2 fw-semibold">Динамика обращений в больницы по месяцам</h6>
        <canvas id="hospitalVisitsTrendChart" aria-label="Динамика обращений по месяцам" role="img"></canvas>
      </div>
    </div>
  </div>
</div>


    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // ======= ПЕРВЫЙ ГРАФИК (БАР) =======
    const canvas = document.getElementById('governmentSupplementsChart');
    if (canvas && window.Chart) {
        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: [
                    'Употребляют БАДы — 30%',
                    'Употребляют БАДы — 41%'
                ],
                datasets: [
                    {
                        label: 'Процент обращений',
                        data: [30, 41],
                        backgroundColor: ['rgba(25, 135, 84, 0.85)', 'rgba(226, 36, 27, 0.85)'],
                        borderColor: ['#198754', '#e2241b'],
                        borderWidth: 4,
                        borderRadius: 12,
                        maxBarThickness: 160,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 10,
                            callback: (value) => value + '%',
                        },
                        title: {
                            display: true,
                            text: 'Процент обращений (%)',
                        },
                    },
                    x: {
                        ticks: {
                            callback: (value, index, ticks) => ticks[index].label,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => context.raw + '% обращений',
                        },
                    },
                },
            },
        });
    }

    // ======= ВТОРОЙ ГРАФИК (ЛИНИИ) =======
    const lineCanvas = document.getElementById('hospitalVisitsTrendChart');
    if (lineCanvas && window.Chart) {
        const months = ["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"];
        const supplements_pct     = [7.8, 7.6, 7.4, 7.2, 7.1, 6.9, 6.8, 6.9, 7.0, 7.3, 7.5, 7.7];
        const no_supplements_pct  = [10.4, 11.0, 10.6, 10.1, 9.8, 9.6, 9.5, 9.7, 10.0, 10.8, 10.9, 10.7];

        new Chart(lineCanvas, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Употребляют БАДы',
                        data: supplements_pct,
                        borderColor: '#0d6efd', // синий
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        tension: 0.35,
                        pointRadius: 0,
                    },
                    {
                        label: 'Не употребляют',
                        data: no_supplements_pct,
                        borderColor: '#6c757d', // серый
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        tension: 0.35,
                        pointRadius: 0,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 16,
                        ticks: {
                            stepSize: 2,
                            callback: (v) => `${v}%`,
                        },
                        title: {
                            display: true,
                            text: 'Доля обратившихся за месяц (%)',
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.06)',
                        },
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.04)',
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'line',
                        }
                    },
                    title: {
                        display: true,
                        text: 'Динамика обращений в больницы по месяцам',
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.label} — ${ctx.dataset.label}: ${ctx.formattedValue}%`
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                },
                elements: {
                    line: { fill: false }
                }
            }
        });
    }
});
</script>

@endpush