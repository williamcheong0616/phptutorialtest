<?php

      if(!logged_in()){
        redirect('login');
      }

              
      $section = $url[1] ?? 'dashboard';
      $action  = $url[2] ?? 'view';
      $filename = "../app/pages/admin/".$section.".php";
      if(file_exists($filename)){
        require_once $filename;
      }else{
        $filename = "../app/pages/admin/404.php";
      }

      if(!empty($_POST))
      {
                 if($action == 'add'){

                  //validate
                    $errors = [];
                    
                    //validate username
                
                    if(empty($_POST['username']))
                    {
                      $errors['username'] = 'Username is required';
                    }
                    elseif(preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']) == 0)
                    {
                      $errors['username'] = 'Username can only contain letters and numbers';
                    }
                
                    //validate email
                
                    if(empty($_POST['email']))
                    {
                      $errors['email'] = 'Email is required';
                    }
                    elseif(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)
                    {
                      $errors['email'] = 'Email is invalid';
                    }
                    else
                    {
                      $query = "select * from users where email = :email";
                      $data = ['email' => $_POST['email']];
                      $result = query($query, $data);
                      if($result)
                      {
                        $errors['email'] = 'Email is already taken';
                      }
                    }
                    //validate password
                    if(empty($_POST['password']))
                    {
                      $errors['password'] = 'Password is required';
                    }
                    elseif(strlen($_POST['password']) < 8)
                    {
                      $errors['password'] = 'Password must be at least 8 characters or more';
                    }
                
                    //validate confirm password
                    if(empty($_POST['password2']))
                    {
                      $errors['password2'] = 'Confirm password is required';
                    }
                      elseif($_POST['password'] != $_POST['password2'])
                    {
                      $errors['password2'] = 'Password does not match';
                    }

                    if(empty($errors))
                    {
                      //save to database
                      $data = [];
                      $data['username'] = $_POST['username'];
                      $data['email'] = $_POST['email'];
                      $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                      $data['role'] = 'user';
                
                      $query = "insert into users (username, email, password, role) values (:username, :email, :password, :role)";
                      query($query, $data);
                
                      redirect('admin/users');
                
                
                    }
                  }

      }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>AdminHub - MyBlog</title>

<link href="<?=ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=ROOT?>/assets/css/bootstrap-icons.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?=ROOT?>/assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="<?=ROOT?>/admin">Company name</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="<?=ROOT?>/logout">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?=ROOT?>/admin">
            <i class="bi bi-speedometer"></i>
                Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?=ROOT?>/admin/users">
            <i class="bi bi-person"></i>
                Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?=ROOT?>/admin/categories">
            <i class="bi bi-tags"></i>
                Categories
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?=ROOT?>/admin/posts">
            <i class="bi bi-file-post"></i>
                Posts
            </a>
          </li>


        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span>Drafts</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle" class="align-text-bottom"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text" class="align-text-bottom"></span>
            <i class="bi-globe"></i>
              Current month
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
          </button>
        </div>
      </div>

      <?php
        require_once $filename;
      ?>

    </main>

      <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="assets/js/dashboard.js"></script>

   </body>
</html>
