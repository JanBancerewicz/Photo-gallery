<!DOCTYPE html>
<html>
<head>
    <title>Produkty</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>
    <?php
    include_once("partial/new_product_view.php");
    ?>

<div class="container">

    <?php
    $counter=0;
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']="";   
    }
    $cart = $_SESSION['cart'];
    ?>
    <?php if (count($products)): ?>
        <form action="cart/add" method="post">
        <h3><input class="button" type="submit" name="add_to_cart" value="&#x2022; Zapamiętaj wybrane"/></h3>
        <?php foreach ($products as $product): $counter+=1;$isChecked=0;?>
            <div class="singleItem">
                <p>Tytuł: <?= $product['name'] ?></p>
                    <a href="view?id=<?= $product['_id'] ?>">
                        <img src="<?= "../../images/".$product['_id']."min".$product['extension'] ?>" alt="miniature"/>
                    </a>
                <p>Autor: <?= $product['author'] ?></p>
                <!-- <td>
                    <a href="edit?id=<?//= $product['_id'] ?>">Edytuj</a> |
                    <a href="delete?id=<?//= $product['_id'] ?>">Usuń</a>
                </td> -->
                    <input type="hidden" name="id<?=$counter?>" value="<?= $product['_id'] ?>"/>
                    <?php if (!empty($cart)): ?>
                        <?php foreach ($cart as $id => $prod): ?>
                                <?php if($id == $product['_id'] && $prod['amount']){
                                    $isChecked=1;
                                } ?>       
                        <?php endforeach ?>
                    <?php endif ?>
                    Zaznaczenie: 
                    <input type="checkbox" name="<?=$counter?>" value="<?= $product['_id']?>" 
                    <?php if ($isChecked): ?>
                        checked
                    <?php endif ?>
                    />
            </div>
            <?php if($counter%3==0){
                require("partial/separator.php");

            }?>
        <?php endforeach ?>
        </form>
    <?php else: ?>
        Brak zdjęć
    <?php endif ?>

</div>
<hr class="clear"/>


<?php // dispatch($routing, '/cart') ?>

</body>
</html>
