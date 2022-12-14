<?php

 //Remote Server Database connection
 $host ='remotemysql.com';
 $db ='PL6gmPfzf9';
 $user ='PL6gmPfzf9';
 $pass ='PDfeYRdCw9';
 $charset ='utf8mb4';   



//Local Server Database connection
   //  $host ='127.0.0.1';
   //  $db ='training_quiz';
   //  $user ='root';
   //  $pass ='';
   //  $charset ='utf8mb4';




$conn = mysqli_connect("remotemysql.com", "PDfeYRdCw9", "PL6gmPfzf9", "PL6gmPfzf9");

if(!$conn)  {
    die("Connection failed: ".mysqli_connect_error());
}

?>