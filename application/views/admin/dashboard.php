<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-section">
    <section class="section-surface">
        <div class="section-head">
            <div>
                <span class="section-tag">Bienvenido, admin</span>
                <h2 class="section-title">Panel operativo de la quiniela</h2>
                <p class="section-copy">Gestiona resultados reales y mantiene el leaderboard preciso para todos los participantes.</p>
            </div>
            <a href="<?= site_url('admin/results') ?>" class="button-primary">Editar Resultados</a>
        </div>
    </section>

    <div class="stats-grid stats-grid-3">
        <article class="card-surface">
            <span class="team-label">Usuarios registrados</span>
            <p class="stat-value"><?= $users_count ?></p>
        </article>
        <article class="card-surface">
            <span class="team-label">Partidos cargados</span>
            <p class="stat-value"><?= $matches_count ?></p>
        </article>
        <article class="card-surface">
            <span class="team-label">Resultados ingresados</span>
            <p class="stat-value"><?= $results_count ?></p>
        </article>
    </div>

    <section class="section-surface">
        <h3 class="section-heading">Top 5 del ranking</h3>
        <div class="card-grid">
            <?php foreach ($top_users as $user): ?>
                <article class="card-surface">
                    <div class="leaderboard-row">
                        <div>
                            <p class="team-name"><?= $user['name'] ?></p>
                            <p class="team-label">Posición #<?= $user['position'] ?></p>
                        </div>
                        <div class="leaderboard-score">
                            <p class="stat-value"><?= $user['points'] ?></p>
                            <p class="team-label">Puntos</p>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</div>
