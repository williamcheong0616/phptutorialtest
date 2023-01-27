<?php
  if(!empty($_POST))
  {
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


    if(empty($_POST['terms']))
    {
      $errors['terms'] = 'You must agree to the terms and conditions';
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

      redirect('login');


    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="William Cheong">
    <meta name="generator" content="William">
    <title>My Blog</title>

    <link href="<?=ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
    <link href="<?=ROOT?>/assets/css/sign-in.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin w-100 m-auto">
  <form method="post">
  <a href="home">
    <img class="mb-4 rounded-circle shadow" src="<?=ROOT?>/assets/images/grcxlk13.bmp" alt="" width="120" height="120">
    </a>
    <h1 class="h3 mb-3 fw-normal">Create An Account!</h1>
    <?php if(!empty($errors)):?>
      <div class="alert alert-danger">Please fix the error below</div>
      <?php endif;?>
    <div class="form-floating">
      <input name="username" value="<?=old_value('username')?>" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
      <label for="floatingInput">Username</label>
    </div>
    <?php if(!empty($errors['username'])):?>
    <div class="text-danger"><?=$errors['username']?></div>
    <?php endif;?>
    <div class="form-floating">
      <input name="email" value="<?=old_value('email')?>" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <?php if(!empty($errors['email'])):?>
    <div class="text-danger"><?=$errors['email']?></div>
    <?php endif;?>
    <div class="form-floating">
      <input name="password" value="<?=old_value('password')?>" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <?php if(!empty($errors['password'])):?>
    <div class="text-danger"><?=$errors['password']?></div>
    <?php endif;?>
    <div class="form-floating">
      <input name="password2" value="<?=old_value('password2')?>" type="password" class="form-control" id="floatingPassword" placeholder="password2">
      <label for="floatingPassword">Retype Password</label>
    </div>
    <?php if(!empty($errors['password2'])):?>
    <div class="text-danger"><?=$errors['password2']?></div>
    <?php endif;?>

    <div class="checkbox mb-3">
    <div class="my-2">Already have an account? <a href="<?=ROOT?>/login">Login here!</a></div>
      <label>
        <input <?=old_checked('terms')?> value="terms" name="terms" type="checkbox" > You accept to join our page
      </label>
    </div>
    <?php if(!empty($errors['terms'])):?>
    <div class="text-danger"><?=$errors['terms']?></div>
    <?php endif;?>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2023 <?php echo date("M") ?> </p>
  </form>
</main>


    
  </body>
</html>
