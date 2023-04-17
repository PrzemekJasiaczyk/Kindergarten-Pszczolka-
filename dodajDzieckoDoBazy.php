<?php
function czyPeselJestPoprawny($pesel){
    if(strlen($pesel) != 11){
        return false;
    } else{
        $wagi = array(1,3,7,9,1,3,7,9,1,3);
        $suma = 0;
        for($i = 0;$i<10;$i++){
            $iloczyn = intval($pesel[$i]*$wagi[$i]);
            if($iloczyn>9) $iloczyn = $iloczyn%10;
            $suma+= $iloczyn;
        }
        if($suma>9) $suma = $suma%10;
        $wartoscKontrolna = 10 - $suma;
        if($wartoscKontrolna == $pesel[10]){
            return true;
        } else {
            return false;
        }
    }
}
function czyDataUrodzeniaMiesciSieWPrzedziale($pesel){
    $dwieOstatnieCyfryZRoku = substr($pesel,0,2);
    $indeksStulecia = substr($pesel,2,2);
    $indeksStulecia = intval($indeksStulecia/20);
    $stulecia = array(19,20,21);
    $rokUrodzenia = $stulecia[$indeksStulecia].$dwieOstatnieCyfryZRoku;
    if($rokUrodzenia >= 2014 && $rokUrodzenia <= 2018){
        return true;
    } else {
        return false;
    }
}
function czyDzieckoJestWbazie($imie,$nazwisko,$pesel,$grupaId,$rodzicId){
    include("connection.php");
    $sql = "SELECT * FROM dzieci WHERE PESEL='$pesel'";
    $result = mysqli_query($connection,$sql);
    if(mysqli_num_rows($result)>0){
        return true;
    } else {
        return false;
    }
}
$imie = $_POST['imieDziecka'];
$nazwisko = $_POST['nazwiskoDziecka'];
$pesel = strval($_POST['peselDziecka']);
$grupaId = $_POST['grupaDziecka'];
$rodzicId = $_POST['rodzicDziecka'];
session_start();
include("connection.php");
$_SESSION['dzieckoInfo'] = array(
    "imie" => $imie,
    "nazwisko" => $nazwisko,
    "pesel" => $pesel,
    "grupaId" => $grupaId,
    "rodzicId" => $rodzicId);
$imieNazwiskoRegex = "/^[a-zA-Z]+$/";
if(!preg_match($imieNazwiskoRegex,$imie)){
    header("Location: index.php?form=2&error=4");
} else if(!preg_match($imieNazwiskoRegex,$nazwisko)){
    header("Location: index.php?form=2&error=5");
} else if(!czyPeselJestPoprawny($pesel)){
    header("Location: index.php?form=2&error=6");
} else if(!czyDataUrodzeniaMiesciSieWPrzedziale($pesel)){
    header("Location: index.php?form=2&error=7");
} else if(czyDzieckoJestWbazie($imie,$nazwisko,$pesel,$grupaId,$rodzicId)){
    header("Location: index.php?form=2&error=8");
} else {
    $sql = "INSERT INTO dzieci VALUES (NULL,'$imie','$nazwisko','$pesel',$grupaId,$rodzicId)";
    mysqli_query($connection,$sql);
    echo mysqli_error($connection);
    header("Location: dziecko-ok.php");
}
?>