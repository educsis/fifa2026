<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="section-surface">
    <div class="section-head">
        <div>
            <span class="section-tag">Ranking Mundial</span>
            <h2 class="section-title">Descubre a los líderes de la quiniela</h2>
            <p class="section-copy">El ranking general se actualiza con cada resultado real ingresado por el panel admin.</p>
        </div>
        <div class="card-surface">
            <span class="section-tag section-tag-soft">Mejor marcador exacto</span>
            <p class="stat-value">+5 puntos</p>
        </div>
    </div>
</section>

<div class="leaderboard-main">
    <section class="section-surface">
        <div class="leaderboard-list">
            <?php foreach ($leaderboard as $row): ?>
                <article class="leaderboard-card">
                    <div class="leaderboard-row">
                        <div class="leaderboard-profile">
                            <div class="leaderboard-badge"><?= $row['position'] <= 3 ? ['🥇','🥈','🥉'][$row['position'] - 1] : $row['position'] ?></div>
                            <div>
                                <p class="team-name"><?= $row['name'] ?></p>
                                <p class="team-label">Posición #<?= $row['position'] ?></p>
                            </div>
                        </div>
                        <div class="leaderboard-score">
                            <p class="stat-value"><?= $row['points'] ?></p>
                            <p class="team-label">Puntos</p>
                        </div>
                    </div>
                    <div class="stat-grid">
                        <div class="meta-chip">
                            <p class="stat-value"><?= $row['exacts'] ?></p>
                            <p class="team-label">Exactos</p>
                        </div>
                        <div class="meta-chip">
                            <p class="stat-value"><?= $row['predictions'] ?></p>
                            <p class="team-label">Pronósticos</p>
                        </div>
                        <div class="meta-chip">
                            <p class="stat-value"><?= $row['accuracy'] ?>%</p>
                            <p class="team-label">Acierto</p>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <aside class="section-surface">
        <h3 class="section-heading">Destacados</h3>
        <p class="section-copy">Los 3 mejores se llevan medallas y el orgullo mundialista del equipo.</p>
        <div class="info-grid">
            <div class="surface-card">
                <span class="section-tag section-tag-accent">Comparte</span>
                <p class="section-copy">Invita a tu equipo de trabajo a batirse en el ranking.</p>
                <br>
                <br>
                <span class="section-tag section-tag-soft">Actualización</span>
                <p class="section-copy">Los puntos reflejan resultados reales ingresados por el equipo administrativo.</p>
            </div>
        </div>
    </aside>
</div>
