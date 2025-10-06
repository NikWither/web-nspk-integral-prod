@php
    $labels = [
        'government' => 'Госорган',
        'business' => 'Бизнес',
        'bank' => 'Банк',
    ];

    $label = $labels[$type] ?? 'Не указан';
@endphp

<span class="badge bg-secondary">{{ $label }}</span>
