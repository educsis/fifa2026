<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-section">
    <section class="section-surface">
        <div class="section-head">
            <div>
                <span class="section-tag">Fase de grupos</span>
                <h2 class="section-title">Tus pronósticos de la primera fase</h2>
                <p class="section-copy">Completa todos los partidos antes del primer pitazo del Mundial FIFA 2026.</p>
            </div>
            <div class="progress-card">
                <span class="section-tag section-tag-soft">Progreso</span>
                <p class="stat-value"><?= $completed ?> de <?= $total_matches ?></p>
            </div>
        </div>
    </section>

    <?php foreach ($matches as $date => $group): ?>
        <section class="section-surface">
            <div class="match-date-row">
                <div>
                    <span class="section-tag section-tag-soft">Fecha</span>
                    <h3 class="section-heading"><?= format_match_date($date) ?></h3>
                </div>
                <span class="tag-pill">Horario en hora local</span>
            </div>

            <div class="match-list">
                <?php foreach ($group as $match): ?>
                    <?php $prediction = isset($predictions[$match['id']]) ? $predictions[$match['id']] : null; ?>
                    <article class="match-card">
                        <div class="match-line">
                            <div class="match-team">
                                <span class="match-flag"><?= $match['home_flag'] ?></span>
                                <div>
                                    <span class="team-label">Local</span>
                                    <p class="team-name"><?= $match['home_team'] ?></p>
                                </div>
                            </div>

                            <div class="match-score">
                                <div class="vs-row">
                                    <span class="vs-label">VS</span>
                                    <span class="match-time"><?= format_match_time($match['match_time']) ?></span>
                                </div>
                                <div class="match-score-grid">
                                    <input data-match-id="<?= $match['id'] ?>" data-side="home" type="number" min="0" value="<?= $prediction ? $prediction['home_goals'] : '' ?>" class="score-input prediction-input" <?= (int)$match['started'] === 1 ? 'disabled' : '' ?> />
                                    <span class="score-separator">-</span>
                                    <input data-match-id="<?= $match['id'] ?>" data-side="away" type="number" min="0" value="<?= $prediction ? $prediction['away_goals'] : '' ?>" class="score-input prediction-input" <?= (int)$match['started'] === 1 ? 'disabled' : '' ?> />
                                </div>
                            </div>

                            <div class="match-team match-team-reverse">
                                <div>
                                    <span class="team-label">Visitante</span>
                                    <p class="team-name"><?= $match['away_team'] ?></p>
                                </div>
                                <span class="match-flag"><?= $match['away_flag'] ?></span>
                            </div>
                        </div>

                        <div class="match-meta">
                            <span class="meta-chip">Grupo <?= $match['group_name'] ?></span>
                            <span class="meta-chip"><?= format_match_date($match['match_date']) ?> · <?= format_match_time($match['match_time']) ?></span>
                        </div>

                        <?php if ((int)$match['started'] === 1): ?>
                            <span class="tag-pill tag-pill-warning">Partido iniciado - edición bloqueada</span>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

    <div class="save-float">
        <button id="save-all" class="button-primary">Guardar Pronósticos</button>
    </div>
</div>
