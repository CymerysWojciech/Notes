<div>
    <div >
        <?php
            if(!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo '<div class="alert alert-success" role="alert">Notatka została utworzona</div>';
                        break;
                    default:
                        break;
                }
            }
        ?>
    </div>
    <div >
        <?php
        if(!empty($params['error'])) {
            switch ($params['error']) {
                case 'noteNotFound':
                    echo '<div class="alert alert-danger" role="alert">Notatka nie została znaleziona</div>';
                    break;
                case 'missingNotId':
                    echo '<div class="alert alert-danger" role="alert">Nie prawidłowa wartość Id</div>';
                    break;
                default:
                    break;
            }
        }
        ?>
    </div>
</div>
<div class="card p-4 bg-light">
    <div class="h4">Lista notatek</div>
    <div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tytuł</th>
                    <th scope="col">Data</th>
                    <th scope="col">Opcje</th>
                </tr>
                </thead>
                <tbody>

                    <?php  foreach ($params['notes'] ??[] as $note): ?>
                        <tr>
                            <td><?php echo (int)$note['id']  ?></td>
                            <td><?php echo htmlentities($note['title'])  ?></td>
                            <td><?php echo htmlentities($note['created'])  ?></td>
                            <td><a class=" btn btn-info" href="/notes/?action=show&id=<?php echo (int)$note['id'] ?>" >Szczeguły</a></td>
                         </tr>
                    <?php endforeach;?>

                </tbody>
            </table>
        </div>
    </div>
</div>