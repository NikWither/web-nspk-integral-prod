@extends('layouts.app')

@section('title', 'Решения для банков')

@push('styles')
<style>
  .chart-card {
    max-width: 980px;
    margin: 2rem auto 0;
    border-radius: 16px;
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
  }
  .chart-card .card-body {
    padding: clamp(1.5rem, 4vw, 2.5rem);
  }
  .charts-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-top: 1rem;
  }
  @media (min-width: 768px) {
    .charts-grid { grid-template-columns: 1fr 1fr; }
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
</style>
@endpush

@section('content')
<div class="container py-4">
  <h1 class="mb-3">Гипотезы и аналитика для банков</h1>
  <p class="lead">Изучайте клиентские сегменты, динамику расходов и находите точки роста с помощью транзакционной аналитики «Мира».</p>

  <a href="{{ route('hypothesis.create') }}" class="btn btn-primary mt-2">Перейти к проверке гипотезы</a>

  {{-- Линейный график: объём рынка + доля банка --}}
  <div class="card chart-card mt-4">
    <div class="card-body">
      <h2 class="h4 mb-2">Динамика рынка и доли банка</h2>
      <p class="text-muted">2019–2023 гг., объём рынка (млрд ₽) и доля банка (%).</p>
      <div class="chart-box">
        <canvas id="marketShareLineChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Столбчатые диаграммы: отдельные метрики --}}
  <div class="card chart-card mt-4">
    <div class="card-body">
      <h2 class="h4 mb-3">Сравнение показателей (столбчатые диаграммы)</h2>
      <div class="charts-grid">
        <div>
          <h3 class="h6 text-center mb-2">Объём рынка (млрд ₽)</h3>
          <div class="chart-box">
            <canvas id="marketBarChart"></canvas>
          </div>
        </div>
        <div>
          <h3 class="h6 text-center mb-2">Доля банка (%)</h3>
          <div class="chart-box">
            <canvas id="shareBarChart"></canvas>
          </div>
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
  if (!window.Chart) return;

  const labels = ['2019', '2020', '2021', '2022', '2023'];
  const market = [104.7, 110.9, 117.3, 130.5, 148.7]; // млрд ₽
  const share  = [7.70, 7.90, 8.10, 9.00, 9.80];       // %

  const fmt = (label, v) => {
    if (label.includes('%')) {
      return v.toLocaleString('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' %';
    }
    if (label.includes('млрд')) {
      return v.toLocaleString('ru-RU', { minimumFractionDigits: 1, maximumFractionDigits: 1 }) + ' млрд ₽';
    }
    return v;
  };

  // Линейный комбинированный график (две оси Y)
  new Chart(document.getElementById('marketShareLineChart'), {
    type: 'line',
    data: {
      labels,
      datasets: [
        {
          label: 'Объём рынка (млрд ₽)',
          data: market,
          yAxisID: 'y',
          borderColor: 'rgb(233, 61, 61)',
          backgroundColor: 'rgba(233, 61, 61, 0.15)',
          borderWidth: 3,
          tension: 0.3,
          pointRadius: 4,
          pointBackgroundColor: 'rgb(233, 61, 61)',
          fill: true
        },
        {
          label: 'Доля банка (%)',
          data: share,
          yAxisID: 'y1',
          borderColor: '#f59e0b',
          backgroundColor: 'rgba(245,158,11,0.15)',
          borderWidth: 3,
          tension: 0.3,
          pointRadius: 4,
          pointBackgroundColor: '#f59e0b',
          fill: false,
          borderDash: [6, 4]
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { position: 'bottom' },
        tooltip: {
          callbacks: {
            label: (ctx) => `${ctx.dataset.label}: ${fmt(ctx.dataset.label, ctx.raw)}`
          }
        }
      },
      scales: {
        x: { title: { display: true, text: 'Год' } },
        y: {
          position: 'left',
          title: { display: true, text: 'млрд ₽' },
          grid: { drawOnChartArea: true }
        },
        y1: {
          position: 'right',
          title: { display: true, text: '%' },
          grid: { drawOnChartArea: false }
        }
      }
    }
  });

  // Столбчатая: объём рынка
  new Chart(document.getElementById('marketBarChart'), {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Объём рынка (млрд ₽)',
        data: market,
        borderColor: 'rgb(233, 61, 61)',
        backgroundColor: 'rgba(233, 61, 61, 0.25)',
        borderWidth: 1,
        borderRadius: 8,
        maxBarThickness: 48
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: (ctx) => fmt('млрд', ctx.raw) } }
      },
      scales: {
        x: { title: { display: true, text: 'Год' } },
        y: { title: { display: true, text: 'млрд ₽' } }
      }
    }
  });

  // Столбчатая: доля банка
  new Chart(document.getElementById('shareBarChart'), {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Доля банка (%)',
        data: share,
        borderColor: '#10b981',
        backgroundColor: 'rgba(16,185,129,0.25)',
        borderWidth: 1,
        borderRadius: 8,
        maxBarThickness: 48
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: (ctx) => fmt('%', ctx.raw) } }
      },
      scales: {
        x: { title: { display: true, text: 'Год' } },
        y: {
          title: { display: true, text: '%' },
          ticks: { callback: (v) => v + ' %' }
        }
      }
    }
  });
});
</script>
@endpush
