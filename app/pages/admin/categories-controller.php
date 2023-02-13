<?php



if($action == 'add')
{
  if(!empty($_POST)){
 //validate
  $errors = [];
  
  //validate username

  if(empty($_POST['category']))
  {
    $errors['category'] = 'Category is required';
  }
  elseif(preg_match("/^[a-zA-Z0-9 \-\_\&]]+$/", $_POST['category']) == 0)
  {
    $errors['category'] = 'Yeet wrong shit';
  }

  $slug = str_to_url($_POST['category']);

  //validate categoriesl
$query = "select id from categories where slug = :slug limit 1";
$slug = query($query, ['slug'=>$slug]);

  if($slug){
    $slug .= rand(1000,9999);
  }

       if(empty($errors))
       {
         //save to database
         $data = [];
         $data['category'] = $_POST['category'];
         $data['slug']    = $slug;
         $data['disabled']     = $_POST['disabled'];

         $query = "insert into categories (category, slug, disabled) values (:category, :slug, :disabled)";
         
         query($query, $data);

         redirect('admin/categories');

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
            resize_image($destination);
          }
        }

  if(empty($errors))
  {
    //update to database
    $data = [];
    $data['username'] = $_POST['username'];
    $data['email'] = $_POST['email'];
    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $data['role'] = $_POST['role'];
    $data['id'] = $id;

    if(!empty($destination))
    {
      $image_str = "image = :image, ";
      $data['image']       = $destination;
    }
    
    if(empty($_POST['password']))
    {
      $query = "update users set username = :username, email = :email, password= :password, $image_str role = :role where id = :id limit 1";
    }
    else
    {
      
      $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $query = "update users set username = :username, email = :email, password= :password, $image_str role = :role where id = :id limit 1";
    }

    $query = "update users set username = :username, email = :email, password= :password, $image_str role = :role where id = :id limit 1";
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

        if(file_exists($row['image']))
        {
          unlink($row['image']);
        }
        redirect('admin/users');

      }
    }
  }
}

?>