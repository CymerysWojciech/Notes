
<div class="card p-4 bg-light">
    <?php if(!empty($params['note'])):  ?>
    <?php $note = $params['note']  ?>
    <div class="h5">Edycja notatki</div>
    <div>
        <form action="/notes/index.php?action=edit" method="post">
            <div >
                <input type="hidden" name="id" id="id" value="<?php echo $note['id'] ?>" class="form-control">
            </div>
            <div >
                <label for="title" class="form-label">Tytuł</label>
                <input type="text" name="title" id="title" value="<?php echo $note['title'] ?>" class="form-control">
            </div>
            <div>
                <label for="description" class="form-label">Treść</label>
                <textarea name="description" id="description"  rows="8" class="form-control"> <?php echo $note['description']  ?></textarea>
            </div>
            <button type="submit" class="btn btn-secondary mt-2  btn-sm ">Zapisz</button>
        </form>
    </div>
    <?php else:  ?>
    <div class="alert alert-warning" role="alert">Brak danych do wyświetlenia</div>
    <?php endif; ?>
</div>