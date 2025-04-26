<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weryfikacja hasła</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
<main>
    <p id="napiss">Witaj na naszej stronie, najpierw wpisz hasło by potwierdzić tożsamość.</p>
    <form method="post" autocomplete="off" style="padding-top: 5vh;">
        Wpisz hasło żeby wejść na stronę: 
        <input type="password" name="pass"><br>
        <input type="submit" name="wyslij" value="Potwierdź">
    </form>
    <aside id="komunikat" style="margin-top: 5vh; font-size: 4vh;"></aside>
</main>

<?php 
    $wiadomosc = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['wyslij'])) {
            if($_POST['pass'] == "bolecbrata") {
                setcookie('Haslo', true, time() + 60 * 60 * 24 * 30 * 12);
                header("Location: strona.php");
                exit();
            } else {
                $wiadomosc = "Błędne hasło.";
            }
        }

        // Wyświetlenie komunikatu przez JavaScript
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
