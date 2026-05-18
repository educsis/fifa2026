<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Quiniela FIFA 2026</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="app-shell">
    <div class="page-shell">
        <main class="page-section">
            <section class="section-surface">
                <div class="hero-brand">
                    <img src="https://www.evoluteinc.com/wp-content/uploads/2026/01/logo-sticky.svg" alt="Evolute Inc" loading="lazy" />
                    <span class="section-tag">Quiniela FIFA 2026</span>
                </div>
                <h1 class="section-title">Bienvenido al sistema de pronósticos</h1>
                <p class="section-copy">Accede al ranking, registra tus resultados y compite con tu equipo de forma rápida y segura.</p>
                <div class="hero-actions">
                    <a href="<?= site_url('auth/login') ?>" class="button-primary">Iniciar sesión</a>
                    <a href="<?= site_url('auth/login') ?>" class="button-secondary">Registrarse</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
