<div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?=get_image(user('image'))?>" alt="Admin" class="rounded-circle" width="200" height="200">
                    <div class="mt-3">
                      <h4><?=user('username')?></h4>
                      <p class="text-secondary mb-1"><?=user('email')?></p>
                    </div>
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
                    <?=user('username')?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=user('email')?>
                    </div>
                  </div>

    
              </div>



            </div>
          </div>
</div>
</main>