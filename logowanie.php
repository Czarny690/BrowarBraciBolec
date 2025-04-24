<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <form method="post">
            Nazwa użytkownika: 
            <input type="text" name="user"><br>
            Hasło: 
            <input type="password" name="password"><br>
            <input type="submit" name="wyslij" value="Zaloguj się">
            <p>Nie masz jeszcze konta? </p>
            <input type="submit" name="utworzKonto" value="Utwórz konto">
        </form>

        <?php 
        $host = 'localhost';
        $user='root';
        $pass='';
        $dbname='moja_baza';
        
        $conn=new mysqli($host, $user, $pass, $dbname);

        function powitaj($user) {
            echo "Witaj $user";
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['wyslij'])) {
                $uzytkownik = $_POST['user'];
                $haslo = trim($_POST['password']);
                if(!empty($uzytkownik) && !empty($haslo)) {
                    $q = "select * from `daneuzytkownikow` where `User` = '$uzytkownik'";
                    $wynik = mysqli_query($conn, $q);
                    if (mysqli_num_rows($wynik) == 1) {
                        $row = mysqli_fetch_assoc($wynik);
                        $haslo_z_bazy = trim($row['Password']);
                        if ($haslo_z_bazy === $haslo) {
                           setcookie('czyZalogowany', $uzytkownik, time()+60*60*24*30, '/');
                           header('Location: strona.php');
                        } else {
                            echo "Błędne hasło.";
                        }
                    } else {
                        echo "Nie znaleziono użytkownika.";
                    }
                    //header("Location: strona.php");
                } else {
                    echo "wpisz wszystkie pola!";
                }
            }
            if (isset($_POST['utworzKonto'])) {
                header("Location: newUser.php");
            }
        }
        ?>
        
</body>
</html>