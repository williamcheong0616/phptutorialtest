<?php
 if (!empty($_POST)) {
    //validate
    $info = [];

    //validate username

    if (empty($_POST['username'])) {
      $info['username'] = 'Username is required';
    } elseif (preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']) == 0) {
      $info['username'] = 'Username can only contain letters and numbers';
    }

    //validate email

    if (empty($_POST['email'])) {
      $info['email'] = 'Email is required';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
      $info['email'] = 'Email is invalid';
    } else {
      $query = "select * from users where email = :email";
      $data = ['email' => $_POST['email']];
      $result = query($query, $data);
      if ($result) {
        $info['email'] = 'Email is already taken';
      }
    }
    //validate password
    if (empty($_POST['password'])) {
      $info['password'] = 'Password is required';
    } elseif (strlen($_POST['password']) < 8) {
      $info['password'] = 'Password must be at least 8 characters or more';
    }

    //validate confirm password
    if (empty($_POST['password2'])) {
      $info['password2'] = 'Confirm password is required';
    } elseif ($_POST['password'] != $_POST['password2']) {
      $info['password2'] = 'Password does not match';
    }
    //validate image
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    if (!empty($_FILES['image']['name'])) {
      $destination = "";
      if (!in_array($_FILES['image']['type'], $allowed)) {
        $info['image'] = "File type not supported/allowed";
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

  }

	if(empty($info['errors']) && $row)
	{
		//save to database
		$arr = [];
		$arr['username'] 	= $_POST['username'];
		$arr['email'] 		= $_POST['email'];
		$arr['id'] 			= $row['id'];

        if (!empty($destination)) {
            $image_str = "image = :image, ";
            $data['image'] = $destination;
          }

		$password_query = "";
		if(!empty($_POST['password']))
		{
			$arr['password'] 	= password_hash($_POST['password'], PASSWORD_DEFAULT);
			$password_query = ",password = :password";
		}
 
		db_query("update users set username = :username,email = :email $image_str $password_query where id = :id limit 1",$arr);

		//delete old image
		if(!empty($image) && file_exists($row['image']))
		{
			unlink($row['image']);
		}

		$row = db_query("select * from users where id = :id limit 1",['id'=>$row['id']]);
		if($row)
		{
			$row = $row[0];
			$_SESSION['USER'] = $row;
		}

		$info['success'] 	= true;
	}