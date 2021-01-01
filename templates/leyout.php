<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/fontello.css">
    <title>Notes</title>
</head>
<body>
<div class="container">
    <div class="bg-secondary mt-3 rounded-3">
        <p class="text-center text-light fs-2 fw-light p-1 " style="letter-spacing: 20px">NOTES</p>
    </div>
    <div class="row">
        <div class="col-2">
            <div><a href="/notes" class="link-secondary" style="text-decoration: none;">Lista notatek</a></div>
            <div><a href="/notes?action=create" class="link-secondary" style="text-decoration: none;">Nowa notatka</a></div>
        </div>
        <div class="col">
          <?php  require_once "templates/pages/$page.php" ?>
        </div>
    </div>
    <div class="bg-secondary mt-3 rounded-3">
        <p class="text-center text-light fw-light p-1 ">Created Wojciech Cymerys | All rights reserved</p>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

</body>
</html>