<?php if($action == 'add'): ?>
  <div class="col-md-6 mx-auto">
    <form method="post">
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
    <a href="<?=ROOT?>/admin/users"> 
    <button class="mt-4 w-25 btn btn-lg btn-primary float-end" type="button">Back</button>
    </a>
    <button class="mt-4 w-75 btn btn-lg btn-primary" type="submit">Register</button>
    
  </form>
  </div> 

  
<?php elseif($action == 'edit'): ?>
  <div class="col-md-6 mx-auto">
    <form method="post" enctype="multipart/form-data">
    <h1 class="h3 mb-3 fw-normal">Edit Account</h1>

      <?php if(!empty($row)):?>
                          <?php if(!empty($errors)):?>
                            <div class="alert alert-danger">Please fix the error below</div>
                            <?php endif;?>

                            <div class="my-2">
                              <label class="d-block image-preview-edit">
                                <img  class="mx-auto d-block" src="<?=get_image($row['image'])?>"  style="cursor: pointer;" width="150px" height="150px" class="rounded-circle object-fit-cover" alt="...">
                                <input onchange="display_image_edit(this.files[0]);" type="file" name="image" class="d-none">
                              </label>
                            <script>
                              function display_image_edit(file){
                                document.querySelector('.image-preview-edit img').src = URL.createObjectURL(file);
                              }
                          </script>
                            </div>

                          <div class="form-floating">
                            <input value="<?=old_value('username', $row['username']) ?>" name="username" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
                            <label for="floatingInput">Username</label>
                          </div>

                          <?php if(!empty($errors['username'])):?>
                          <div class="text-danger"><?=$errors['username']?></div>
                          <?php endif;?>

                          <div class="form-floating">
                            <input name="email" value="<?=old_value('email', $row['email'])?>" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                          </div>
                          <?php if(!empty($errors['email'])):?>
                          <div class="text-danger"><?=$errors['email']?></div>
                          <?php endif;?>
                          <div class="form-floating">
                            <input name="password" value="<?=old_value('password')?> " type="password" class="form-control" id="floatingPassword" placeholder="Password [Leave Empty if remain old password]">
                            <label for="floatingPassword">Password</label>
                          </div>
                          <?php if(!empty($errors['password'])):?>
                          <div class="text-danger"><?=$errors['password']?></div>
                          <?php endif;?>
                          <div class="form-floating">
                            <input name="password2" type="password" class="form-control" id="floatingPassword" placeholder="password2">
                            <label for="floatingPassword">Retype Password</label>
                          </div>
                          <?php if(!empty($errors['password2'])):?>
                          <div class="text-danger"><?=$errors['password2']?></div>
                          <?php endif;?>
                          <button class="mt-4 w-25 btn btn-lg btn-primary" type="submit">Save</button>
                          <a href="<?=ROOT?>/admin/users"> 
                          <button class="mt-4 w-25 btn btn-lg btn-primary float-end" type="button">Back</button>
                          </a>

              <?php else: ?>
                          <div class="alert alert-danger text-center">Record not Found!</div>
              <?php endif;?> 
        </form>
  </div> 
<?php elseif($action == 'delete'): ?>

  <div class="col-md-6 mx-auto">
    <form method="post" enctype="multipart/form-data">
    <h1 class="h3 mb-3 fw-normal">Delete Account</h1>

      <?php if(!empty($row)):?>
                          <?php if(!empty($errors)):?>
                            <div class="alert alert-danger">Please fix the error below</div>
                            <?php endif;?>

                          <div class="form-floating">
                            <div class="form-control mb-2"><?=old_value('username', $row['username']) ?></div>
                            <label for="floatingInput">Username</label>
                          </div>

                          <div class="form-floating">
                          <div class="form-control mb-2"><?=old_value('email', $row['email']) ?></div>
                            <label for="floatingInput">Email address</label>
                          </div>

                          <button class="mt-4 w-25 btn btn-lg btn-danger" type="submit">Delete</button>
                          <a href="<?=ROOT?>/admin/users"> 
                          <button class="mt-4 w-25 btn btn-lg btn-primary float-end" type="button">Back</button>
                          </a>

              <?php else: ?>
                          <div class="alert alert-danger text-center">Record not Found!</div>
              <?php endif;?> 
        </form>
  </div> 
<?php else:?>

<h4>Users
  <a href="<?=ROOT?>/admin/users/add"> 
  <button class="btn btn-primary">Add New</button> 
  </a>
</h4>
<div class="table-responsive">
<table class="table">

<tr>
    <th>#</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Image</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php

    
    $query = "SELECT * FROM users ORDER BY id DESC";
    $rows = query($query);

?>

<?php if(!empty($rows)): ?>

  <?php foreach($rows as $row): ?>

<tr>
    <td><?=$row['id']?></td>
    <td><?=esc($row['username'])?></td>
    <td><?=$row['email']?></td>
    <td><?=$row['role']?></td>
    <td>
      <img src="<?=get_image($row['image'])?>" width="75px" height="75px" class="rounded-circle object-fit-cover" alt="..."
    </td>
    <td><?=date("jS M,Y",strtotime($row['date']))?></td>
    <td>
    <a href="<?=ROOT?>/admin/users/edit/<?=$row['id']?>"> 
      <button class="btn btn-warning btn-sm text-white"><i class="bi bi-pencil-square"></i></button>
    </a>
    <a href="<?=ROOT?>/admin/users/delete/<?=$row['id']?>"> 
      <button class="btn btn-danger btn-sm text-white"><i class="bi bi-trash-fill"></i></button>
  </a>
    </td>
</tr>
  <?php endforeach; ?>
<?php endif; ?>


</table>
  </div>

<?php endif;?>