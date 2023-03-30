<?php

include '../app/pages/includes/header.php';

?>

<?php

$section = $url[1] ?? 'dashboard';
$action = $url[2] ?? 'view';
$id = $url[3] ?? 0;

$filename = "../app/pages/profile/" . $section . ".php";

if (!file_exists($filename)) {
  $filename = "../app/pages/admin/404.php";
}

?>


<div class="container-fluid">
  <div class="row">
    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
      aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list"></i>
      <span class="navbar-toggler-icon"></span>
    </button>
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?= $section == 'profile_page' ? 'active' : '' ?>" aria-current="page"
              href="<?= ROOT ?>/profile/profile_page">
              <i class="bi bi-person"></i>
              Profile
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $section == 'settings' ? 'active' : '' ?>" aria-current="page"
              href="<?= ROOT ?>/profile/settings">
              <i class="bi bi-gear"></i>
              Settings
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $section == 'ticket_transaction' ? 'active' : '' ?>" aria-current="page"
              href="<?= ROOT ?>/profile/ticket_transaction">
              <i class="bi bi-ticket-detailed"></i>
              Tickets
            </a>
          </li>
        </ul>
      </div>


    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Profile</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
      </div>

      <?php

      require_once $filename;

      ?>

      <?php


      if ($section == 'profile_page') {
        require_once "../app/pages/profile/profile_page.php";
      } elseif ($section == 'settings') {
        require_once "../app/pages/profile/settings.php";
      } elseif ($section == 'ticket_transaction') {
        require_once "../app/pages/profile/ticket_transaction.php";
      }

      ?>



      <?php

      include '../app/pages/includes/footer.php';


      ?>