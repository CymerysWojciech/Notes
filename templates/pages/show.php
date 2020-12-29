<?php
$note = $params['note'] ?? null;?>
<?php if($note): ?>
    <div class="card" >
         <div class="card-body">
            <h5 class="card-title"><?php echo htmlentities($note['title']) ?></h5>
            <p class="card-text"> <?php echo htmlentities($note['description']) ?></p>
            <a href="/notes" class="card-link btn btn-secondary ">Lista notatek</a>
         </div>
    </div>
<?php else: ?>

<?php endif;?>



