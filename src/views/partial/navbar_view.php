<div id="navbar">
    <h1 class='logo'>Galeria smakowitych zdjęć</h1>
    <hr/>
    <div class="containter" >

        

        <a href="products" class='navbarItem'>&#x2022; Strona główna</a>
        <a href="selected" class='navbarItem'>&#x2022; Wybrane zdjęcia</a>
        <a href="edit" class='navbarItem'>&#x2022; Dodaj zdjęcie</a>
        

        <?php if (isset($_SESSION['islogged'])): ?>
            
            <a href="logout" class='navbarItem2'>&#x2022; Wyloguj się</a>
            <?php if(isset($_SESSION['loggeduser'])):?>
                <span class="navbarItem2 pad2">Zalogowano jako: <?= $_SESSION['loggeduser']?></span>
                <?php endif?>
            <?php else:?>
            <a href="register" class='navbarItem2'>&#x2022; Zarejestruj się</a>
            <a href="login" class='navbarItem2'>&#x2022; Zaloguj się</a>
        <?php endif ?>
    </div><br/>
    <span class='clear'></span>
    <?php if (isset($_SESSION['error'])): ?>
        <?php if ($_SESSION['error']!=''): ?>
            
            <h1><?= $_SESSION['error'] ?></h1>
            <?php $_SESSION['error']='' ?>
        <?php endif ?>
    <?php endif ?>
    
    

    <br/>
    <hr/>
</div>