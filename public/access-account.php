<?php


require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/forgot.php';




if (isset($_GET['email'], $_GET['token'])) {
   $email = $_GET['email'];
   $token = $_GET['token'];


   // check if the email and token match a user in the database
   if (validate_token($email, $token)) {


       // log in the user without a password
       if (login_without_password($email)) {
           // redirect to the account page
           $token = bin2hex(random_bytes(32));
  
           // set the token and email in the database
           User::set_token($email, $token);
           redirect_to('change.php');
       } else {
           redirect_to('forgot.php');
           // handle login error
       }


   } else {
       // ha
       redirect_to('login.php');
   }
}?>
