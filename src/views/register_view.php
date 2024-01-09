<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post">
    Podaj dane do rejestracji:<br/>

    <label>
        <span>Login:</span>
        <input type="text" name="login" required/><br/>
    </label>
    <label>
        <span>Email:</span>
        <input type="text" name="email" required/><br/>        
    </label>
    <label>
        <span>Hasło:</span>
        <input type="password" name="pass" required /><br/>
    </label>
    <label>
        <span>Powtórz hasło:</span>
        <input type="password" name="pass2" required /><br/>
    </label>
    

    <div>
        <a href="products" class="cancel">Anuluj</a>
        <span class="pad3"><input class="button" type="submit" value="Potwierdź"/></span>
    </div>
</form>

</body>
</html>
