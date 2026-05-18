<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="auth-shell">
    <div class="section-surface auth-box">
        <div class="section-head auth-head">
            <div>
                <span class="section-tag">Panel Administrativo</span>
                <h2 class="section-title">Ingresar resultados y recalcular la quiniela</h2>
                <p class="section-copy">Acceso seguro para actualizar la tabla de posiciones en tiempo real.</p>
            </div>
        </div>

        <?= form_open('admin/authenticate', ['class' => 'auth-form']) ?>
            <div class="form-group">
                <label for="username" class="form-label">Usuario</label>
                <input id="username" name="username" type="text" class="form-input" placeholder="admin" />
                <?php if (!empty($errors['username'])): ?>
                    <p class="error-text"><?= $errors['username'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" name="password" type="password" class="form-input" placeholder="••••••••" />
                <?php if (!empty($errors['password'])): ?>
                    <p class="error-text"><?= $errors['password'] ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="button-primary">Acceder al panel</button>
        <?= form_close() ?>
    </div>
</div>
