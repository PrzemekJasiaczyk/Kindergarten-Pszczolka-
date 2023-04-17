<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Przedszkole "Pszczółka"</title>
    <link rel="stylesheet" href="rodzic-ok.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php session_start(); 
    if(!isset($_SESSION['dzieckoInfo'])){
        header("Location: index.php");
    }
    else {
        $imie = $_SESSION['dzieckoInfo']['imie'];
        $nazwisko = $_SESSION['dzieckoInfo']['nazwisko'];
        unset($_SESSION['dzieckoInfo']);
    }
    ?>
    <div id="podsumowanie">
        <i class="material-icons">check_circle_outline</i>
        <p>Pomyślinie dodano dziecko: <?php echo $imie," ",$nazwisko;?> do bazy danych!</p>
        <a href='index.php'>Przejdź do strony głównej</a>
    </div>
</body>

</html>
