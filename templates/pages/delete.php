<?php
$note = $params['note'] ?? null;?>
<?php if($note): ?>
    <div class="card" >
        <div class="card-body">
            <h5 class="card-title"><?php echo $note['title'] ?></h5>
            <p class="card-text"> <?php echo $note['description'] ?></p>
            <p class="card-text fst-italic"> Notatkę utworzono: <?php echo $note['created'] ?></p>
            <form action="/notes/?action=delete" method="post" style="display: inline-block"  >
                <input type="hidden" name="id" value=" <?php echo $note['id'] ?>">
                <button type="submit" class="card-link btn btn-danger ">Czy napewno chcesz usunąć notatkę</button>
            </form>
            <a href="/notes" class="card-link btn btn-secondary ">Powrót do listy notatek</a>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning" role="alert">Brak notatek do wyświetlenia</div>

<?php endif;?>

