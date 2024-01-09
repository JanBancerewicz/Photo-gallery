<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post">
    Podaj dane użytkownika:<br/>


    <label>
        <span>Login:</span>
        <input type="text" name="user" required/><br/>
    </label>
    <label>
        <span>Hasło:</span>
        <input type="password" name="pass" required /><br/>
    </label>
    <div>
        <a href="products" class="cancel">Anuluj</a>
        <span class="pad3"><input class="button" type="submit" value="Potwierdź"/></span>
    </div>
</form>

</body>
</html>
