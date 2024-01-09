<!DOCTYPE html>
<html>
<head>
    <title>Dodawanie zdjęć</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <label>
        <span>Nazwa zdjecia:</span>
        <input type="text" name="name" value="<?= $product['name'] ?>" required/>
    </label>
    <label>
        <span>Autor:</span>
        <input type="text" name="author" value="<?= $product['author'] ?>" required/>
    </label>
    <label>
        <span>Plik:</span>
        <input type="file" name="file" required/>
    </label>
    <label>
        <span>Znak wodny:</span>
        <input type="text" name="watermark" required/>
    </label>
    

    <!-- <textarea name="description" placeholder="Opis..."><? //=$product['description'] ?></textarea> -->

    <input type="hidden" name="id" value="<?= $product['_id'] ?>">

    <div>
        <a href="products" class="cancel">Anuluj</a>
        <span class="pad3"><input class="button" type="submit" value="Zapisz"/></span>
    </div>
</form>

</body>
</html>
