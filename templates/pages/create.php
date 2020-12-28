<div>Nowa notatka</div>
<?php if($params['created']): ?>
    <div>Tytuł: <?php echo $params['title']?></div>
    <div>Treść: <?php echo $params['description']?></div>
<?php else: ?>
<form action="/notes/index.php?action=create" method="post">
<div>
<label for="title" class="form-label">Tytuł</label>
<input type="text" name="title" id="title" class="form-control">
</div>
<div>
    <label for="description" class="form-label">Treść</label>
    <textarea name="description" id="description"  rows="8" class="form-control"></textarea>
</div>
<button type="submit" class="btn btn-secondary mt-2 ">Zapisz</button>
</form>
<?php endif;?>

