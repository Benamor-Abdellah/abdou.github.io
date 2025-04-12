<?php
 $host ="localhost";
 $username="root";
 $password="";
 $dbname="proje";

 $conn = mysqli_connect($host, $username, $password, $dbname);
 if(isset($conn)){
    echo" ";
 }
 else{
    echo"فشل الاتصال ";
 }
 ?>