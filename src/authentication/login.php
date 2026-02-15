<?php
session_start();

require_once __DIR__ . '/../../bootstrap/init.php';
require_once __DIR__ . '/../Core/helpers.php';
require_once __DIR__ . '/../Controller/AuthController.php';

use Controller\AuthController;

$login_controller = new AuthController();
$result = null;

if (is_post_data()) {
    $result = $login_controller->login_control();
}

/**
 * IMPORTANT:
 * These includes MUST come AFTER the POST logic,
 * otherwise redirect fails because HTML is output before header().
 */
require_once __DIR__ . '/../Core/partials/linkheader.php';
require_once __DIR__ . '/../Core/partials/header.php';
?>

<div class="login-container-overlay-bg">
  <div class="regislog-container">
    <div class="regislog-left">
      <a href="<?= BASE_URL ?>/index.php" class="logo-home">Socrate Tech Institute</a>
      <h2>Login</h2>

      <?php if (!empty($result['error'])): ?>
        <p class="error-message"><?= htmlspecialchars((string)$result['error']) ?></p>
      <?php endif; ?>

      <form method="post">
        <div class="input-group">
          <label>Username</label>
          <input type="text" name="username" required>
        </div>

        <div class="input-group">
          <label>Password</label>
          <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn">Login</button>
      </form>

      <p class="switch-link">
        No account? <a href="<?= BASE_URL ?>/src/authentication/register.php">Register</a>
      </p>
    </div>
  </div>
</div>
