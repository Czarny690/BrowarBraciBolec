<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input type="submit" value="Wyloguj się" name="wyloguj">
    </form>
    <?php 
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['wyloguj'])) {
                setcookie('czyZalogowano', 0, time()-1);
                header("Location: logowanie.php");
            }
        }


    if(isset($_COOKIE['czyZalogowany'])) {
        $Uzytkownik=$_COOKIE['czyZalogowany'];
        setcookie('czyZalogowany', $Uzytkownik, time()+60*60*24*30, '/');
        echo "Cześć";
    } else {
        header("Location: logowanie.php");
    }
    ?>
</body>
</html>