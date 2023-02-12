<!doctype html>
<html>

<head>
    <title>News Layout</title>
</head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

<body class="bg-light">
    <?= view('App\Views\templates\header.php') ?>
    <div class="container">
        <?= $this->renderSection('news_content') ?>
    </div>

    <?= view('App\Views\templates\footer.php') ?>
</body>

</html>