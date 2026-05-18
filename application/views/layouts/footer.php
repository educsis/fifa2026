<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    </main>
    <footer class="site-footer">
        <div class="footer-panel footer-brand">
            <img src="<?= base_url('assets/images/logo-sticky.png') ?>" alt="Evolute Inc logo" loading="lazy" />
        </div>
    </footer>
</div>
<div id="toast-container" class="toast-container"></div>
<?php if ($this->session->flashdata('score_reminder')): ?>
<script>
  window.LOGIN_SCORE_REMINDER = <?= json_encode($this->session->flashdata('score_reminder')) ?>;
</script>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
