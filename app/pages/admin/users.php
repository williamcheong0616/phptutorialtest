
<?php if($action =='add'):?>
<div class="col-md-6 mx-auto">
    <form method="post">
    <h1 class="h3 mb-3 fw-normal text-center">Create An Account!</h1>
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
 
    <button class="mt-4 w-100 btn btn-lg btn-primary" type="submit">Create</button>
  </form>
</div>

<?php elseif($action =='edit'):?>
<?php elseif($action =='delete'):?>

<?php else:?>


<h4>Users <button class="btn btn-primary">Add New</button></h4>

<div class="table-responsive">
<table class="table">
    <tr>
        <th>#</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Image</th>
        <th>Date</th>
    </tr>

    <?php
        $query = "select * from users order by id desc";
        $rows = query($query);
    ?>

    <?php if(!empty($rows)):?>
        <?php foreach($rows as $row):?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['username']?></td>
                <td><?=$row['email']?></td>
                <td><?=$row['role']?></td>
                <td>Image</td>
                <td><?=date("jS M, Y", strtotime($row['date']))?></td>
                <td>
                    <button class="btn btn-warning"> <i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger"> <i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        <?php endforeach;?>
    <?php endif;?>
</table>
</div>

<?php endif;?>
