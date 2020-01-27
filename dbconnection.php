<?php
 $dsn="loginsystem";
 $username="root";
 $password="";
 try{
    #$db= new PDO('mysql:host=localhost;dbname='.$dsn,$username,$password);
    $conn = new PDO("mysql:host=localhost;dbname=$dsn", $username, $password);
    #$conn = new mysqli("localhost", $username, $password, $dsn);
 }catch(PDOException $e){
    $errormessage=$e->getMessage();
    echo "Conection Denied";
    exit();
 }
?>
