<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="./css/strona.css">
    </head>
    <body>
        <aside class="menu">
        <nav>
         <a href="pizda">kurwa</a>
         <a href="pizda">kutas</a>
         <a href="pizda">chuj</a>
         <a href="pizda">pizda</a>
         <a href="pizda">elo</a>
        </nav>
        </aside>
    <form method="post">
        <input type="submit" value="Wyloguj się" name="wyloguj">
    </form>

    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['wyloguj'])) {
            setcookie('czyZalogowany', '', time()-1, '/');
            header("Location: logowanie.php");
            exit;
        }
    }

    if(!isset($_COOKIE['Haslo'])) {
        header("Location: haslo.php");
        exit;
    } else {
        if(isset($_COOKIE['czyZalogowany'])) {
            $Uzytkownik = $_COOKIE['czyZalogowany'];
            setcookie('czyZalogowany', $Uzytkownik, time() + 60*60*24*30, '/'); 

        } else {
            header("Location: logowanie.php");
            exit;
        }
    }
    ?>


<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'moja_baza';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}
$login = $_COOKIE['czyZalogowany'];
$q = "SELECT * FROM `daneuzytkownikow` WHERE `User` = '$login'";
$result = $conn->query($q);

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    echo "Zalogowano jako: " . htmlspecialchars($row['User']) . "<br>";
    
    if (!empty($row['Avatar'])) {
        echo "<img src='" . htmlspecialchars($row['Avatar']) . "' alt='Avatar' width='150'>";
        
    } else {
        echo "Brak avatara.";
    }
} else {
    echo "Nie znaleziono użytkownika.";
}
       ?>
</body>
</html>
