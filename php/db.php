<?php // db.php

$dbhost = 'REDACTED';
$dbuser = 'REDACTED';
$dbpass = 'REDACTED';

function dbConnect() {
    global $dbhost, $dbuser, $dbpass;
    
    
    $dbcnx = mysqli_connect( $dbhost, $dbuser, $dbpass, 'tamu'); 

    if (!$dbcnx)
        die('The site database is unavailable.');
    
    return $dbcnx;
}
?>
