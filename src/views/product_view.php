<!DOCTYPE html>
<html>
<head>
    <title>Zdjęcie</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>
<a href="products" class="cancel">&laquo; Wróć</a><br/>


<h1><?= $product['name'] ?></h1>

<p>Autor zdjecia: <?= $product['author'] ?> </p>


<a href="<?= "../../images/".$product['_id']."wm".$product['extension'] ?>" target="_blank">
    <img src="<?= "../../images/".$product['_id']."wm".$product['extension'] ?>" alt="watermarked" /> <br/>
</a>
<!-- <p class="description"><?//= $product['description'] ?></p> -->

<br/>
<!-- <a href="edit?id=<?//=$product['_id'] ?>">Edytuj</a> | -->
<a href="delete?id=<?= $product['_id'] ?>">Usuń</a>

<hr/>


<!-- <form action="cart/add" method="post" class="wide">
    <input type="hidden" name="id" value="<?//= $product['_id'] ?>"/>

    <div>
        
        <input type="submit" name="add_to_cart" value="Do koszyka"/>
    </div>
</form> -->


</body>
</html>
