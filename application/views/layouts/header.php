<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="<?= $this->session->userdata('site_lang') === 'en' ? 'en' : 'es' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token-name" content="<?= $this->security->get_csrf_token_name() ?>">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <title><?= isset($page_title) ? $page_title . ' | Quiniela FIFA 2026' : 'Quiniela FIFA 2026' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/images/logo-sticky.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <script>
        window.APP_URL = '<?= rtrim(site_url(''), '/') ?>/';
    </script>
</head>
<body class="app-shell">
<div class="page-shell">
    <?php $current_lang = $this->session->userdata('site_lang') === 'en' ? 'en' : 'es'; ?>
    <header class="page-header">
        <div class="brand-group">
            <a href="<?= site_url() ?>" class="brand-link">
                <div>
                    <img src="<?= base_url('assets/images/logo-sticky.png') ?>" alt="Evolute Inc logo" loading="lazy" />
                    <!-- <p class="brand-subtitle">Quiniela</p>
                    <h1 class="brand-title">FIFA World Cup 2026</h1> -->
                </div>
            </a>
        </div>
        <button type="button" class="nav-toggle" aria-expanded="false" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="nav-links" aria-label="Main navigation">
            <?php if(!$this->session->userdata('user_id')): ?>
                <a href="<?= site_url('reglas') ?>" class="<?= $this->uri->segment(1) === 'reglas' ? 'active' : '' ?>"><?= lang('menu_rules2') ?></a>
            <?php endif; ?>
            <?php if($this->session->userdata('user_id')): ?>
                <a href="<?= site_url('rules') ?>" class="<?= $this->uri->segment(1) === 'rules' ? 'active' : '' ?>"><?= lang('menu_rules') ?></a>
                <a href="<?= site_url('pronosticos') ?>" class="<?= $this->uri->segment(1) === 'pronosticos' ? 'active' : '' ?>"><?= lang('menu_predictions') ?></a>
                <a href="<?= site_url('leaderboard') ?>" class="<?= $this->uri->segment(1) === 'leaderboard' ? 'active' : '' ?>"><?= lang('menu_leaderboard') ?></a>
            <?php endif; ?>
            <?php if ($this->session->userdata('admin_logged_in')): ?>
                <span class="pill-chip"><?= sprintf(lang('greeting_hello'), $this->session->userdata('admin_username')) ?></span>
                <a href="<?= site_url('admin/dashboard') ?>" class="pill-button">Admin</a>
                <a href="<?= site_url('admin/logout') ?>" class="pill-button pill-light"><?= lang('menu_logout') ?></a>
            <?php elseif (!$this->session->userdata('user_id')): ?>
                <!-- <a href="<?= site_url('auth') ?>" class="pill-button"><?= lang('menu_login') ?></a> -->
                <!-- <a href="<?= site_url('auth') ?>#register" class="pill-button pill-light"><?= lang('menu_register') ?></a> -->
            <?php else: ?>
                <span class="pill-chip"><?= sprintf(lang('greeting_hello'), $this->session->userdata('user_name')) ?></span>
                <a href="<?= site_url('logout') ?>" class="pill-button pill-light"><?= lang('menu_logout') ?></a>
            <?php endif; ?>
            <span class="lang-current"><?= $current_lang === 'en' ? '🇺🇸 English' : '🇪🇸 Español' ?></span>
            <?php if ($current_lang === 'en'): ?>
                <a href="<?= site_url('language/set/es') ?>" class="lang-toggle">🇪🇸 ES</a>
            <?php else: ?>
                <a href="<?= site_url('language/set/en') ?>" class="lang-toggle">🇺🇸 EN</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="page-main">
        <?php if ($this->session->flashdata('global_alert')): ?>
            <div class="alert-banner">
                <?= $this->session->flashdata('global_alert') ?>
            </div>
        <?php endif; ?>
