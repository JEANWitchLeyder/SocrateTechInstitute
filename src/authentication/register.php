<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../bootstrap/init.php';
require_once __DIR__ . '/../Core/helpers.php';
require_once __DIR__ . '/../Controller/AuthController.php';

use Controller\AuthController;

$controller = new AuthController();
$result = null;

if (is_post_data()) {
    $result = $controller->register_control();
}

require_once __DIR__ . '/../Core/partials/linkheader.php';
require_once __DIR__ . '/../Core/partials/header.php';
?>

?>



<div class="register-container-overlay-bg">
  <div class="regislog-container">
    <div class="regislog-left">
    <a href="index.html">
                <img src="assets/images/others/logowhite.png" alt="Socrate Tech Institute">
            </a>
      <h1>Register</h1>
    </div>

    <div class="regislog-right">
      <div class="closing-icon">
        <i class="fa-solid fa-xmark"></i>
      </div>

      <form action="" enctype="multipart/form-data" method="POST" id="formID">
      <?php if (is_array($result) && isset($result['error'])): ?>
    <div class="error-message">
        <p style="color:red;">
            <?= htmlspecialchars($result['error']) ?>
        </p>
    </div>
<?php endif; ?>


        <input
          type="text"
          placeholder="Nom d'utilisateur: "
          class="username"
          name="username"
          value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
        >

        <input
          type="email"
          placeholder="Votre Email: "
          class="email"
          name="email"
          value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
        >

        <input
          type="password"
          placeholder="Votre Mot-de-Passe: "
          name="password"
          class="password"
        >

        <input
          type="password"
          name="password_confirm"
          placeholder="Confirmer votre Mot-de-passe: "
          class="password_confirm"
        >

        <select name="role" id="role">
          <option value="parent">Parent</option>
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
          <option value="admin">Admin</option>
        </select>

        <p><span>Ou</span><br>Enregistrer avec les réseaux sociaux</p>

        <div class="social-media">
          <span class="social-icon"><i class="fab fa-google"></i></span>
          <span class="social-icon"><i class="fab fa-facebook"></i></span>
          <span class="social-icon"><i class="fab fa-github"></i></span>
          <span class="social-icon"><i class="fas fa-link"></i></span>
        </div>

        <button
          class="contact button button-register"
          type="submit"
          name="register_submit"
          style="color: white !important;"
        >
          Enregistrer
        </button>
      </form>

     
    </div>
  </div>
</div>

<?php
require_once __DIR__ . '/../Core/partials/footer.php';
?>
