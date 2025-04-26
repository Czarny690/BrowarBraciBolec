<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tworzenie konta</title>
    <link rel="stylesheet" href="./css/login.css"/>
</head>
<body>
    <main>
        <img id="logo" src="./images/logo.png">
      <p id="napis">Utwórz swoje konto</p>
        <form method="post" autocomplete="off" style=" padding-bottom: 2rem;">
            <p>Użytkownik:</p>
            <input type="text" name="user"><br>

            <p>Hasło:</p>
            <input type="password" name="pass" style="margin-bottom: 1rem;"><br>

            <p>Imię / nazwa:</p>
            <input type="text" name="name" style="margin-bottom: 3rem;"><br>

            <input type="submit" name="wyslij" value="Utwórz konto">
            <p>Masz już konto?</p>
            <input type="submit" name="log" value="Zaloguj się">
        </form>

        <aside id="komunikat2"></aside>

    </main>

    <?php 
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $dbname = 'moja_baza';
        $conn = new mysqli($host, $user, $pass, $dbname);
        $wiadomosc = "";

        function dodajDoBazy($User, $Pass, $Name, $Avatar, $conn) {
            $q = "INSERT INTO `daneuzytkownikow` (User, Password, Name, Avatar) VALUES ('$User', '$Pass', '$Name', '$Avatar');";
            mysqli_query($conn, $q);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['log'])) {
                header("Location: logowanie.php");
                exit();
            }

            if (isset($_POST['wyslij'])) {
                $User = $_POST['user'];
                $Pass = $_POST['pass'];
                $Name = $_POST['name'];
                $random = rand(1, 5);
                $Avatar = "/php/images/av$random.png";
                if (!empty($User) && !empty($Pass) && !empty($Name)) {
                    $q2 = "SELECT * FROM `daneuzytkownikow` WHERE `User` = '$User';";
                    $wynik = mysqli_query($conn, $q2);
                    if (mysqli_num_rows($wynik) == 0) {
                        dodajDoBazy($User, $Pass, $Name, $Avatar, $conn);
                        setcookie('czyZalogowany', $User, time()+60*60*24*30, '/');
                        header("Location: strona.php");
                        exit();
                    } else {
                        $wiadomosc = "Nazwa użytkownika jest już zajęta.";
                    }
                } else {
                    $wiadomosc = "Wpisz wszystkie pola!";
                }
            }

            echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    const komunikat = " . json_encode($wiadomosc) . ";
                    document.getElementById('komunikat2').innerText = komunikat;
                });
            </script>";
        }
    ?>
</body>
</html>
