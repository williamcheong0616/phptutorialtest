<?php



if($action == 'add')
{
  if(!empty($_POST)){
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

elseif($action == 'edit')
{
    
    $query = "select * from users where id = :id limit 1";
    $row = query_row($query, ['id'=>$id]);

    if(!empty($_POST))
    {

      if($row)
      {

        //validate
        $errors = [];

  if(empty($_POST['username']))
  {
    $errors['username'] = 'Username is required';
  }
  elseif(preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']) == 0)
  {
    $errors['username'] = 'Username can only contain letters and numbers';
  }

        $query = "select id from users where email = :email && id != :id limit 1";
        $email = query($query, ['email'=>$_POST['email'],'id'=>$id]);

        if(empty($_POST['email']))
        {
          $errors['email'] = "A email is required";
        }else
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
          $errors['email'] = "Email not valid";
        }else
        if($email)
        {
          $errors['email'] = "That email is already in use";
        }

        if(empty($_POST['password']))
        {
          
        }else
        if(strlen($_POST['password']) < 8)
        {
          $errors['password'] = "Password must be 8 character or more";
        }
        //validate confirm password
          elseif($_POST['password'] != $_POST['password2'])
        {
          $errors['password2'] = 'Password does not match';
        }

        //validate image
        $allowed = ['image/jpeg','image/png','image/webp', 'image/jpg'];
        if(!empty($_FILES['image']['name']))
        {
          $destination = "";
          if(!in_array($_FILES['image']['type'], $allowed))
          {
            $errors['image'] = "File type not supported/allowed";
          }else{
            
            $folder = "uploads/";
            if(!file_exists($folder))
            {
              mkdir($folder, 0777, true);
            }

            $destination = $folder . time() . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
          }
        }

  if(empty($errors))
  {
    //update to database
    $data = [];
    $data['username'] = $_POST['username'];
    $data['email'] = $_POST['email'];
    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $data['role'] = $row['role'];
    $data['id'] = $id;

    if(empty($_POST['password']))
    {
      $query = "update users set username = :username, email= :email, password = :password, role = :role where id = :id limit 1";
    }
    else
    {
      $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $query = "update users set username = :username, email= :email, password = :password, role = :role where id = :id limit 1";
    }

    $query = "update users set username = :username, email= :email, password = :password, role = :role where id = :id limit 1";
    query($query, $data);

    redirect('admin/users');

  }
  }
}
}

else
if($action == 'delete')
{
  
  $query = "select * from users where id = :id limit 1";
  $row = query_row($query, ['id'=>$id]);

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {

    if($row)
    {

      //validate
      $errors = [];

      if(empty($errors))
      {
        //delete from database
        $data = [];
        $data['id']       = $id;

        $query = "delete from users where id = :id limit 1";
        query($query, $data);


        redirect('admin/users');

      }
    }
  }
}

?>