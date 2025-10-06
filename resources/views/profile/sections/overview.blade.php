<h2 class="section-title">Общие сведения</h2>

@php($hypotheses = $hypotheses ?? collect())

@php($statusLabels = [\App\Models\Hypothesis::STATUS_RESOLVED => 'Проверена', \App\Models\Hypothesis::STATUS_IN_PROGRESS => 'На проверке'])

@php($statusOptions = $hypotheses->pluck('status')->unique()->values())



@push('styles')

    <style>

        .hypotheses-section {

            margin-top: 2.75rem;

        }



        .hypotheses-section .section-subtitle {

            font-size: 1.35rem;

            font-weight: 600;

            margin-bottom: 1rem;

        }



        .hypothesis-filter {

            display: flex;

            flex-wrap: wrap;

            gap: 0.75rem;

            margin-bottom: 1.5rem;

        }



        .hypothesis-filter .form-select {

            min-width: 220px;

        }



        .hypothesis-grid {

            display: flex;

            flex-direction: column;

            gap: 1.5rem;

        }



        .hypothesis-card {

            background-color: #ffffff;

            border: 1px solid rgba(15, 23, 42, 0.08);

            border-radius: 18px;

            padding: 1.75rem;

            max-width: 760px;

            width: 100%;

            margin-inline: auto;

            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);

            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.25s ease;

        }



        .hypothesis-card:hover {

            transform: translateY(-3px);

            box-shadow: 0 24px 44px rgba(15, 23, 42, 0.1);

        }



        .hypothesis-card--pending {

            opacity: 0.72;

            filter: grayscale(0.25);

        }



        .hypothesis-card__header {

            display: flex;

            justify-content: space-between;

            align-items: baseline;

            gap: 1.25rem;

            margin-bottom: 1.25rem;

        }



        .hypothesis-card__header small {

            color: rgba(15, 23, 42, 0.6);

        }



        .hypothesis-card__body {

            display: grid;

            gap: 1rem;

        }



        .hypothesis-card__text {

            font-size: 1.05rem;

            line-height: 1.6;

            background: rgba(15, 23, 42, 0.035);

            padding: 1rem 1.15rem;

            border-radius: 14px;

        }



        .hypothesis-attributes {

            margin: 0;

            padding: 0;

            list-style: none;

            display: grid;

            gap: 0.45rem;

        }



        .hypothesis-attributes li {

            display: flex;

            justify-content: space-between;

            gap: 1.5rem;

            border-top: 1px dashed rgba(15, 23, 42, 0.08);

            padding-top: 0.45rem;

            font-size: 0.97rem;

        }



        .hypothesis-attributes li:first-child {

            border-top: none;

            padding-top: 0;

        }



        .hypothesis-attributes .label {

            color: rgba(31, 41, 55, 0.68);

            font-weight: 500;

        }



        .hypothesis-attributes .value {

            text-align: right;

            color: #111827;

            word-break: break-word;

        }



        .hypotheses-empty {

            margin-top: 2rem;

        }

    </style>

@endpush



<p class="text-muted">Базовая информация о вашей учетной записи.</p>

<dl class="row">

    <dt class="col-sm-3">Имя</dt>

    <dd class="col-sm-9">{{ $user->name }}</dd>



    <dt class="col-sm-3">Email</dt>

    <dd class="col-sm-9">{{ $user->email }}</dd>



    <dt class="col-sm-3">Тип аккаунта</dt>

    <dd class="col-sm-9">@include('profile.partials.account-type', ['type' => $user->type_account])</dd>



    <dt class="col-sm-3">Создан</dt>

    <dd class="col-sm-9">{{ $user->created_at?->format('d.m.Y H:i') ?? '—' }}</dd>

</dl>



@if ($hypotheses->isNotEmpty())

    <div class="hypotheses-section">

        <h3 class="section-subtitle">Мои гипотезы</h3>



        <div class="hypothesis-filter">

            <select class="form-select" id="hypothesisStatusFilter">

                <option value="">Все статусы</option>

                @foreach ($statusOptions as $status)

                    <option value="{{ $status }}">{{ $statusLabels[$status] ?? ucfirst($status) }}</option>

                @endforeach

            </select>



        </div>



        <div class="hypothesis-grid" id="hypothesisGrid">

            @foreach ($hypotheses as $hypothesis)

                @php($isResolved = $hypothesis->status === \App\Models\Hypothesis::STATUS_RESOLVED)

                <article class="hypothesis-card {{ $isResolved ? '' : 'hypothesis-card--pending' }}"

                         data-status="{{ $hypothesis->status }}"

>

                    <div class="hypothesis-card__header">

                        <span class="badge {{ $isResolved ? 'bg-success' : 'bg-secondary' }}">{{ $statusLabels[$hypothesis->status] ?? ucfirst($hypothesis->status) }}</span>

                        <small>Создана: {{ $hypothesis->created_at?->format('d.m.Y H:i') ?? '—' }}</small>

                    </div>

                    <div class="hypothesis-card__body">

                        <div class="hypothesis-card__text">{{ $hypothesis->hypothesis }}</div>

                        <ul class="hypothesis-attributes">

                            <li><span class="label">ID</span><span class="value">{{ $hypothesis->id }}</span></li>

                            <li><span class="label">Статус</span><span class="value">{{ $statusLabels[$hypothesis->status] ?? ucfirst($hypothesis->status) }}</span></li>

                            <li><span class="label">Локация</span><span class="value">{{ $hypothesis->user_location ?? '—' }}</span></li>

                            <li><span class="label">Диапазон дат</span><span class="value">{{ $hypothesis->date_range ?? '—' }}</span></li>

                            <li><span class="label">MCC</span><span class="value">{{ $hypothesis->mcc_code }}</span></li>

                            <li><span class="label">Обновлена</span><span class="value">{{ $hypothesis->updated_at?->format('d.m.Y H:i') ?? '—' }}</span></li>

                        </ul>

                    </div>

                </article>

            @endforeach

        </div>

    </div>

@else

    <div class="hypotheses-empty alert alert-secondary">

        У вас пока нет сохранённых гипотез. Попробуйте задать первую на странице «Гипотеза».

    </div>

@endif



@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const statusFilter = document.getElementById('hypothesisStatusFilter');

            const cards = Array.from(document.querySelectorAll('#hypothesisGrid .hypothesis-card'));



            const applyFilters = () => {

                const statusValue = statusFilter?.value ?? '';



                cards.forEach((card) => {

                    const cardStatus = card.getAttribute('data-status') ?? '';

                    const statusMatch = !statusValue || statusValue === cardStatus;

                    card.hidden = !statusMatch;

                });

            };



            statusFilter?.addEventListener('change', applyFilters);

        });

    </script>

@endpush

