


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
                        <a href="<?=ROOT?>/profile/profile-edit">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                            data-bs-target="#editProfile">Edit
                            Profile</button>
                            </a>
                        <button class="btn btn-danger btn-sm ">Delete Account</button>





                    </div>
                </div>
            </div>


        </div>


    </div>



</div>
</div>
</div>




</main>