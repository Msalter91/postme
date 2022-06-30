<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= URLROOT ?>"><?= SITENAME ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link"  href="<?= URLROOT ?>">Home</a>
        </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= URLROOT ?>/pages/about">About</a>
          </li>
      </ul>
    </div>
      <?php if(!isset($_SESSION['user_id'])) : ?>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link" href="<?= URLROOT ?>/users/login">Login</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="<?= URLROOT ?>/users/register">Register</a>
              </li>
          </ul>
      </div>
      <?php else: ?>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                      <a class="nav-link" href="<?= URLROOT ?>/users/logout">Logout</a>
                  </li>
              </ul>
          </div>
      <?php endif; ?>

  </div>
</nav>
