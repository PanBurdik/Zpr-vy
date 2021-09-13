<?php


$conn = new PDO('mysql:host=localhost;dbname=zpravy', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$conn->query('SET NAMES utf8');

session_start();

$dotaz = 'SELECT *,au.ID as id_autor, k.ID as id_kategorie,a.ID as id_article FROM article a inner join autor au on a.id_autor = au.ID inner join kategorie k on a.id_kategorie = k.ID ORDER by datum desc LIMIT 5 ';
$stmt = $conn->prepare($dotaz);
$stmt->execute();

$article = $stmt->fetchAll();



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" >
    <title>Zprávy</title>
</head>
<body>
<header>
    <div>
        <h1>Zprávy pro všechny gurmány</h1>
        <div>
            <a href="index.php">Zprávy</a>
            <a href="Kategorie.php">Kategorie</a>
            <a href="Autori.php">Autoři</a>
            <?php if (isset($_SESSION['user'])): ?>
            <a href="Administrace.php">Administrace článků</a>
            <a href="pridat_clanek.php">Přidat článek</a>
            <?php endif; ?>
            <a href="login.php">Přihlásit se</a>
            <a href="register.php">Registrace</a>
        </div>
    </div>
</header>
<?php if (isset($_SESSION['user'])): ?>
    Uživatel
    <br>
    <?= $_SESSION['user']['name'] ?>
    <br>
    <a href="logout.php">Odhlásit</a>
<?php else: ?>
Uživatel nepřihlášen
<?php endif; ?>
<nav>
    <?php foreach ($article as $zprava): ?>
    <h1><a href="Article.php?id=<?= $zprava['id_article']?>"><?= $zprava['title']?></a></h1>
    <h2>
        <?= $zprava['perex']?>
    </h2>
    <h3>Datum: <?= date("d.m.Y h:m",strtotime($zprava['datum']))?></h3>
    <nav>
        <a href="vypis.php?id_kategorie=<?= $zprava['id_kategorie']?>">Kategorie: <?= $zprava['Kategorie']?></a>
        <a href="vypis.php?id_autor=<?= $zprava['id_autor']?>">Autor: <?= $zprava['name']?></a>
    </nav>
    <br>
    <br>
    <br>
    <hr>
    <?php endforeach; ?>
</nav>
</body>
</html>
