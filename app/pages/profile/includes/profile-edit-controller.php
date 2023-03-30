<?php
$query = "select * from users where id = :id ";
$row = query_row($query, ['id' => $id]);

if (!empty($_POST)) {

  if ($row) {

    //validate
    $errors = [];

    if (empty($_POST['username'])) {
      $errors['username'] = 'Username is required';
    } elseif (preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']) == 0) {
      $errors['username'] = 'Username can only contain letters and numbers';
    }

    $query = "select id from users where email = :email && id != :id ";
    $email = query($query, ['email' => $_POST['email'], 'id' => $id]);

    if (empty($_POST['email'])) {
      $errors['email'] = "A email is required";
    } else
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email not valid";
      } else
        if ($email) {
          $errors['email'] = "That email is already in use";
        }

    if (empty($_POST['password'])) {

    } else
      if (strlen($_POST['password']) < 8) {
        $errors['password'] = "Password must be 8 character or more";
      }
      //validate confirm password
      elseif ($_POST['password'] != $_POST['retype_password']) {
        $errors['password2'] = 'Password does not match';
      }

    // //validate image
    // $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    // if (!empty($_FILES['image']['name'])) {
    //   $destination = "";
    //   if (!in_array($_FILES['image']['type'], $allowed)) {
    //     $errors['image'] = "File type not supported/allowed";
    //   } else {

    //     $folder = "uploads/";
    //     if (!file_exists($folder)) {
    //       mkdir($folder, 0777, true);
    //     }

    //     $destination = $folder . time() . $_FILES['image']['name'];
    //     move_uploaded_file($_FILES['image']['tmp_name'], $destination);
    //     resize_image($destination);

    //     $data['image'] = file_get_contents($destination); // or use $destination for storing file path in database
    //   }
    // }

    //validate image
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    if (!empty($_FILES['image']['name'])) {
      $destination = "";
      if (!in_array($_FILES['image']['type'], $allowed)) {
        $errors['image'] = "File type not supported/allowed";
      } else {

        $folder = "uploads/";
        if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
        }

        $destination = $folder . time() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        resize_image($destination);

        $data['image_path'] = $destination; // store file path in database

        // get file contents to send in ajax request
        $data['image'] = file_get_contents($destination);
      }
    }



    if (empty($errors)) {
      // Update user information in the database
      $data = array(
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'id' => $_SESSION['USER']['id']
      );

      if (!empty($data['image'])) {
        $image_str = ', image = :image';
      } else {
        $image_str = '';
      }

      if (!empty($_POST['password'])) {
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_str = ', password = :password';
      } else {
        $password_str = '';
      }

      $query = "UPDATE users SET username = :username, email = :email $password_str $image_str WHERE id = :id";
      $currentUserID = $_SESSION['USER']['id'];
      query($query, $data);




    }

  }
}

?>

<?php
if ($query) {
  // Update username in session and display a message
  $_SESSION['USER']['username'] = $_POST['username'];
  $_SESSION['USER']['email'] = $_POST['email'];
  $_SESSION['USER']['image'] = $_POST['image'];

  // Success! Inform user and refresh page after 5 seconds
  echo '<script>';
  echo 'alert("Settings updated!");';
  echo 'setTimeout(function(){location.reload()}, 5000);'; // Refresh page after 5 seconds
  echo '</script>';
}

?>