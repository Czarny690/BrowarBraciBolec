<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Logowanie</title>
  <link rel="stylesheet" href="./css/login.css"/>
</head>
<body>
  <main>
      <img src="./images/logo.png">
      <p id="napis">Wpisz swój login i hasło</p>
      <form method="post" autocomplete="off">
          <p>Nazwa użytkownika:</p>
          <input type="text" name="user"><br>
          <p>Hasło:</p>
          <input type="password" name="password"><br>
          <input type="submit" name="wyslij" value="Zaloguj się">
          <p>Nie masz jeszcze konta?</p>
          <input type="submit" name="utworzKonto" value="Utwórz konto">
        </form>
        <aside id="komunikat"></aside>
  </main>

  <?php 
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'moja_baza';
    $conn = new mysqli($host, $user, $pass, $dbname);      
    $wiadomosc = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['wyslij'])) {
            $uzytkownik = $_POST['user'];
            $haslo = trim($_POST['password']);
            if (!empty($uzytkownik) && !empty($haslo)) {
                $q = "SELECT * FROM `daneuzytkownikow` WHERE `User` = '$uzytkownik'";
                $wynik = mysqli_query($conn, $q);
                if (mysqli_num_rows($wynik) == 1) {
                    $row = mysqli_fetch_assoc($wynik);
                    $haslo_z_bazy = trim($row['Password']);
                    if ($haslo_z_bazy === $haslo) {
                        setcookie('czyZalogowany', $uzytkownik, time() + 60 * 60 * 24 * 30, '/');
                        header('Location: strona.php');
                        exit();
                    } else {
                        $wiadomosc = "Błędne hasło.";
                    }
                } else {
                    $wiadomosc = "Nie znaleziono użytkownika.";
                }
            } else {
                $wiadomosc = "Wpisz wszystkie pola!";
            }
        }

        if (isset($_POST['utworzKonto'])) {
            header("Location: newUser.php");
        }

        echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
                const komunikat = " . json_encode($wiadomosc) . ";
                document.getElementById('komunikat').innerText = komunikat;
            });
        </script>";
    }
  ?>
</body>
</html>
