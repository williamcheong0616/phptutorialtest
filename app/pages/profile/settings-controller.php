

<?php
        function console_log($data)
        {
            echo '<script>';
            echo 'console.log(' . json_encode($data) . ')';
            echo '</script>';
        }
 
        console_log($_SESSION['USER']['id']);
        $query ="select * from users where id = {$_SESSION['USER']['id']}";
        $settingRow = query_row($query, ['id' => $id]);


if (!empty($_POST)) {
    console_log($settingRow);
    if ($settingRow) {

      //validate
      $errors = [];

      if (empty($_POST['username'])) {
        $errors['username'] = 'Username is required';
      } elseif (preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']) == 0) {
        $errors['username'] = 'Username can only contain letters and numbers';
      }

      $query = "select id from users where email = :email && id != :id limit 1";
      $emailRow = query_row($query, ['email' => $_POST['email'], 'id' => $settingRow['id']]);
      $email = $emailRow ? $emailRow['id'] : null;
      
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
        elseif ($_POST['password'] != $_POST['password2']) {
          $errors['password2'] = 'Password does not match';
        }

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
        }
      }

      if (empty($errors)) {
        $image_str = "";
        //update to database
        $data = [];
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data['id'] = $settingRow;

        if (!empty($destination)) {
          $image_str = "image = :image, ";
          $data['image'] = $destination;
        }

        if (empty($_POST['password'])) {
          $query = "update users set username = :username, email = :email,$image_str  where id = :id limit 1";
        } else {

          $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
          $query = "update users set username = :username, email = :email, password= :password, $image_str  where id = :id limit 1";
        }

        $query = "update users set username = :username, email = :email, password= :password, $image_str  where id = :id limit 1";
        query($query, $data);

        redirect('profile/settings');

      }
    }
  }

?>