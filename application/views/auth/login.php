<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="auth-grid">
    <section class="hero-panel">
        <p class="eyebrow"><?= lang('auth_welcome') ?></p>
        <h2 class="section-title"><?= lang('auth_description') ?></h2>

        <div class="info-grid">
            <img src="<?= base_url('assets/images/fifa2026.jpg') ?>" alt="Ilustración de fútbol" class="info-image" loading="lazy" />
        </div>

        <div class="info-card info-card-spaced">
         
            
            <div id="countdown" data-target="2026-06-10T00:00:00">Cargando cuenta regresiva...</div>
        </div>
    </section>

    <section class="auth-panel">
        <div class="auth-card">
            <h3 class="section-title"><?= lang('auth_register_title') ?></h3>
            <p class="section-subtitle"><?= lang('auth_register_subtitle') ?></p>
            
            <?= form_open('auth/register_submit') ?>
                <div class="form-group">
                    <label for="name" class="form-label"><?= lang('auth_name_label') ?></label>
                    <input id="name" name="name" value="<?= set_value('name') ?>" type="text" autocomplete="name" class="form-input" placeholder="Tu nombre completo" />
                    <?php if (!empty($register_errors['name'])): ?>
                        <p class="error-text"><?= $register_errors['name'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label"><?= lang('auth_email_label') ?></label>
                    <input id="email" name="email" value="<?= set_value('email') ?>" type="email" autocomplete="email" class="form-input" placeholder="usuario@evoluteinc.com" />
                    <?php if (!empty($register_errors['email'])): ?>
                        <p class="error-text"><?= $register_errors['email'] ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="button-primary"><?= lang('auth_submit_register') ?></button>
            <?= form_close() ?>
        </div>

        <div class="auth-card">
            <h3 class="section-title"><?= lang('auth_login_title') ?></h3>
            <p class="section-subtitle"><?= lang('auth_login_subtitle') ?></p>

            <?= form_open('auth/login_submit') ?>
                <div class="form-group">
                    <label for="login_email" class="form-label"><?= lang('auth_email_label') ?></label>
                    <input id="login_email" name="email" value="<?= set_value('email') ?>" type="email" autocomplete="email" class="form-input" placeholder="usuario@evoluteinc.com" />
                    <?php if (!empty($login_errors['email'])): ?>
                        <p class="error-text"><?= $login_errors['email'] ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="button-primary"><?= lang('auth_submit_login') ?></button>
            <?= form_close() ?>
        </div>
    </section>
</div>
