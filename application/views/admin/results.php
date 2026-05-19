<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-section">
    <section class="section-surface">
        <div class="section-head">
            <div>
                <span class="section-tag">Resultados oficiales</span>
                <h2 class="section-title">Actualiza los marcadores reales</h2>
                <p class="section-copy">Cada resultado que ingreses se reflejará automáticamente en el leaderboard y en las estadísticas de la quiniela.</p>
            </div>
            <div class="row">
                <a href="<?= site_url('admin/dashboard') ?>" class="button-secondary">Volver al panel</a>
                <button type="submit" form="admin-results-form" class="button-primary">Guardar resultados</button>
            </div>
        </div>
    </section>

    <form id="admin-results-form" action="<?= site_url('admin/save-results') ?>" method="post" class="result-form">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
        <?php foreach ($matches as $match): ?>
            <?php $result = isset($results[$match['id']]) ? $results[$match['id']] : null; ?>
            <article class="result-card">
                <div class="match-result-grid">
                    <div>
                        <span class="team-label">Grupo <?= $match['group_name'] ?></span>
                        <p class="team-name"><span class="fi fi-<?= $match['home_flag'] ?>"></span> <?= $match['home_team'] ?> vs <?= $match['away_team'] ?> <span class="fi fi-<?= $match['away_flag'] ?>"></span></p>
                        <p class="section-copy"><?= format_match_date($match['match_date']) ?> · <?= format_match_time($match['match_time']) ?></p>
                    </div>
                    <div class="input-pair">
                        <div>
                            <label class="form-label">Local</label>
                            <input name="match[<?= $match['id'] ?>][home]" type="number" min="0" value="<?= $result ? $result['home_score'] : '' ?>" class="form-input" />
                        </div>
                        <div>
                            <label class="form-label">Visitante</label>
                            <input name="match[<?= $match['id'] ?>][away]" type="number" min="0" value="<?= $result ? $result['away_score'] : '' ?>" class="form-input" />
                        </div>
                    </div>
                    <div class="result-action">
                        <span class="tag-pill">Editar resultado</span>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>

        <button type="submit" class="button-primary">Guardar resultados</button>
    <?= form_close() ?>
</div>
