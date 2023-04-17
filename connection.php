<?php
           $connection = mysqli_connect("localhost","root","","przedszkole");
            if (mysqli_connect_errno()) {       
                echo "Błąd połączenia nr: " . mysqli_connect_errno();       
                echo "Opis błędu: " . mysqli_connect_error();       
                exit(); 
            }
        mysqli_query($connection, 'SET NAMES utf8'); 
        mysqli_query($connection, 'SET CHARACTER SET utf8'); 
        mysqli_query($connection, "SET collation_connection = utf8_polish_ci"); 
?>