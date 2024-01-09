<!DOCTYPE html>
<html>
<head>
    <title>Usuwanie zdjęć</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post">
    Czy usunąć zdjęcie: <?= $product['name'] ?>?<br/>
    Autor zdjęcia: <?= $product['author'] ?>

    <input type="hidden" name="id" value="<?= $product['_id'] ?>">

    <div><br/>
        <a href="products" class="cancel">Anuluj</a>
        <input class="pad1" type="submit" value="Potwierdź"/>
    </div>
</form>

</body>
</html>
