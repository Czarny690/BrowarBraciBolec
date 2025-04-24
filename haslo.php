<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/haslo.css">
</head>
<body>
    <main>
    <form method="post"  autocomplete="off">
        Wpisz hasło żeby wejść na stronę: <input type="password" name="pass"><br>
        <input type="submit" name="wyslij">
    </form>
</main>
    <?php 
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['wyslij'])) {
            if($_POST['pass'] == "bolecbrata") {
                setcookie('Haslo', true, time()+60*60*24*30*12*50);
                header("Location: strona.php");
            } else {
                echo "Błędne hasło";
            }
        }
    }
    ?>
    
</body>
</html>