<?php // createcourse.php

ini_set('display_errors', 1);

include("atp-common.php");
include("atp-db.php");



if (!isset($_POST['action'])):
  
    ?>


<!DOCTYPE html>
<html>
<body>

<p>This form will add your 'tutoring slot' to the database so people can find you on our website.</p>
<p>You may use HTML tags in your comments only, and it cannot have scripts, embeds, style properties, or any kind of malicious XSS. Tutors who violate this or abuse this form in any way will be permanently terminated.</p>

<br>
<p>Acceptable HTML tags (you may only use these:)</p>

<p> &ltb&gt, &ltbr&gt, &lti&gt, &ltu&gt</p>  


<br>

<p>The Tutor Password is required in order to prevent unauthorized access to the database. If you do not have it, please contact us.</p>
<br><br> 
<br><br>

<form method="post" action="">
  Tutor Password:<br>
  <input type="password" name="password">
  
  <br>
  Subject:<br>
  <input type="text" name="subject">
	
  <br>
  Full Name:<br>
  <input type="text" name="name">
    
  <br>
  Location (e.g. Plainsboro Library):<br>
  <input type="text" name="location">
  
  <br>
  Email (use your @atpwwp.com email if you have one):<br>
  <input type="text" name="email">
  
  <br>
  Your Comments/Availability/Prerequisites:<br>
  <input type="text" name="comments">
  

  <br><br>
  <br>
  <input type="submit" name="action" value="Submit to Database">
</form> 


</body>
</html>

<?php
else:
    // Process course submission
  $password = $_POST['password'];
  $subject = $_POST['subject'];
  $name = $_POST['name'];
  $location = $_POST['location'];
  $email = $_POST['email'];
  $comments = $_POST['comments'];




    if(!password_verify($password, '$2y$10$hS5zc82hfBnZ6muauLE74.FFqT1JDobJKys9vk5QdHU4olEjIgZjm'))
    {
      error('Incorrect password.');
    }
  


    $link = dbConnect();

    if ($password == '' or $subject == '' or $name == '' or $location == '' or $email == '' or $comments == '') {
        error('At least one of the fields was left blank.\\n'.
              'Please complete them and try again.');
    }

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (empty($email)) {
      error('The email address you entered is not valid. It must be in the xyx@xyz.xyz format.');
    }




    if($insertstmt = $link->prepare("INSERT INTO tutors (subject, name, location, email, comments) VALUES (?, ?, ?, ?, ?)"))
    {
      $insertstmt->bind_param("sssss", $subject, $name, $location, $email, $comments);
      

      if (!$insertstmt->execute())
        error('A database error occurred in processing your '.
              'submission.\\nIf this error persists, please '.
              'contact info@atpwwp.com.\\n');
    }
    else
    {
      $error = $link->errno . ' ' . $link->error;
      echo $error; 
    }
              
         
    ?>
    <!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <title> Tutor Record Complete </title>
      <meta http-equiv="Content-Type"
        content="text/html; charset=iso-8859-1" />
    </head>
    <body>
    <p><strong>Record successful</strong></p>
    <p>
       <strong>Your tutoring slot has been added to the database.</p>
    </body>
    </html>
    <?php
endif;
?>