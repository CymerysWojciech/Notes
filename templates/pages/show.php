<?php
$note = $params['note'] ?? null;?>
<?php if($note): ?>
    <div class="card" >
         <div class="card-body">
            <h5 class="card-title"><?php echo $note['title'] ?></h5>
            <p class="card-text"> <?php echo $note['description'] ?></p>
            <p class="card-text fst-italic"> Notatkę utworzono: <?php echo $note['created'] ?></p>
            <a href="/notes" class="card-link btn btn-secondary btn-sm m-1">Lista notatek</a>
             <a href="/notes/?action=edit&id= <?php echo $note['id'] ?>" class="card-link btn btn-secondary btn-sm m-1">Edytuj</a>
         </div>
    </div>
<?php else: ?>
<div class="alert alert-warning" role="alert">Brak notatek do wyświetlenia</div>

<?php endif;?>



