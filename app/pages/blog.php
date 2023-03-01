
<?php 
        
        include '../app/pages/includes/header.php';

        ?>
<div class="mx-auto col-md-10">
        <h3 class="mx-4">Current Events</h3>
        <div class="row mb-2 justify-content-center">

        <?php
          $limit = 10;
          $offset = ($PAGE['page_number'] - 1) * $limit;    

        $query = "select posts.*,categories.category from posts join categories on posts.category_id = categories.id order by id desc limit $limit offset $offset";
        $rows= query($query);

        if($rows){
            foreach($rows as $row){
                include '../app/pages/includes/post-card.php';
            }
        }else{
            echo "No posts found";
        }


        ?>

        <div class="col-md-12 mb-4">
            <a href="<?= $PAGE['first_link'] ?>">
                <button class="btn btn-primary">First Page</button>
            </a>
            <a href="<?= $PAGE['prev_link'] ?>">
                <button class="btn btn-primary">Prev Page</button>
            </a>
            <a href="<?= $PAGE['next_link'] ?>">
                <button class="btn btn-primary float-end">Next Page</button>
            </a>
            </div>
            </div> 
            </div>           
        <?php 
        
        include '../app/pages/includes/footer.php';

        ?>
