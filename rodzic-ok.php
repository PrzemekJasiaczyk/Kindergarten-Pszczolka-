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
    if(!isset($_SESSION['rodzicInfo'])){
        header("Location: index.php");
    }
    else {
        $imie = $_SESSION['rodzicInfo']['imie'];
        $nazwisko = $_SESSION['rodzicInfo']['nazwisko'];
        unset($_SESSION['rodzicInfo']);
    }
    ?>
    <div id="podsumowanie">
        <i class="material-icons">check_circle_outline</i>
        <p>Pomyślinie dodano rodzica: <?php echo $imie," ",$nazwisko;?> do bazy danych!</p>
        <a href='index.php'>Przejdź do strony głównej</a>
    </div>
</body>

</html>
