<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="rules-grid">
    <section class="section-surface section-hero">
        <div class="section-head">
            <div>
                <span class="section-tag"><?= lang('rules_section_tag') ?></span>
                <h2 class="section-title"><?= lang('rules_section_title') ?></h2>
                <p class="section-copy"><?= lang('rules_section_copy') ?></p>
            </div>
        </div>

        <div class="stats-grid">
            <article class="card-surface">
                <span class="section-tag section-tag-accent"><?= lang('rules_exact_tag') ?></span>
                <p class="stat-value"><?= lang('rules_exact_points') ?></p>
                <p class="section-copy"><?= lang('rules_exact_desc') ?></p>
            </article>
            <article class="card-surface">
                <span class="section-tag section-tag-warning"><?= lang('rules_correct_tag') ?></span>
                <p class="stat-value"><?= lang('rules_correct_points') ?></p>
                <p class="section-copy"><?= lang('rules_correct_desc') ?></p>
            </article>
            <article class="card-surface">
                <span class="section-tag section-tag-danger"><?= lang('rules_wrong_tag') ?></span>
                <p class="stat-value"><?= lang('rules_wrong_points') ?></p>
                <p class="section-copy"><?= lang('rules_wrong_desc') ?></p>
            </article>
            <article class="card-surface">
                <span class="section-tag section-tag-accent"><?= lang('rules_ranking_tag') ?></span>
                <p class="stat-value"><?= lang('rules_ranking_points') ?></p>
                <p class="section-copy"><?= lang('rules_ranking_desc') ?></p>
            </article>
        </div>
    </section>

    <aside class="section-surface aside-panel">
        <h3 class="section-heading"><?= lang('rules_example_title') ?></h3>
        <div class="info-grid">
            <div class="surface-card">
                <p><?= lang('rules_example_match1') ?></p>
                <p class="section-copy"><?= lang('rules_example_exact') ?></p>
            </div>
            <div class="surface-card">
                <p><?= lang('rules_example_match2') ?></p>
                <p class="section-copy"><?= lang('rules_example_correct') ?></p>
            </div>
            <div class="surface-card">
                <p><?= lang('rules_example_match3') ?></p>
                <p class="section-copy"><?= lang('rules_example_wrong') ?></p>
            </div>
        </div>
        <a href="<?= site_url('pronosticos') ?>" class="button-primary"><?= lang('rules_start_button') ?></a>
    </aside>
</div>
