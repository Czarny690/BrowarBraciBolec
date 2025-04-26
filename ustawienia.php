<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $Avatar = "";
        $User = "";
        $Pass = "";
        $Name = "";
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
            if (!empty($row['Avatar'])) {
                $Avatar = "<img src='" . htmlspecialchars($row['Avatar']) . "' alt='Avatar' width='150'>";
                $User = htmlspecialchars($row['User']);
                $Pass = htmlspecialchars($row['Password']);
                $Name = htmlspecialchars($row['Name']);
                
            } else {
                $Avatar= "Brak avatara.";
            }
        } else {
            $Avatar = "Nie znaleziono użytkownika.";
        }
    ?>
    <form method="post">
        Login: <input type="text" name="login" value=<?php echo "$User";?>><br>
        Hasło:<input type="text" name="pass"  value=<?php echo "$Pass";?>><br>
        Nazwa: <input type="text" name="name"  value=<?php echo "$Name";?>><br>
        Zmień swojego avatara:<input type="file" accept="image/*">
        <?php 
        echo $Avatar;
    ?>
    <br>
    <input type="submit" name="wyslij" value="Potwierdź zmiany">
    </form>
    <?php 
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['wyslij'])) {
            $NewU = $_POST['login'];
            $NewN = $_POST['name'];
            $NewP = $_POST['pass'];
        $q3 = "select * from `daneuzytkownikow` where User = '$NewU';";
        $result = $conn->query($q3);
        if ($result && $result->num_rows === 0 || $NewU === $login) {
            setcookie('czyZalogowany',$NewU, time()+60*60*24*30, "/");
            $q2 = "update `daneuzytkownikow` set User='$NewU', Password='$NewP', Name='$NewN' where User='$login'";
            $wynik = mysqli_query($conn, $q2);
            header("Location: strona.php");
        } else {
            echo "Ten login jest już zajęty!";
            }
        }
    }
    ?>
</body>
</html>