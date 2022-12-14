<?php
session_start();
require 'db/conn.php';

if(isset($_GET['message'])) {
    $message = $_GET['message'];
}

if(isset($_SESSION['email'])) {
    $userEmail = $_SESSION['email'];    

    $query = 
            " SELECT `username`, `user_role`" .
            " FROM `users`" .
            " WHERE `email` = '$userEmail'";

    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($result)) {
        $userLoggedIn = $row['username'];
        $userRole = $row['user_role'];
    }
}
else {
    header("Location: http://localhost/Open_door/login.php");
}

//Acutual Questions file


if(isset($_POST['subject'])) {
    $subject = $_POST['subject'];
}
else
{
    header("Location: http://localhost/Open_door/home.php");    
    exit();
}

$query = 
    " SELECT * " .
    " FROM `training_quiz_record`" .
    " WHERE `username`='$userLoggedIn'" .
    " AND `subject`='$subject'";

$userCheck = mysqli_query($conn, $query);

$check = mysqli_num_rows($userCheck);
$message = '';
if($check > 5){
    $message.= 'You cannot take the quiz on a subject more three times per quiz session.';
    header("Location: http://localhost/Open_door/home.php?message='$message'");    
    exit();
}


$query = 
    " SELECT `question_number`, `question`, `question_image`" .
    " FROM `questions`" .
    " WHERE `subject` = '$subject'";

$result = mysqli_query($conn, $query);


?>
    <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    
    <script src="assets/src/js/script.js"></script>
    <title>The 'Inconsistent' Application</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <a class="navbar-brand" href="#">The Quiz</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="http://localhost/Open_door/home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/Open_door/check_result.php">Check Results</a>
            </li> 
            <?php 
                if($userRole < 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Open_door/upload_subject.php">Add Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Open_door/delete_subject.php">Delete Questions</a>
                    </li><li class="nav-item">
                        <a class="nav-link" href="http://localhost/Open_door/edit_subject.php">Edit Questions</a>
                    </li> <?php  
                }
            ?>                  
        </ul>
        <span class="navbar-text">
            User Logged in: <?php echo $userLoggedIn; ?>
        </span>        
        <span class="navbar-text">
            <a class="nav-link" href="logout.php">Logout</a>
        </span>
    </div>
    </nav>
                
        <div class="container" style="margin-top: 20px;">
            <h3 style="text-align: center; margin-bottom: 25px;">Test your knowledge!</h3>
            <form id="quizForm" method="post" action="quiz_handler.php" name="quizForm">
                <input type="hidden" name="userLoggedIn" value="<?php echo $userLoggedIn; ?>">
                <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                <?php
                $count = 1;
                while($row = mysqli_fetch_array($result)) {
                    
                    ?>
                    <div class="form-group row">
                        <label for="question" class="col-sm-2 col-form-label">Question <?php echo $count; ?></label>
                        <div class="col-sm-10">
                            <p><?php echo $row['question']; ?></p>
                            <p><input type="text" class="form-control" id="question_answer_<?php echo $row['question_number']; ?>" name="question_answer_<?php echo $row['question_number']; ?>"></p>
                        </div>
                        <?php
                        if($row['question_image'] != '') { ?>
                            <label for="question" class="col-sm-2 col-form-label">Question Image</label>
                            <p><div class="col-sm-10">
                                <img src="http://localhost<?php echo $row['question_image']; ?>" class="img-responsive" style="max-height: 400px;"/>
                            </div></p>
                        <?php
                        }
                        ?>
                        
                    </div>
                    <?php
                $count++;
                }
                ?>                
                        
                <div class="form-group row">
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" id="submitQuiz" name="submitQuiz">Submit Quiz</button>                
                    </div>
                </div>            
            </form>
        </div>



        <div  class="fixed-bottom" >

<p id="footer-p" class="text-center"><strong> This is A Liquid Portal construction - All Rights Reserved - Copyright &copy;  <?php echo date('Y'); ?>
 POWERED BY E-SPACE LOGIC</strong>

<!-- <a href="termsandconditions.html">|TERMS AND CONDITIONS|</a>
<a href="privacypolicy.html">|PRIVACY POLICY|</a>
<a href="sitecredits.html">|SITE CREDITS|</a>  -->
</p>

</div> 


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>







