<div class="row gutters-sm">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?= get_image(user('image')) ?>" alt="Admin" class="rounded-circle" width="150">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= user('username') ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= user('email') ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                            data-bs-target="#editProfile">Edit
                            Profile</button>
                        <button class="btn btn-danger btn-sm ">Delete Account</button>





                    </div>
                </div>
            </div>


        </div>


    </div>



</div>
</div>
</div>
<div class="modal fade" id="editProfile" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-white">
            <div class="col-md-6 mx-auto">
                <form method="post" enctype="multipart/form-data">
                    <h1 class="h3 mb-3 fw-normal text-center">Edit Account</h1>

                    <?php

                    $row[] = query("select * from users where id = {$_SESSION['USER']['id']}")[0];
                    ?>
                    <?php if (!empty($row)): ?>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">Please fix the error below</div>
                        <?php endif; ?>

                        <div class="my-2">
                            <label class="d-block image-preview-edit">
                                <img class="mx-auto d-block" src="<?= get_image(user('image')) ?>" style="cursor: pointer;"
                                    width="150px" height="150px" class="rounded-circle object-fit-cover" alt="...">
                                <input onchange="display_image_edit(this.files[0]);" type="file" name="image" id="image"
                                    class="d-none">
                            </label>
                            <script>
                                function display_image_edit(file) {
                                    document.querySelector('.image-preview-edit img').src = URL.createObjectURL(file);
                                }
                            </script>
                        </div>

                        <div class="form-floating">
                            <input value="<?= old_value('username', $row[0]['username']) ?>" type="text"
                                class="form-control mb-2 floatingInput " id="usernameInput" placeholder="Username">
                            <label for="usernameInput">Username</label>
                        </div>

                        <?php if (!empty($errors['username'])): ?>
                            <div class="text-danger">
                                <?= $errors['username'] ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-floating">
                            <input name="email" value="<?= old_value('email', $row[0]['email']) ?>" type="email"
                                class="form-control" id="emailInput" placeholder="name@example.com">
                            <label for="emailInput">Email address</label>
                        </div>
                        <?php if (!empty($errors['email'])): ?>
                            <div class="text-danger">
                                <?= $errors['email'] ?>
                            </div>
                        <?php endif; ?>
                        <br>
                        <div class="form-floating">
                            <input name="password" value="<?= old_value('password') ?> " type="password"
                                class="form-control" id="floatingPassword"
                                placeholder="Password [Leave Empty if remain old password]">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <div class="text-danger">
                                <?= $errors['password'] ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-floating">
                            <input name="password2" type="password" class="form-control" id="floatingPassword"
                                placeholder="password2">
                            <label for="floatingPassword">Retype Password</label>
                        </div>
                        <?php if (!empty($errors['password2'])): ?>
                            <div class="text-danger">
                                <?= $errors['password2'] ?>
                            </div>
                        <?php endif; ?>
                        <button class="mt-4 w-25 btn btn-lg btn-primary" type="submit">Save</button>
                        <button class="mt-4 w-25 btn btn-lg btn-primary float-end"  data-bs-dismiss="modal" type="button">Back</button>
                    <?php endif; ?>
                </form>

                            
                <?php
        $query = "select * from users where id = :id limit 1";
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

                $query = "select id from users where email = :email && id != :id limit 1";
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
                    //update to database
                    $data = [];
                    $data['username'] = $_POST['username'];
                    $data['email'] = $_POST['email'];
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $data['role'] = $_POST['role'];
                    $data['id'] = $id;

                    if (!empty($destination)) {
                        $image_str = "image = :image, ";
                        $data['image'] = $destination;
                    }

                    if (empty($_POST['password'])) {
                        $query = "update users set username = :username, email = :email, password= :password, $image_str role = :role where id = :id limit 1";
                    } else {

                        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $query = "update users set username = :username, email = :email, password= :password, $image_str role = :role where id = :id limit 1";
                    }

                    $query = "update users set username = :username, email = :email, password= :password, $image_str role = :role where id = :id limit 1";
                    query($query, $data);
                    redirect('profile/settings');
                }
            }
        }
        ?>
            </div>
        </div>


    </div>
</div>
</div>



</main>