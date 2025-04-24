<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="post">
        Użytkownik: <input type="text" name="user"><br>
        Hasło: <input type="password" name="pass"><br>
        Nazwa: <input type="text" name="name"><br>
        <input type="submit" name="wyslij" value="Utwórz konto">
    </form>
    <?php 
         $host = 'localhost';
         $user='root';
         $pass='';
         $dbname='moja_baza';
         
         $conn=new mysqli($host, $user, $pass, $dbname);
         function dodajDoBazy($User, $Pass, $Name, $conn) {
            $q="insert into `daneuzytkownikow`(User, Password, Name) values('$User', '$Pass', '$Name');";
            mysqli_query($conn, $q);
        }

         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['wyslij'])) {
                $User = $_POST['user'];
                $Pass = $_POST['pass'];
                $Name = $_POST['name'];
                if(!empty($User) && !empty($Pass) && !empty($Name)) {
                    $q2 = "select * from `daneuzytkownikow` where `User` = '$User';";
                    $wynik = mysqli_query($conn, $q2);
                    if (mysqli_num_rows($wynik) == 0) {
                        dodajDoBazy($User, $Pass, $Name, $conn);
                        setcookie('czyZalogowany', $User, time()+60*60*24*30, '/');
                        header("Location: strona.php");
                    } else {
                        echo "Nazwa użytkownika jest już zajęta";
                    }
                    } else {
                        echo "wpisz wszystkie pola!";
                }
            }
            
        }
    ?>
</body>
</html>