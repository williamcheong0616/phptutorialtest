<?php

if (!logged_in()) {
    redirect('login');
}

$id = $_GET['id'] ?? $_SESSION['USER']['id'];

$row = db_query("select * from users where id = :id limit 1", ['id' => $id]);

if ($row) {
    $row = $row[0];
}

$errors = [];

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
if (!empty($destination)) {
    $image_str = "image = :image ";
    $data['image'] = $destination;


    $data['id'] = $id;
    
    $query = "update users set $image_str where id = :id limit 1";
    query($query, $data);
    $_SESSION['USER']['image'] = $destination;


}

if($_POST == true && empty($errors)) {
    echo '<script>window.location.reload();</script>';
}

?>



<div class="col-md-6 mx-auto">
    <form method="post" enctype="multipart/form-data">
        <h1 class="h3 mb-3 fw-normal text-center mx-auto">Edit Profile Picture</h1>
        <div class="my-2">
            <label class="d-block image-preview-edit">
                <img class="mx-auto d-block rounded" src="<?=get_image(user('image'))?>" style="cursor: pointer;" width="350px" height="350px" class="rounded-circle object-fit-cover" alt="...">
                <input onchange="display_image_edit(this.files[0]);" type="file" name="image" class="d-none">
            </label>
            <script>
                function display_image_edit(file) {
                    document.querySelector('.image-preview-edit img').src = URL.createObjectURL(file);
                }
            </script>
        </div>
        <div class="my-2">
            <button class="w-100 btn btn-lg btn-primary" type="submit">Save</button>
        </div>
    </form>
</div>
