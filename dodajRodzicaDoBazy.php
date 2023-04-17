<?php
function czyRodzicJestWBazie($imie,$nazwisko){
    include("connection.php");
    $sql = "SELECT * FROM rodzice WHERE Imie='$imie' AND Nazwisko='$nazwisko'";
    $result = mysqli_query($connection,$sql);
    if(mysqli_num_rows($result)>0){
        return true;
    } else {
        return false;
    }
}
$imie = $_POST['imieRodzica'];
$nazwisko = $_POST['nazwiskoRodzica'];
$imieNazwiskoRegex = "/^[a-zA-Z]+$/";
session_start();
$_SESSION['rodzicInfo'] = array(
        "imie" => $imie,
        "nazwisko" => $nazwisko);
include("connection.php");
if(!preg_match($imieNazwiskoRegex,$imie)){
    header("Location: index.php?form=1&error=1");
} else if(!preg_match($imieNazwiskoRegex,$nazwisko)){
    header("Location: index.php?form=1&error=2");
} else if(czyRodzicJestWBazie($imie,$nazwisko)){
    header("Location: index.php?form=1&error=3");
}
  else {
    $sql = "INSERT INTO rodzice VALUES (NULL,'$imie','$nazwisko')";
    mysqli_query($connection,$sql);
    header("Location: rodzic-ok.php");
}
?>