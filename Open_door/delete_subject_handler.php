<?php
session_start();
require 'db/conn.php';

if(isset($_POST['userRole'])) {
    $userRole = $_POST['userRole'];
}

if($userRole > 1) {
    header("Location: http://localhost/Open_door/home.php");    
    exit();
}

$message = '';

if(isset($_POST['submitDeleteSubject'])) {
    
    $subjects = $_POST['subjects'];   
    
    $subjects = implode("','", $subjects);

    $query = 
        " DELETE FROM `questions`" .
        " WHERE `subject` IN ('".$subjects."')";
    
    $result = mysqli_query($conn, $query);

    if($result) {
        $message.= 'The selected subjects have been deleted successfully'; 
        header("Location: http://localhost/Open_door/delete_subject.php?message='$message'");    
        exit();               
    }
    else
    {
        $message.= 'Delete error. The selected subjects have not been deleted successfully'; 
        header("Location: http://localhost/Open_door/delete_subject.php?message='$message'");    
        exit();   
    } 
     
}
else
{
    header("Location: http://localhost/Open_door/quiz.php");    
    exit(); 
}

?>






