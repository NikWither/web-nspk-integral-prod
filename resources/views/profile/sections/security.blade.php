<h2 class="section-title">Безопасность</h2>
<p class="text-muted">Следите за безопасностью аккаунта: регулярно обновляйте пароль и проверяйте активные сессии.</p>
<ul class="list-unstyled">
    <li class="mb-2">• Пароль можно изменить через форму восстановления (реализуйте позднее).</li>
    <li class="mb-2">• Включите двухфакторную аутентификацию, если платформа будет её поддерживать.</li>
    <li class="mb-0">• Последний вход: <span class="fw-semibold">{{ $user->updated_at?->format('d.m.Y H:i') ?? '—' }}</span></li>
</ul>
<button class="btn btn-outline-secondary mt-3" type="button" disabled>Настроить безопасность</button>
