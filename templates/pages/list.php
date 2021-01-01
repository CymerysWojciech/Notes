<link rel="stylesheet" href="../../../Notes/css/fontello.css">
<?php

$sort = $params['sort'] ?? [];
$by = $sort['by'] ?? 'title';
$order = $sort['order'] ?? 'desc';

$page = $params['page'] ?? [];
$size = $page['size'] ?? [];
$currentPage = $page['number'] ?? 1;
$pages = $page['pages'] ?? 1;
$phrase = $params['phrase'] ?? null;

$paginationUrl = "&phrase=$phrase&pagesize=$size?sortby=$by&sortorder= $order ";

?>

<div>
    <div >
        <?php
            if(!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo '<div class="alert alert-success" role="alert">Notatka została utworzona</div>';
                        break;
                    case 'edited':
                        echo '<div class="alert alert-success" role="alert">Notatka została zaktualizowana</div>';
                        break;
                    case 'deleted':
                        echo '<div class="alert alert-success" role="alert">Notatka została usunięta</div>';
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
    <form action="/notes/" method="get">
        <div class="row">
            <div class="h4 col-8">
                Lista notatek
            </div>
            <div class="col-4">
                <label><i class="icon-search " style="font-size: 25px"></i> <input type="text" name="phrase" value="<?php  echo $phrase?>"></label>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Data</th>
                        <th scope="col">Opcje</th>
                    </tr>
                </thead>
                <tbody>

                    <?php  foreach ($params['notes'] ??[] as $note): ?>
                        <tr>
                            <td><?php echo $note['title'] ?></td>
                            <td class="fst-italic"><?php echo $note['created']  ?></td>
                            <td>
                                <a class=" btn btn-success btn-sm m-1" href="/notes/?action=show&id=<?php echo (int)$note['id'] ?>" >Szczeguły</a>
                                <a class=" btn btn-danger btn-sm m-1" href="/notes/?action=delete&id=<?php echo (int)$note['id'] ?>" >Usuń</a>
                            </td>
                        </tr>
                    <?php endforeach;?>

                </tbody>
            </table>
        </div>

        <div class="card p-3">
            <div class="row">
                <div class="col-4 mt-1">
                    <select class="form-select form-select-sm" aria-label="Ilość notatek" name="pagesize">
                        <option selected value=<?php echo $size?>>Ilość notatek</option>
                        <option value="1">1</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                </div>
                <div class="col mt-1">
                    <nav>
                            <ul class="pagination pagination-sm">
                                <li class="page-item <?php if($currentPage<=1){echo "disabled"; }  ?>">
                                    <a class="page-link " href="/notes/?page=<?php echo $currentPage-1 . $paginationUrl  ?>" > <- </a>
                                </li>
                                <?php for($i = 1; $i<= $pages;$i++):   ?>
                                    <li class="page-item  <?php if($currentPage==$i){echo "disabled"; }  ?>">
                                        <a class="page-link"
                                           href="/notes/?page=<?php echo $i.$paginationUrl  ?>">
                                            <?php echo $i  ?>
                                        </a>
                                    </li>
                                <?php endfor ?>

                                <li class="page-item <?php if($currentPage>=$pages){echo "disabled"; }  ?>">
                                    <a class="page-link " href="/notes/?page=<?php echo $currentPage+1 . $paginationUrl  ?>" > -> </a>
                                </li>
                            </ul>
                        </nav>
                </div>
                <div >
                        <div style="display: inline; margin-right: 20px" >
                            Sortuj po:
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sortby" value="title" <?php echo $by === 'title' ? 'checked':'' ?>>
                                <label class="form-check-label">tytule</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sortby" value="created"  <?php echo $by === 'created' ? 'checked':'' ?>>
                                <label class="form-check-label" >dacie</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sortorder" value="asc" <?php echo $order === 'asc' ? 'checked':'' ?>>
                                <label class="form-check-label" >rosnąco</label>
                            </div>
                            <div class="form-check form-check-inline" >
                                <input class="form-check-input" type="radio" name="sortorder" value="desc" <?php echo $order === 'desc' ? 'checked':'' ?>>
                                <label class="form-check-label" >malejąco</label>
                            </div>
                        </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm col-3 m-2">Wyślij</button>
            </div>
        </div>
    </form>
</div>