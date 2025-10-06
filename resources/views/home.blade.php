@extends('layouts.app')

@section('title', 'Главная')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endpush

<style>

    .lead__wrapper {
        background-color: rgb(248, 249, 250);
        margin: 20px auto;
        padding: 20px;
        border-radius: 40px 0px 40px 0px;
    }

    .lead__wrapper_2 {
        background-color: rgb(248, 249, 250);
        margin: 20px auto;
        padding: 20px;
        border-radius: 0px 40px 0px 40px;
    }

    .lead__text {
        margin: 40px auto;
        margin-bottom: 20px;
        text-align: center;
        font-size: 40px;
    }

    .lead__suptext {
        text-align: center;
        margin: 0px auto;
        font-size: 25px;
    }

    .lead__btns {
        margin: 25px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
    }

    .section__suptext {
        text-indent: 2em;
        font-size: 20px;
    }

</style>

@section('content')
    <div class="container py-4 home-hero lead__wrapper">
        <h1 class="lead__text">Аналитическая лаборатория проверки гипотез</h1>
        @auth
            <p class="lead">Рады, что вы с нами, {{ Auth::user()->name }}. Формулируйте задачу и получайте аналитический ответ на основе обезличенных транзакций платёжной системы «Мир».</p>
        @else
            <p class="lead__suptext">Подключитесь к сервису, чтобы валидировать бизнес-гипотезы и управленческие решения на основании обезличенных транзакций по всей стране.</p>
            <div class="lead__btns">
                <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Войти</a>
            </div>
        @endauth
    </div>

    <div class="container py-4 home-hero lead__wrapper_2">
        <div class="banner mt-5">
            <div class="banner__info">
                <h2 class="info__title">Данные, которые отвечают на ваши вопросы</h2>
                <p class="info__suptitle">Фокус на реальных транзакциях, готовых к анализу для государства, банков и бизнеса.</p>
            </div>
            <div class="banner__image">
                <img src="{{ asset('img/data_image.png') }}" alt="Цифровые сервисы">
            </div>
        </div>
    </div>



<section class="home-section bg-light py-5" id="about">
    <div class="container">
        <!-- Заголовок сверху по центру -->
        <div class="text-center mb-4">
            <h2 class="section-title mb-2">О проекте</h2>
            <div class="title-accent mx-auto"></div>
        </div>

        <!-- Контент: слева гифка, справа текст -->
        <div class="row align-items-center g-4 about-grid">
            <div class="col-lg-5">
                <figure class="about-media m-0">
                    <img 
                        src="{{ asset('img/video_data.gif') }}" 
                        class="img-fluid rounded-3 shadow-sm about-image"
                        alt="Цифровые сервисы" 
                        loading="lazy">
                    <figcaption class="visually-hidden">Анимация обработки данных</figcaption>
                </figure>
            </div>

            <div class="col-lg-7">
                <div class="about-text card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-md-5">
<ul class="about-list ps-3">
    <li>Помогаем принимать точные решения на основе анализа реальных данных и рыночных тенденций.</li>
    <li>Формируем аналитические отчёты по запросу — без необходимости собирать данные вручную.</li>
    <li>Преобразуем массивы данных в ясные инсайты, снижая риски и экономя ваше время.</li>
</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Общий тон */
#about {
  --about-accent: rgb(233, 61, 61); /* bootstrap primary */
  --about-muted: rgba(0,0,0,.6);
}

/* Заголовок и акцентная линия */
#about .section-title {
  font-weight: 700;
  letter-spacing: .2px;
}
#about .title-accent {
  width: clamp(72px, 8vw, 120px);
  height: 4px;
  background: linear-gradient(90deg, var(--about-accent), rgb(233, 61, 61));
  border-radius: 999px;
}

/* Изображение: аккуратные углы и контроль размера */
#about .about-media {
  position: relative;
}
#about .about-image {
  display: block;
  width: 100%;
  max-width: 560px;      /* чтобы гифка смотрелась опрятно на больших экранах */
  margin-inline: auto;
  object-fit: cover;
}

/* Карточка с текстом: комфортная читабельность */
#about .about-text .card-body {
  line-height: 1.65;
  font-size: 1rem;
  color: var(--about-muted);
}
#about .about-text .section__suptext + .section__suptext {
  text-indent: 0;        /* на случай, если где-то включали text-indent */
}

/* Сетка: вертикальный ритм и отступы */
#about .about-grid {
  row-gap: 2rem;
}

.about-list {
  list-style: none;
  padding-left: 0;
  margin: 0;
}
.about-list li {
  position: relative;
  margin-bottom: 1rem;
  line-height: 1.6;
  padding-left: 2rem;
  color: rgba(0,0,0,.7);
  font-size: 22px;
}
.about-list li::before {
  content: "▹";
  color: rgb(233, 61, 61);
  position: absolute;
  left: 0;
  font-size: 1.2rem;
  line-height: 1.2;
  top: 2px;
}


/* Адаптивные улучшения */
@media (min-width: 992px) {
  #about .about-text .card-body {
    font-size: 1.05rem;
  }
}
@media (max-width: 991.98px) {
  /* На планшетах и ниже — увеличим внешнее дыхание секции */
  #about { padding-top: 3rem; padding-bottom: 3rem; }
}
@media (max-width: 575.98px) {
  /* На мобильных — слегка уменьшим тени и скругления, чтобы не «тяжелило» */
  #about .about-image { border-radius: .6rem !important; }
  #about .about-text { box-shadow: 0 .25rem 1rem rgba(0,0,0,.06) !important; }
}
</style>

    <section class="home-section py-5" id="how-it-works">
        <div class="container">
            <h2 class="section-title text-center mb-4">Демогипотезы. Примеры отчётов.</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <a class="hypothesis-card h-100 text-reset text-decoration-none" href="{{ route('pages.for-business') }}">
                        <div class="hypothesis-card__top">
                            <span class="hypothesis-card__icon hypothesis-card__icon--business" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 20h16M6 20V8h4v12M12 20v-7h4v7M18 20v-4h2M4 20v-5h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="badge rounded-pill text-bg-primary hypothesis-card__badge">Бизнес</span>
                        </div>
                        <h3 class="hypothesis-card__title">Интересы бизнеса</h3>
                        <p class="hypothesis-card__text">Оцените поток платежей по выбранной категории в заданном районе и узнайте, хватит ли спроса.</p>
                        <span class="hypothesis-card__cta">
                            Перейти
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                <path d="M7 5l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a class="hypothesis-card h-100 text-reset text-decoration-none" href="{{ route('pages.for-government') }}">
                        <div class="hypothesis-card__top">
                            <span class="hypothesis-card__icon hypothesis-card__icon--government" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 3l7 3v5c0 4.9-3.1 9-7 10-3.9-1-7-5.1-7-10V6l7-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    <path d="M9 12h6M9 15h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </span>
                            <span class="badge rounded-pill text-bg-success hypothesis-card__badge">Федеральные органы</span>
                        </div>
                        <h3 class="hypothesis-card__title">Интересы федеральных органов</h3>
                        <p class="hypothesis-card__text">Сравните динамику расходов до и после внедрения инициативы, чтобы подтвердить результат.</p>
                        <span class="hypothesis-card__cta">
                            Перейти
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                <path d="M7 5l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a class="hypothesis-card h-100 text-reset text-decoration-none" href="{{ route('pages.for-banks') }}">
                        <div class="hypothesis-card__top">
                            <span class="hypothesis-card__icon hypothesis-card__icon--bank" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 9h16M6 9V7l6-4 6 4v2M6 20h12M6 20v-8h12v8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 14h2v3H9zM13 14h2v3h-2z" fill="currentColor" />
                                </svg>
                            </span>
                            <span class="badge rounded-pill text-bg-info hypothesis-card__badge">Банк</span>
                        </div>
                        <h3 class="hypothesis-card__title">Интересы для банков</h3>
                        <p class="hypothesis-card__text">Изучите ключевые сегменты не только своих клиентов, но и клиентов других банков, повышая свою конкурентоспособность.</p>
                        <span class="hypothesis-card__cta">
                            Перейти
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                <path d="M7 5l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </section>
<section class="home-section bg-light py-5" id="hypotheses">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between mb-5">
            <h2 class="section-title mb-3 mb-lg-0">Как задать гипотезу?</h2>
            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2">Проверить свою гипотезу</a>
        </div>

        <!-- Верхний ряд -->
        <div class="row justify-content-center align-items-center g-4 position-relative">
            <!-- 1 -->
            <div class="col-12 col-md-4 position-relative">
                <div class="step-card text-center">
                    <div class="step-number">1</div>
                    <h5>Авторизация</h5>
                    <p>Войдите или зарегистрируйтесь, чтобы начать работу с гипотезами и отчётами.</p>
                </div>
                <div class="arrow-right d-none d-md-block"></div>
            </div>

            <!-- 2 -->
            <div class="col-12 col-md-4 position-relative">
                <div class="step-card text-center">
                    <div class="step-number">2</div>
                    <h5>Раздел «Задать гипотезу»</h5>
                    <p>Перейдите в нужный раздел, чтобы описать продукт и сформулировать гипотезу.</p>
                </div>
                <div class="arrow-right d-none d-md-block"></div>
            </div>

            <!-- 3 -->
            <div class="col-12 col-md-4">
                <div class="step-card text-center">
                    <div class="step-number">3</div>
                    <h5>Помощь искусственного интеллекта</h5>
                    <p>AI подберёт MCC-код и поможет уточнить формулировку для аналитики.</p>
                </div>
            </div>
        </div>

        <!-- Нижний ряд -->
        <div class="row justify-content-center align-items-center mt-5 g-4 position-relative">
            <!-- 4 -->
            <div class="col-12 col-md-4 position-relative">
                <div class="step-card text-center">
                    <div class="step-number">4</div>
                    <h5>Оплата гипотезы</h5>
                    <p>Оплатите гипотезу — система запустит автоматический анализ данных.</p>
                </div>
                <div class="arrow-right d-none d-md-block"></div>
            </div>

            <!-- 5 -->
            <div class="col-12 col-md-4">
                <div class="step-card text-center">
                    <div class="step-number">5</div>
                    <h5>Получение отчёта</h5>
                    <p>В течение часа отчёт появится в личном кабинете. Все гипотезы сохраняются.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .step-card {
        background: #fff;
        border-radius: 14px;
        padding: 2rem 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
        max-width: 320px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 22px rgba(0,0,0,0.08);
    }

    .step-number {
        background: var(--bs-primary);
        color: #fff;
        width: 52px;
        height: 52px;
        line-height: 52px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 1.3rem;
        margin: 0 auto 12px;
    }

    .step-card h5 {
        font-weight: 600;
        font-size: 1.15rem;
        margin-bottom: 10px;
    }

    .step-card p {
        color: #555;
        font-size: 1rem;
        line-height: 1.55;
    }

    /* Стрелка между карточками */
/* центрируем стрелку ровно между колонками */
.arrow-right{
    --arrow-w: 22px; /* ширина треугольника (border-left) */
    position: absolute;
    top: 50%;
    /* 100% = правая граница текущей колонки
       var(--bs-gutter-x)/2 = половина расстояния между колонками
       - var(--arrow-w) = чтобы кончик стрелки оказался в центре */
    left: calc(100% + (var(--bs-gutter-x, 1.5rem) / 2) - var(--arrow-w));
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-top: 12px solid transparent;
    border-bottom: 12px solid transparent;
    border-left: var(--arrow-w) solid var(--bs-primary);
    opacity: .85;
    animation: arrowPulse 2s infinite ease-in-out;
    z-index: 1;
    pointer-events: none;
}


    @keyframes arrowPulse {
        0%, 100% { opacity: 0.6; transform: translateY(-50%) scale(1); }
        50% { opacity: 1; transform: translateY(-50%) scale(1.15); }
    }

    @media (max-width: 991px) {
        .arrow-right {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        .step-card {
            padding: 1.5rem;
            max-width: 100%;
        }
        .step-card h5 {
            font-size: 1.05rem;
        }
        .step-card p {
            font-size: 0.95rem;
        }
        .step-number {
            width: 44px;
            height: 44px;
            line-height: 44px;
            font-size: 1.1rem;
        }
    }
</style>


<section class="home-section py-5 bg-white" id="pricing">
  <div class="container">

    <!-- Заголовок -->
    <div class="text-center mb-4">
      <h2 class="section-title mb-2">Цены</h2>
      <p class="text-muted lead mb-2">
        Оплачивайте каждую гипотезу отдельно — гибко, прозрачно и без лишних подписок.
      </p>
      <div class="title-accent mx-auto"></div>
    </div>

    <!-- Основной текст -->
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card border-0 shadow-sm p-4 p-md-5">
          <p class="mb-4">
            Мы используем модель оплаты <strong>«за гипотезу»</strong> — стоимость формируется индивидуально и зависит от масштабов исследования, выбранного периода и сложности аналитики. Цена фиксируется до старта проекта, никаких скрытых расходов.
          </p>

          <div class="row g-4">
            <!-- География -->
            <div class="col-md-4">
              <div class="factor-box d-flex flex-column align-items-start">
                <div class="factor-icon mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="rgb(233, 61, 61)" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                  </svg>
                </div>
                <h6 class="mb-1">Ширина географии</h6>
                <p class="mb-0 text-muted">От города до всей страны — чем шире охват, тем больше данных и глубже аналитика.</p>
              </div>
            </div>

            <!-- Временной промежуток -->
            <div class="col-md-4">
              <div class="factor-box d-flex flex-column align-items-start">
                <div class="factor-icon mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="rgb(233, 61, 61)" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 17H5V8h14v12zM7 10h5v5H7z"/>
                  </svg>
                </div>
                <h6 class="mb-1">Временной промежуток</h6>
                <p class="mb-0 text-muted">Неделя, квартал или год — длительность влияет на глубину отчёта и детализацию выводов.</p>
              </div>
            </div>

            <!-- Сложность гипотезы -->
            <div class="col-md-4">
              <div class="factor-box d-flex flex-column align-items-start">
                <div class="factor-icon mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="rgb(233, 61, 61)" viewBox="0 0 24 24">
                    <path d="M19.43 12.98l.04-.32c.04-.32.04-.64.04-.98s0-.66-.04-.98l-2.11-.33a5.97 5.97 0 0 0-.49-1.18l1.26-1.72a8.13 8.13 0 0 0-1.5-1.5l-1.72 1.26a5.97 5.97 0 0 0-1.18-.49L13.32 4.6A8.205 8.205 0 0 0 12 4.56c-.34 0-.66.01-.98.04l-.33 2.11c-.42.12-.82.29-1.18.49L7.79 5.94a8.13 8.13 0 0 0-1.5 1.5l1.26 1.72c-.2.36-.37.76-.49 1.18L4.6 10.68A8.205 8.205 0 0 0 4.56 12c0 .34.01.66.04.98l2.11.33c.12.42.29.82.49 1.18l-1.26 1.72a8.13 8.13 0 0 0 1.5 1.5l1.72-1.26c.36.2.76.37 1.18.49l.33 2.11c.32.03.64.04.98.04s.66-.01.98-.04l.33-2.11c.42-.12.82-.29 1.18-.49l1.72 1.26a8.13 8.13 0 0 0 1.5-1.5l-1.26-1.72c.2-.36.37-.76.49-1.18l2.11-.33zM12 15a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                  </svg>
                </div>
                <h6 class="mb-1">Сложность гипотезы</h6>
                <p class="mb-0 text-muted">Количество параметров, фильтров и метрик определяет глубину расчёта и итоговую цену.</p>
              </div>
            </div>
          </div>

          <div class="mt-4 d-flex flex-column flex-sm-row gap-2">
            <a href="{{ route('hypothesis.create') ?? '#' }}" class="btn btn-primary btn-lg">Проверить гипотезу</a>
            <a href="#about" class="btn btn-outline-secondary btn-lg">Подробнее о проекте</a>
          </div>
        </div>
      </div>
    </div>

    <div class="text-muted small mt-3">
      * Стоимость рассчитывается индивидуально и фиксируется до начала анализа.
    </div>
  </div>
</section>

<style>
#pricing { --accent: rgb(233, 61, 61); }
#pricing .section-title { font-weight: 700; letter-spacing: .2px; }
#pricing .title-accent { width: clamp(72px, 8vw, 120px); height: 4px; background: linear-gradient(90deg, var(--accent), rgb(233, 61, 61)); border-radius: 999px; }

.factor-box {
  border: 1px solid rgba(233, 61, 61,.12);
  border-radius: .75rem;
  padding: 1.25rem;
  background: linear-gradient(180deg, rgba(233, 61, 61,.04), transparent 70%);
  transition: all .25s ease;
}
.factor-box:hover {
  box-shadow: 0 .5rem 1rem rgba(233, 61, 61,.15);
  transform: translateY(-3px);
}
.factor-icon svg { flex-shrink: 0; }

@media (max-width: 575.98px) {
  #pricing .card { padding: 1.5rem !important; }
  .factor-box { text-align: center; align-items: center !important; }
}
</style>

@endsection

