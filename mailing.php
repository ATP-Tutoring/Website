<?php // mailing.php

ini_set('display_errors', 1);

include("atp-common.php");
include("atp-db.php");



if (!isset($_POST['action'])):
  
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>ATP West Windsor-Plainsboro</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
    <!--  <a id="logo-container" href="#" class="brand-logo"><img src="img/logo.png" style="width:10%;height:10%"></img></a> -->
      <ul class="right hide-on-med-and-down">
		<li><a href="./index.html">Home</a></li>
        <li><a href="./aboutus.html">About Us</a></li>
		<li><a href="./teachingpolicy.html">Teaching Policy</a></li>
		<li><a href="./contact.html">Contact</a></li>
    <li><a href="./tutoring.html">Manage Tutoring</a></li>
		<li class="active"><a href="#">Register for Mailing List</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="#">Navbar Link</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <div id="index-banner" class="container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
		
        <h1 class="header center blue-text">Mailing List</h1>
        <div class="row center">
          <h5 class="header col s12 light blue-text">We strongly recommend that all students join our mailing list. We might need to send important information about ATP to all students, and the mailing list will help us do so. You can remove yourself from the list at any time.</h5>
        </div>
        <br><br>

      </div>
    </div>
    <div class="parallax"></div>
  </div>


  <div class="container">
    <div class="section">

	  
	
	  
	   <div class="row">
        <div class="col s12 m12">
          <div class="card blue">
            <div class="card-content white-text">
              <span class="card-title">Register</span>
      			  <div class="row">
    <form class="col s12" method="post" action="">
      <div class="row">
        <div class="input-field col s6">
          <input id="first_name" name="first_name" type="text" class="validate">
          <label for="first_name">First Name</label>
        </div>
        <div class="input-field col s6">
          <input id="last_name" name="last_name" type="text" class="validate">
          <label for="last_name">Last Name</label>
        </div>
      </div>
           <div class="row">
        <div class="input-field col s12">
          <input id="email" name="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
       <button class="btn waves-effect waves-light" type="submit" name="action" style="background-color:#3c3c3c;">Register
       <i class="material-icons right">done</i>
      </button>
      
    </form>
  </div>
			  
			  </div>
          </div>
        </div>
      </div>
	  
	  
		
	  
	  

	  <div class="row">
        <div class="col s12 m12">
         
        </div>
      </div>
	  
     
            

    </div>
  </div>


  




  <footer class="page-footer blue">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Accelerated Tutoring Program (ATP) - WW-P</h5>
          <p class="grey-text text-lighten-4">We are rising juniors at West Windsor - Plainsboro High School South and offer free tutoring to enrich and accelerate student learning.</p>


        </div>

        <div class="col l3 s12">
          <h5 class="white-text">Contact</h5>
          <ul>
            <li><a class="white-text" href="mailto:akshat@atpwwp.com">Email:           akshat@atpwwp.com</a></li>
            <li><a class="white-text" href="#!">Phone:        609-906-6090</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      No Copyright (C) 2017 - ATP</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>

  <?php
else:
    // Process signup submission
    $link = dbConnect();

    if ($_POST['first_name']=='' or $_POST['last_name']==''
      or $_POST['email']=='') {
        error('At least one of the fields was left blank.\\n'.
              'Please complete them and try again.');
    }

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $fn = $_POST['first_name'];
    $ln = $_POST['last_name'];

    if (empty($email)) {
      error('The email address you entered is not valid. It must be in the xyx@xyz.xyz format.');
    }
    
    // Check for existing user with the new id

    $stmt = $link->prepare("SELECT COUNT(1) FROM accounts WHERE email = ?");
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    
     if ($count > 0) { 
           error('Your email address is already registered on our mailing list.');
    }

    $stmt->close();

   
    

    if($insertstmt = $link->prepare("INSERT INTO accounts (firstname, lastname, email) VALUES (?, ?, ?)"))
    {
      $insertstmt->bind_param("sss", $fn, $ln, $email);
      

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
      <title> Registration Complete </title>
      <meta http-equiv="Content-Type"
        content="text/html; charset=iso-8859-1" />
    </head>
    <body>
    <p><strong>Registration successful</strong></p>
    <p>
       <strong><?=$email?></strong> is now registered to receive email updates from ATP.</p>
    </body>
    </html>
    <?php
endif;
?>